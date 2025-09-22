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
            session()->flash('error', __('Setting ":key" not found.', ['key' => $key]));
            return;
        }

        $value = $this->settingValues[$key] ?? null;

        // Handle file uploads
        if (isset($this->fileUploads[$key]) && $this->fileUploads[$key]) {
            try {
                Settings::set($key, $this->fileUploads[$key]);
                $this->fileUploads[$key] = null;
                session()->flash('success', __('File setting ":key" updated successfully.', ['key' => $key]));
            } catch (\Exception $e) {
                session()->flash('error', __('Error uploading file: :message', ['message' => $e->getMessage()]));
            }
            return;
        }

        // Validate setting value
        $validation = Settings::validateSetting($key, $value);
        if (isset($validation['errors'])) {
            session()->flash('error', __('Validation failed for ":key": :errors', ['key' => $key, 'errors' => implode(', ', $validation['errors'])]));
            return;
        }

        try {
            Settings::update($key, $value);
            session()->flash('success', __('Setting ":key" updated successfully.', ['key' => $key]));
        } catch (\Exception $e) {
            session()->flash('error', __('Error updating setting: :message', ['message' => $e->getMessage()]));
        }
    }

    public function deleteSetting(string $key): void
    {
        try {
            Settings::delete($key);
            unset($this->settingValues[$key]);
            session()->flash('success', __('Setting ":key" deleted successfully.', ['key' => $key]));
            $this->loadSettings();
        } catch (\Exception $e) {
            session()->flash('error', __('Error deleting setting: :message', ['message' => $e->getMessage()]));
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

            session()->flash('success', __('Setting ":key" created successfully.', ['key' => $this->newSettingKey]));
        } catch (\Exception $e) {
            session()->flash('error', __('Error creating setting: :message', ['message' => $e->getMessage()]));
        }
    }

    public function syncFromConfig(): void
    {
        try {
            $synced = Settings::syncFromConfig();

            if (empty($synced)) {
                session()->flash('info', __('All settings are already in sync.'));
            } else {
                session()->flash('success', __('Successfully synced :count settings from configuration.', ['count' => count($synced)]));
            }

            $this->loadSettings();
            $this->showSyncModal = false;
        } catch (\Exception $e) {
            session()->flash('error', __('Error syncing settings: :message', ['message' => $e->getMessage()]));
        }
    }

    public function clearCache(): void
    {
        try {
            \Illuminate\Support\Facades\Cache::forget(config('settings.cache.key', 'site_settings'));
            session()->flash('success', __('Settings cache cleared successfully.'));
        } catch (\Exception $e) {
            session()->flash('error', __('Error clearing cache: :message', ['message' => $e->getMessage()]));
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
