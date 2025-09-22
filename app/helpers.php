<?php

use App\Facades\Settings;

if (! function_exists('settings')) {
    /**
     * Get a setting value by key, with optional default value.
     *
     * @param  string|null  $key  The setting key to retrieve
     * @param  mixed  $default  Default value if setting doesn't exist
     * @return mixed|\App\Services\SettingsService
     */
    function settings(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return app('settings');
        }

        return Settings::get($key, $default);
    }
}

if (! function_exists('setting')) {
    /**
     * Get a setting value by key, with optional default value.
     * Alias for settings() function.
     *
     * @param  string  $key  The setting key to retrieve
     * @param  mixed  $default  Default value if setting doesn't exist
     * @return mixed
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return Settings::get($key, $default);
    }
}

if (! function_exists('setting_file')) {
    /**
     * Get a file setting URL with optional conversion.
     *
     * @param  string  $key  The setting key
     * @param  string|null  $conversion  Media conversion name
     * @return string|null
     */
    function setting_file(string $key, ?string $conversion = null): ?string
    {
        return Settings::getFile($key, $conversion);
    }
}

if (! function_exists('has_setting')) {
    /**
     * Check if a setting exists.
     *
     * @param  string  $key  The setting key to check
     * @return bool
     */
    function has_setting(string $key): bool
    {
        return Settings::has($key);
    }
}

if (! function_exists('public_settings')) {
    /**
     * Get all public settings as key-value pairs.
     *
     * @return \Illuminate\Support\Collection
     */
    function public_settings(): \Illuminate\Support\Collection
    {
        return Settings::getPublic();
    }
}