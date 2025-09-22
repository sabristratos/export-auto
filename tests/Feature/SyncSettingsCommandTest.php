<?php

use App\Enums\SettingType;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('sync command creates new settings from config', function () {
    // Mock some config settings
    config(['settings.settings.site.test_setting' => [
        'type' => SettingType::Text,
        'default' => 'test_value',
        'is_public' => true,
        'description' => 'Test setting',
        'order' => 1,
    ]]);

    $this->artisan('settings:sync')
        ->expectsOutput('✅ Successfully synced 1 settings:')
        ->expectsOutput('  • test_setting')
        ->assertExitCode(0);

    expect(Setting::where('key', 'test_setting')->exists())->toBeTrue();

    $setting = Setting::where('key', 'test_setting')->first();
    expect($setting->value)->toBe('test_value');
    expect($setting->group)->toBe('site');
    expect($setting->is_public)->toBeTrue();
});

test('sync command with no new settings', function () {
    $this->artisan('settings:sync')
        ->expectsOutput('✅ All settings are already in sync.')
        ->assertExitCode(0);
});

test('sync command with force flag', function () {
    config(['settings.settings.site.test_setting' => [
        'type' => SettingType::Text,
        'default' => 'test_value',
        'is_public' => true,
        'description' => 'Test setting',
        'order' => 1,
    ]]);

    $this->artisan('settings:sync --force')
        ->expectsOutput('✅ Successfully synced 1 settings:')
        ->assertExitCode(0);
});

test('sync command preserves existing values', function () {
    // Create existing setting
    Setting::create([
        'key' => 'existing_setting',
        'value' => 'user_value',
        'type' => SettingType::Text,
        'group' => 'old_group',
        'is_public' => false,
    ]);

    // Mock config with different values
    config(['settings.settings.site.existing_setting' => [
        'type' => SettingType::Text,
        'default' => 'config_default',
        'is_public' => true,
        'description' => 'Updated description',
        'order' => 1,
    ]]);

    $this->artisan('settings:sync')
        ->assertExitCode(0);

    $setting = Setting::where('key', 'existing_setting')->first();

    // Value should be preserved
    expect($setting->value)->toBe('user_value');

    // But metadata should be updated
    expect($setting->group)->toBe('site');
    expect($setting->is_public)->toBeTrue();
    expect($setting->description)->toBe('Updated description');
});
