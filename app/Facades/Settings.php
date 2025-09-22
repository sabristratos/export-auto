<?php

namespace App\Facades;

use App\Enums\SettingType;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get(string $key, mixed $default = null)
 * @method static Setting set(string $key, mixed $value, SettingType $type = null)
 * @method static Setting|null update(string $key, mixed $value)
 * @method static bool delete(string $key)
 * @method static bool has(string $key)
 * @method static Collection getPublic()
 * @method static Collection getGroup(string $group)
 * @method static Collection getAllGrouped()
 * @method static string|null getFile(string $key, string $conversion = null)
 * @method static array syncFromConfig()
 * @method static array validateSetting(string $key, mixed $value)
 *
 * @see \App\Services\SettingsService
 */
class Settings extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'settings';
    }
}