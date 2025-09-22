<?php

use App\Enums\SettingType;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('settings helper function returns service when no key provided', function () {
    $service = settings();

    expect($service)->toBeInstanceOf(SettingsService::class);
});

test('settings helper function returns value when key provided', function () {
    Setting::create([
        'key' => 'test_setting',
        'value' => 'test_value',
        'type' => SettingType::Text,
    ]);

    expect(settings('test_setting'))->toBe('test_value');
});

test('settings helper function returns default when setting not found', function () {
    expect(settings('nonexistent_setting', 'default_value'))->toBe('default_value');
});

test('setting helper function works correctly', function () {
    Setting::create([
        'key' => 'test_setting',
        'value' => 'test_value',
        'type' => SettingType::Text,
    ]);

    expect(setting('test_setting'))->toBe('test_value');
    expect(setting('nonexistent_setting', 'default'))->toBe('default');
});

test('setting_file helper function returns file url', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('test.jpg');

    $setting = Setting::create([
        'key' => 'image_setting',
        'value' => null,
        'type' => SettingType::Image,
    ]);

    $setting->addMediaFromRequest('image')
        ->usingFileName('test.jpg')
        ->toMediaCollection('images');

    $url = setting_file('image_setting');

    expect($url)->not->toBeNull();
    expect($url)->toBeString();
});

test('setting_file helper function returns null for non-file settings', function () {
    Setting::create([
        'key' => 'text_setting',
        'value' => 'text_value',
        'type' => SettingType::Text,
    ]);

    expect(setting_file('text_setting'))->toBeNull();
});

test('has_setting helper function works correctly', function () {
    Setting::create([
        'key' => 'existing_setting',
        'value' => 'value',
        'type' => SettingType::Text,
    ]);

    expect(has_setting('existing_setting'))->toBeTrue();
    expect(has_setting('nonexistent_setting'))->toBeFalse();
});

test('public_settings helper function returns only public settings', function () {
    Setting::create([
        'key' => 'public_setting',
        'value' => 'public_value',
        'type' => SettingType::Text,
        'is_public' => true,
    ]);

    Setting::create([
        'key' => 'private_setting',
        'value' => 'private_value',
        'type' => SettingType::Text,
        'is_public' => false,
    ]);

    $publicSettings = public_settings();

    expect($publicSettings)->toHaveKey('public_setting');
    expect($publicSettings)->not->toHaveKey('private_setting');
    expect($publicSettings->get('public_setting'))->toBe('public_value');
});
