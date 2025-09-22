<?php

namespace App\Services;

use App\Enums\SettingType;
use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SettingsService
{
    private ?Collection $cachedSettings = null;

    public function get(string $key, mixed $default = null): mixed
    {
        $setting = $this->getCachedSettings()->firstWhere('key', $key);

        if (!$setting) {
            return $default;
        }

        return $setting->getTypedValue();
    }

    public function set(string $key, mixed $value, ?SettingType $type = null): Setting
    {
        $setting = Setting::firstOrNew(['key' => $key]);

        if ($type) {
            $setting->type = $type;
        }

        if ($value instanceof UploadedFile) {
            $this->handleFileUpload($setting, $value);
        } else {
            $setting->value = $this->normalizeValue($value, $setting->type);
        }

        $setting->save();

        $this->clearCache();

        return $setting;
    }

    public function update(string $key, mixed $value): ?Setting
    {
        $setting = Setting::where('key', $key)->first();

        if (!$setting) {
            return null;
        }

        if ($value instanceof UploadedFile) {
            $this->handleFileUpload($setting, $value);
        } else {
            $setting->value = $this->normalizeValue($value, $setting->type);
        }

        $setting->save();

        $this->clearCache();

        return $setting;
    }

    public function delete(string $key): bool
    {
        $setting = Setting::where('key', $key)->first();

        if (!$setting) {
            return false;
        }

        if ($setting->isFileType()) {
            $setting->clearMediaCollection('files');
            $setting->clearMediaCollection('images');
        }

        $deleted = $setting->delete();

        if ($deleted) {
            $this->clearCache();
        }

        return $deleted;
    }

    public function has(string $key): bool
    {
        return $this->getCachedSettings()->contains('key', $key);
    }

    public function getPublic(): Collection
    {
        return $this->getCachedSettings()
            ->where('is_public', true)
            ->mapWithKeys(fn($setting) => [$setting->key => $setting->getTypedValue()]);
    }

    public function getGroup(string $group): Collection
    {
        return $this->getCachedSettings()
            ->where('group', $group)
            ->sortBy('order')
            ->values();
    }

    public function getAllGrouped(): Collection
    {
        return $this->getCachedSettings()
            ->groupBy('group')
            ->map(fn($settings) => $settings->sortBy('order')->values());
    }

    public function getFile(string $key, ?string $conversion = null): ?string
    {
        $setting = $this->getCachedSettings()->firstWhere('key', $key);

        if (!$setting || !$setting->isFileType()) {
            return null;
        }

        return $setting->getFileUrl($conversion);
    }

    public function syncFromConfig(): array
    {
        $configSettings = Config::get('settings.settings', []);
        $synced = [];

        foreach ($configSettings as $group => $settings) {
            foreach ($settings as $key => $config) {
                $setting = Setting::firstOrNew(['key' => $key]);

                if (!$setting->exists) {
                    $setting->fill([
                        'value' => $config['default'] ?? null,
                        'type' => $config['type'] ?? SettingType::Text,
                        'group' => $group,
                        'is_public' => $config['is_public'] ?? false,
                        'description' => $config['description'] ?? null,
                        'order' => $config['order'] ?? null,
                    ]);

                    $setting->save();
                    $synced[] = $key;
                } else {
                    // Update metadata but preserve user values
                    $setting->update([
                        'group' => $group,
                        'is_public' => $config['is_public'] ?? false,
                        'description' => $config['description'] ?? null,
                        'order' => $config['order'] ?? null,
                    ]);
                }
            }
        }

        if (!empty($synced)) {
            $this->clearCache();
        }

        return $synced;
    }

    public function validateSetting(string $key, mixed $value): array
    {
        $config = $this->getSettingConfig($key);

        if (!$config) {
            return ['errors' => ['Setting not found in configuration']];
        }

        $rules = $config['validation'] ?? [];

        if (empty($rules)) {
            return ['valid' => true];
        }

        $validator = validator(['value' => $value], ['value' => $rules]);

        return $validator->fails()
            ? ['errors' => $validator->errors()->get('value')]
            : ['valid' => true];
    }

    private function getCachedSettings(): Collection
    {
        if ($this->cachedSettings !== null) {
            return $this->cachedSettings;
        }

        if (!Config::get('settings.cache.enabled', true)) {
            return $this->cachedSettings = Setting::with('media')->get();
        }

        $cacheKey = Config::get('settings.cache.key', 'site_settings');
        $cacheTtl = Config::get('settings.cache.ttl', 3600);

        return $this->cachedSettings = Cache::remember(
            $cacheKey,
            $cacheTtl,
            fn() => Setting::with('media')->get()
        );
    }

    private function clearCache(): void
    {
        $this->cachedSettings = null;

        if (Config::get('settings.cache.enabled', true)) {
            $cacheKey = Config::get('settings.cache.key', 'site_settings');
            Cache::forget($cacheKey);
        }
    }

    private function handleFileUpload(Setting $setting, UploadedFile $file): void
    {
        $collection = $setting->type === SettingType::Image ? 'images' : 'files';

        if ($setting->isFileType()) {
            $setting->clearMediaCollection($collection);
        }

        try {
            $setting->addMediaFromRequest('file')
                ->toMediaCollection($collection);

            $setting->value = $setting->getFirstMediaUrl($collection);
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            throw new \InvalidArgumentException('File upload failed: ' . $e->getMessage());
        }
    }

    private function normalizeValue(mixed $value, ?SettingType $type): mixed
    {
        if (!$type) {
            return $value;
        }

        return match ($type) {
            SettingType::Boolean => (bool) $value,
            SettingType::Integer, SettingType::Number => (int) $value,
            SettingType::Float => (float) $value,
            SettingType::Array, SettingType::Json => is_array($value) ? $value : json_decode($value, true),
            default => (string) $value,
        };
    }

    private function getSettingConfig(string $key): ?array
    {
        $configSettings = Config::get('settings.settings', []);

        foreach ($configSettings as $group => $settings) {
            if (isset($settings[$key])) {
                return $settings[$key];
            }
        }

        return null;
    }
}