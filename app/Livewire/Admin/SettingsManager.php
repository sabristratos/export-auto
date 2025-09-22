<?php

namespace App\Livewire\Admin;

use App\Enums\SettingType;
use App\Facades\Settings;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[layout('components.layouts.admin')]
class SettingsManager extends Component
{
    use WithFileUploads;

    public string $activeGroup = '';
    public array $settingValues = [];
    public array $fileUploads = [];
    public string $search = '';
    public bool $showCreateModal = false;
    public bool $showSyncModal = false;

    // New setting form
    public string $newSettingKey = '';
    public string $newSettingValue = '';
    public string $newSettingType = 'text';
    public string $newSettingGroup = '';
    public string $newSettingDescription = '';
    public bool $newSettingIsPublic = false;

    protected array $rules = [
        'newSettingKey' => 'required|string|max:255|unique:settings,key',
        'newSettingValue' => 'nullable',
        'newSettingType' => 'required|string',
        'newSettingGroup' => 'required|string|max:255',
        'newSettingDescription' => 'nullable|string|max:1000',
        'newSettingIsPublic' => 'boolean',
    ];

    public function mount(): void
    {
        $this->loadSettings();
        $this->setDefaultActiveGroup();
    }

    public function render()
    {
        $groupedSettings = $this->getFilteredSettings();
        $groups = $groupedSettings->keys()->sort();

        return view('livewire.admin.settings-manager', [
            'groupedSettings' => $groupedSettings,
            'groups' => $groups,
            'settingTypes' => SettingType::cases(),
        ]);
    }

    public function setActiveGroup(string $group): void
    {
        $this->activeGroup = $group;
    }

    public function updateSetting(string $key): void
    {
        $setting = Setting::where('key', $key)->first();

        if (!$setting) {
            session()->flash('error', "Setting '{$key}' not found.");
            return;
        }

        $value = $this->settingValues[$key] ?? null;

        // Handle file uploads
        if (isset($this->fileUploads[$key]) && $this->fileUploads[$key]) {
            try {
                Settings::set($key, $this->fileUploads[$key]);
                $this->fileUploads[$key] = null;
                session()->flash('success', "File setting '{$key}' updated successfully.");
            } catch (\Exception $e) {
                session()->flash('error', "Error uploading file: {$e->getMessage()}");
            }
            return;
        }

        // Validate setting value
        $validation = Settings::validateSetting($key, $value);
        if (isset($validation['errors'])) {
            session()->flash('error', "Validation failed for '{$key}': " . implode(', ', $validation['errors']));
            return;
        }

        try {
            Settings::update($key, $value);
            session()->flash('success', "Setting '{$key}' updated successfully.");
        } catch (\Exception $e) {
            session()->flash('error', "Error updating setting: {$e->getMessage()}");
        }
    }

    public function deleteSetting(string $key): void
    {
        try {
            Settings::delete($key);
            unset($this->settingValues[$key]);
            session()->flash('success', "Setting '{$key}' deleted successfully.");
            $this->loadSettings();
        } catch (\Exception $e) {
            session()->flash('error', "Error deleting setting: {$e->getMessage()}");
        }
    }

    public function createSetting(): void
    {
        $this->validate();

        try {
            $type = SettingType::from($this->newSettingType);
            $setting = Settings::set($this->newSettingKey, $this->newSettingValue, $type);

            $setting->update([
                'group' => $this->newSettingGroup,
                'description' => $this->newSettingDescription,
                'is_public' => $this->newSettingIsPublic,
            ]);

            $this->resetNewSettingForm();
            $this->showCreateModal = false;
            $this->loadSettings();

            session()->flash('success', "Setting '{$this->newSettingKey}' created successfully.");
        } catch (\Exception $e) {
            session()->flash('error', "Error creating setting: {$e->getMessage()}");
        }
    }

    public function syncFromConfig(): void
    {
        try {
            $synced = Settings::syncFromConfig();

            if (empty($synced)) {
                session()->flash('info', 'All settings are already in sync.');
            } else {
                session()->flash('success', 'Successfully synced ' . count($synced) . ' settings from configuration.');
            }

            $this->loadSettings();
            $this->showSyncModal = false;
        } catch (\Exception $e) {
            session()->flash('error', "Error syncing settings: {$e->getMessage()}");
        }
    }

    public function clearCache(): void
    {
        try {
            \Illuminate\Support\Facades\Cache::forget(config('settings.cache.key', 'site_settings'));
            session()->flash('success', 'Settings cache cleared successfully.');
        } catch (\Exception $e) {
            session()->flash('error', "Error clearing cache: {$e->getMessage()}");
        }
    }

    private function loadSettings(): void
    {
        $settings = Setting::all();
        $this->settingValues = $settings->mapWithKeys(function ($setting) {
            return [$setting->key => $setting->getTypedValue()];
        })->toArray();
    }

    private function setDefaultActiveGroup(): void
    {
        $groups = Settings::getAllGrouped()->keys();
        $this->activeGroup = $groups->first() ?: '';
    }

    private function getFilteredSettings(): Collection
    {
        $settings = Settings::getAllGrouped();

        if ($this->search) {
            $settings = $settings->map(function ($groupSettings) {
                return $groupSettings->filter(function ($setting) {
                    return str_contains(strtolower($setting->key), strtolower($this->search)) ||
                           str_contains(strtolower($setting->description ?? ''), strtolower($this->search));
                });
            })->filter(fn($group) => $group->isNotEmpty());
        }

        return $settings;
    }

    private function resetNewSettingForm(): void
    {
        $this->newSettingKey = '';
        $this->newSettingValue = '';
        $this->newSettingType = 'text';
        $this->newSettingGroup = '';
        $this->newSettingDescription = '';
        $this->newSettingIsPublic = false;
    }
}
