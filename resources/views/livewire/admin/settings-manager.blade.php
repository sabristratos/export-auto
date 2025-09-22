<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('Settings Management') }}</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Manage your site settings and configuration') }}</p>
        </div>

        <div class="flex gap-3">
            <x-keys::button variant="secondary" wire:click="clearCache">
                {{ __('Clear Cache') }}
            </x-keys::button>

            <x-keys::button variant="secondary" wire:click="$set('showSyncModal', true)">
                {{ __('Sync Config') }}
            </x-keys::button>

            <x-keys::button wire:click="$set('showCreateModal', true)">
                {{ __('Add Setting') }}
            </x-keys::button>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <x-keys::alert variant="success">
            {{ session('success') }}
        </x-keys::alert>
    @endif

    @if (session()->has('error'))
        <x-keys::alert variant="danger">
            {{ session('error') }}
        </x-keys::alert>
    @endif

    @if (session()->has('info'))
        <x-keys::alert variant="info">
            {{ session('info') }}
        </x-keys::alert>
    @endif

    {{-- Search --}}
    <div class="max-w-md">
        <x-keys::input
            wire:model.live="search"
            placeholder="Search settings..."
            type="search"
        />
    </div>

    {{-- Main Content --}}
    <div class="flex gap-6">
        {{-- Sidebar - Groups --}}
        <div class="w-64 flex-shrink-0">
            <x-keys::card>
                <div class="p-4">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Groups</h3>
                    <nav class="space-y-1">
                        @foreach($groups as $group)
                            <button
                                wire:click="setActiveGroup('{{ $group }}')"
                                class="block w-full text-left px-2 py-1 text-sm rounded-md transition-colors
                                    {{ $activeGroup === $group
                                        ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-300'
                                        : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800' }}"
                            >
                                {{ ucfirst($group) }}
                                <span class="text-xs text-gray-500 ml-2">
                                    ({{ $groupedSettings->get($group)->count() }})
                                </span>
                            </button>
                        @endforeach
                    </nav>
                </div>
            </x-keys::card>
        </div>

        {{-- Main Settings Panel --}}
        <div class="flex-1">
            @if($activeGroup && $groupedSettings->has($activeGroup))
                <x-keys::card>
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                            {{ ucfirst($activeGroup) }} Settings
                        </h2>

                        <div class="space-y-6">
                            @foreach($groupedSettings->get($activeGroup) as $setting)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-6 last:border-b-0">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                                {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                            </label>
                                            @if($setting->description)
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                    {{ $setting->description }}
                                                </p>
                                            @endif
                                            <div class="flex gap-2 mt-2">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                    {{ $setting->type?->label() ?: $setting->type }}
                                                </span>
                                                @if($setting->is_public)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                                                        Public
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <x-keys::button
                                            variant="danger"
                                            size="sm"
                                            wire:click="deleteSetting('{{ $setting->key }}')"
                                            wire:confirm="{{ __('Are you sure you want to delete this setting?') }}"
                                        >
                                            {{ __('Delete') }}
                                        </x-keys::button>
                                    </div>

                                    <div class="flex gap-3">
                                        <div class="flex-1">
                                            @switch($setting->type)
                                                @case(App\Enums\SettingType::Boolean)
                                                    <x-keys::toggle
                                                        wire:model="settingValues.{{ $setting->key }}"
                                                    />
                                                    @break

                                                @case(App\Enums\SettingType::Textarea)
                                                    <x-keys::textarea
                                                        wire:model="settingValues.{{ $setting->key }}"
                                                        rows="3"
                                                    />
                                                    @break

                                                @case(App\Enums\SettingType::Select)
                                                    <x-keys::select wire:model="settingValues.{{ $setting->key }}">
                                                        <option value="">{{ __('Select an option') }}</option>
                                                        {{-- Options would be loaded from config --}}
                                                    </x-keys::select>
                                                    @break

                                                @case(App\Enums\SettingType::Color)
                                                    <div class="flex gap-2">
                                                        <x-keys::input
                                                            type="color"
                                                            wire:model="settingValues.{{ $setting->key }}"
                                                            class="w-16 h-10"
                                                        />
                                                        <x-keys::input
                                                            wire:model="settingValues.{{ $setting->key }}"
                                                            placeholder="#000000"
                                                            class="flex-1"
                                                        />
                                                    </div>
                                                    @break

                                                @case(App\Enums\SettingType::File)
                                                @case(App\Enums\SettingType::Image)
                                                    <div class="space-y-3">
                                                        @if($setting->getFileUrl())
                                                            <div>
                                                                @if($setting->type === App\Enums\SettingType::Image)
                                                                    <img
                                                                        src="{{ $setting->getFileUrl('thumb') ?: $setting->getFileUrl() }}"
                                                                        alt="{{ __('Current image') }}"
                                                                        class="w-20 h-20 object-cover rounded-lg border"
                                                                    />
                                                                @else
                                                                    <a
                                                                        href="{{ $setting->getFileUrl() }}"
                                                                        target="_blank"
                                                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                                                    >
                                                                        View current file
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        <x-keys::input
                                                            type="file"
                                                            wire:model="fileUploads.{{ $setting->key }}"
                                                            accept="{{ $setting->type === App\Enums\SettingType::Image ? 'image/*' : '*' }}"
                                                        />

                                                        @if(isset($fileUploads[$setting->key]) && $fileUploads[$setting->key])
                                                            <div wire:loading wire:target="fileUploads.{{ $setting->key }}" class="text-sm text-blue-600">
                                                                {{ __('Uploading...') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @break

                                                @case(App\Enums\SettingType::Date)
                                                    <x-keys::input
                                                        type="date"
                                                        wire:model="settingValues.{{ $setting->key }}"
                                                    />
                                                    @break

                                                @case(App\Enums\SettingType::DateTime)
                                                    <x-keys::input
                                                        type="datetime-local"
                                                        wire:model="settingValues.{{ $setting->key }}"
                                                    />
                                                    @break

                                                @case(App\Enums\SettingType::Time)
                                                    <x-keys::input
                                                        type="time"
                                                        wire:model="settingValues.{{ $setting->key }}"
                                                    />
                                                    @break

                                                @case(App\Enums\SettingType::Email)
                                                    <x-keys::input
                                                        type="email"
                                                        wire:model="settingValues.{{ $setting->key }}"
                                                    />
                                                    @break

                                                @case(App\Enums\SettingType::Url)
                                                    <x-keys::input
                                                        type="url"
                                                        wire:model="settingValues.{{ $setting->key }}"
                                                    />
                                                    @break

                                                @case(App\Enums\SettingType::Number)
                                                @case(App\Enums\SettingType::Integer)
                                                    <x-keys::input
                                                        type="number"
                                                        wire:model="settingValues.{{ $setting->key }}"
                                                    />
                                                    @break

                                                @case(App\Enums\SettingType::Float)
                                                    <x-keys::input
                                                        type="number"
                                                        step="0.01"
                                                        wire:model="settingValues.{{ $setting->key }}"
                                                    />
                                                    @break

                                                @default
                                                    <x-keys::input
                                                        wire:model="settingValues.{{ $setting->key }}"
                                                    />
                                            @endswitch
                                        </div>

                                        <x-keys::button
                                            variant="secondary"
                                            wire:click="updateSetting('{{ $setting->key }}')"
                                        >
                                            {{ __('Update') }}
                                        </x-keys::button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </x-keys::card>
            @else
                <x-keys::card>
                    <div class="p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ $search ? __('No settings found matching your search.') : __('Select a group to view settings.') }}
                        </p>
                    </div>
                </x-keys::card>
            @endif
        </div>
    </div>

    {{-- Create Setting Modal --}}
    @if($showCreateModal)
        <x-keys::modal wire:model="showCreateModal">
            <x-slot name="title">Create New Setting</x-slot>

            <div class="space-y-4">
                <x-keys::input
                    label="Setting Key"
                    wire:model="newSettingKey"
                    placeholder="e.g., site_name"
                    required
                />

                <x-keys::select
                    label="Type"
                    wire:model="newSettingType"
                    required
                >
                    @foreach($settingTypes as $type)
                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                    @endforeach
                </x-keys::select>

                <x-keys::input
                    label="Group"
                    wire:model="newSettingGroup"
                    placeholder="e.g., site"
                    required
                />

                <x-keys::input
                    label="Default Value"
                    wire:model="newSettingValue"
                    placeholder="Default value"
                />

                <x-keys::textarea
                    label="Description"
                    wire:model="newSettingDescription"
                    placeholder="Description for admin interface"
                    rows="2"
                />

                <x-keys::toggle
                    label="Public Setting"
                    description="Allow access from frontend"
                    wire:model="newSettingIsPublic"
                />
            </div>

            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-keys::button variant="secondary" wire:click="$set('showCreateModal', false)">
                        {{ __('Cancel') }}
                    </x-keys::button>
                    <x-keys::button wire:click="createSetting">
                        Create Setting
                    </x-keys::button>
                </div>
            </x-slot>
        </x-keys::modal>
    @endif

    {{-- Sync Config Modal --}}
    @if($showSyncModal)
        <x-keys::modal wire:model="showSyncModal">
            <x-slot name="title">Sync Settings from Configuration</x-slot>

            <p class="text-gray-600 dark:text-gray-400">
                This will sync settings from your configuration file to the database.
                New settings will be created, but existing values will be preserved.
            </p>

            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-keys::button variant="secondary" wire:click="$set('showSyncModal', false)">
                        {{ __('Cancel') }}
                    </x-keys::button>
                    <x-keys::button wire:click="syncFromConfig">
                        Sync Settings
                    </x-keys::button>
                </div>
            </x-slot>
        </x-keys::modal>
    @endif
</div>
