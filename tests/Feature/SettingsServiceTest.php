<?php

use App\Enums\SettingType;
use App\Facades\Settings;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Clear cache
    Cache::forget(config('settings.cache.key', 'site_settings'));
});

test('can set and get a basic setting', function () {
    $value = Settings::set('test_key', 'test_value', SettingType::Text);

    expect($value)->toBeInstanceOf(Setting::class);
    expect($value->key)->toBe('test_key');
    expect($value->value)->toBe('test_value');
    expect($value->type)->toBe(SettingType::Text);

    expect(Settings::get('test_key'))->toBe('test_value');
});

test('returns default value when setting does not exist', function () {
    expect(Settings::get('nonexistent_key', 'default_value'))->toBe('default_value');
});

test('can update existing setting', function () {
    Settings::set('test_key', 'original_value', SettingType::Text);

    $updated = Settings::update('test_key', 'updated_value');

    expect($updated)->toBeInstanceOf(Setting::class);
    expect(Settings::get('test_key'))->toBe('updated_value');
});

test('update returns null for nonexistent setting', function () {
    expect(Settings::update('nonexistent_key', 'value'))->toBeNull();
});

test('can delete a setting', function () {
    Settings::set('test_key', 'test_value', SettingType::Text);

    expect(Settings::has('test_key'))->toBeTrue();

    $deleted = Settings::delete('test_key');

    expect($deleted)->toBeTrue();
    expect(Settings::has('test_key'))->toBeFalse();
});

test('delete returns false for nonexistent setting', function () {
    expect(Settings::delete('nonexistent_key'))->toBeFalse();
});

test('can handle boolean settings', function () {
    Settings::set('boolean_setting', true, SettingType::Boolean);

    expect(Settings::get('boolean_setting'))->toBeTrue();
    expect(Settings::get('boolean_setting'))->toBeBool();
});

test('can handle integer settings', function () {
    Settings::set('integer_setting', 42, SettingType::Integer);

    expect(Settings::get('integer_setting'))->toBe(42);
    expect(Settings::get('integer_setting'))->toBeInt();
});

test('can handle float settings', function () {
    Settings::set('float_setting', 3.14, SettingType::Float);

    expect(Settings::get('float_setting'))->toBe(3.14);
    expect(Settings::get('float_setting'))->toBeFloat();
});

test('can handle array settings', function () {
    $array = ['key1' => 'value1', 'key2' => 'value2'];
    Settings::set('array_setting', $array, SettingType::Array);

    expect(Settings::get('array_setting'))->toBe($array);
    expect(Settings::get('array_setting'))->toBeArray();
});

test('can get public settings only', function () {
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

    $publicSettings = Settings::getPublic();

    expect($publicSettings)->toHaveKey('public_setting');
    expect($publicSettings)->not->toHaveKey('private_setting');
    expect($publicSettings->get('public_setting'))->toBe('public_value');
});

test('can get settings by group', function () {
    Setting::create([
        'key' => 'site_title',
        'value' => 'My Site',
        'type' => SettingType::Text,
        'group' => 'site',
        'order' => 1,
    ]);

    Setting::create([
        'key' => 'site_description',
        'value' => 'My Description',
        'type' => SettingType::Text,
        'group' => 'site',
        'order' => 2,
    ]);

    Setting::create([
        'key' => 'email_from',
        'value' => 'admin@example.com',
        'type' => SettingType::Email,
        'group' => 'email',
        'order' => 1,
    ]);

    $siteSettings = Settings::getGroup('site');

    expect($siteSettings)->toHaveCount(2);
    expect($siteSettings->first()->key)->toBe('site_title'); // Should be ordered
});

test('can get all settings grouped', function () {
    Setting::create([
        'key' => 'site_title',
        'value' => 'My Site',
        'type' => SettingType::Text,
        'group' => 'site',
    ]);

    Setting::create([
        'key' => 'email_from',
        'value' => 'admin@example.com',
        'type' => SettingType::Email,
        'group' => 'email',
    ]);

    $grouped = Settings::getAllGrouped();

    expect($grouped)->toHaveKey('site');
    expect($grouped)->toHaveKey('email');
    expect($grouped->get('site'))->toHaveCount(1);
    expect($grouped->get('email'))->toHaveCount(1);
});

test('can handle file uploads', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('test.jpg');

    $setting = Settings::set('logo', $file, SettingType::Image);

    expect($setting->isFileType())->toBeTrue();
    expect($setting->getFirstMediaUrl())->not->toBeEmpty();
});

test('can sync settings from config', function () {
    // Mock some config settings
    config(['settings.settings.site.test_setting' => [
        'type' => SettingType::Text,
        'default' => 'test_value',
        'is_public' => true,
        'description' => 'Test setting',
        'order' => 1,
    ]]);

    $synced = Settings::syncFromConfig();

    expect($synced)->toContain('test_setting');
    expect(Settings::has('test_setting'))->toBeTrue();
    expect(Settings::get('test_setting'))->toBe('test_value');

    $setting = Setting::where('key', 'test_setting')->first();
    expect($setting->group)->toBe('site');
    expect($setting->is_public)->toBeTrue();
    expect($setting->description)->toBe('Test setting');
    expect($setting->order)->toBe(1);
});

test('sync from config preserves existing values', function () {
    // Create existing setting
    Settings::set('existing_setting', 'user_value', SettingType::Text);

    // Mock config with different default
    config(['settings.settings.site.existing_setting' => [
        'type' => SettingType::Text,
        'default' => 'config_default',
        'is_public' => false,
        'description' => 'Updated description',
        'order' => 1,
    ]]);

    Settings::syncFromConfig();

    // Value should be preserved
    expect(Settings::get('existing_setting'))->toBe('user_value');

    // But metadata should be updated
    $setting = Setting::where('key', 'existing_setting')->first();
    expect($setting->description)->toBe('Updated description');
});

test('validates setting values', function () {
    // Mock config for validation
    config(['settings.settings.site.email_setting' => [
        'type' => SettingType::Email,
        'validation' => ['required', 'email'],
    ]]);

    $validation = Settings::validateSetting('email_setting', 'invalid-email');

    expect($validation)->toHaveKey('errors');
    expect($validation['errors'])->not->toBeEmpty();

    $validation = Settings::validateSetting('email_setting', 'valid@email.com');

    expect($validation)->toHaveKey('valid');
    expect($validation['valid'])->toBeTrue();
});

test('caching works correctly', function () {
    // Enable caching
    config(['settings.cache.enabled' => true]);

    Settings::set('cached_setting', 'cached_value', SettingType::Text);

    // First call should cache the result
    $value1 = Settings::get('cached_setting');

    // Manually change database without going through service
    Setting::where('key', 'cached_setting')->update(['value' => 'changed_value']);

    // Should still return cached value
    $value2 = Settings::get('cached_setting');

    expect($value1)->toBe($value2);
    expect($value2)->toBe('cached_value');

    // Clear cache and try again
    Cache::forget(config('settings.cache.key', 'site_settings'));

    $value3 = Settings::get('cached_setting');
    expect($value3)->toBe('changed_value');
});

test('can get file urls', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('test.jpg');
    Settings::set('image_setting', $file, SettingType::Image);

    $url = Settings::getFile('image_setting');

    expect($url)->not->toBeNull();
    expect($url)->toBeString();
});

test('returns null for non-file settings when getting file url', function () {
    Settings::set('text_setting', 'text_value', SettingType::Text);

    $url = Settings::getFile('text_setting');

    expect($url)->toBeNull();
});
