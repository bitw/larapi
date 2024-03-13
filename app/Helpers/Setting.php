<?php

namespace App\Helpers;

use App\Models\Setting as SettingModel;

class Setting
{
    public static function getSetting(string $name): ?SettingModel
    {
        return SettingModel::query()
            ->where('name', $name)
            ->first();
    }

    public static function getValue(string $name)
    {
        $setting = self::getSetting($name);
        return unserialize($setting->value) ?? null;
    }

    public static function exists(string $name): bool
    {
        return self::getSetting($name) !== null;
    }

    public static function set(
        string $name,
        $value,
    ): int {
        return SettingModel::query()
            ->where('name', $name)
            ->update([
                'value' => serialize($value),
            ]);
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
        SettingModel::query()
            ->where('name', $name)
            ->update(['active' => false]);
    }

    public static function enable(string $name): void
    {
        SettingModel::query()
            ->where('name', $name)
            ->update(['active' => true]);
    }
}
