<?php

namespace App\Helpers;

use App\Models\Setting as SettingModel;

class Setting
{
    public static function getSetting(string $name): SettingModel
    {
        return SettingModel::query()
                ->where('name', $name)
                ->firstOrFail();
    }

    public static function getValue(string $name)
    {
        $setting = self::getSetting($name);

        return unserialize($setting->value);
    }

    public static function exists(string $name): bool
    {
        return SettingModel::query()
            ->where('name', $name)
            ->exists();
    }

    public static function set(
        string $name,
        $value,
    ): SettingModel {
        $setting = self::getSetting($name);

        $setting->update([
            'value' => serialize($value),
        ]);

        return $setting;
    }

    public static function create(
        string $name,
        string $title,
        $value,
        ?string $description = null,
    ): SettingModel {
        return SettingModel::create([
            'name' => $name,
            'title' => $title,
            'description' => $description,
            'value' => serialize($value),
        ]);
    }

    public static function hasActive(string $name): bool
    {
        $setting = self::getSetting($name);
        return $setting->active === true;
    }

    public static function disable(string $name): void
    {
        $setting = self::getSetting($name);
        $setting->update(['active' => false]);
    }

    public static function enable(string $name): void
    {
        $setting = self::getSetting($name);
        $setting->update(['active' => true]);
    }
}
