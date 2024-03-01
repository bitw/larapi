<?php

namespace App\Helpers\Setting;

use App\Exceptions\Setting\SettingDisabledException;
use App\Exceptions\Setting\SettingInvalidTypeException;
use App\Exceptions\Setting\SettingNotFoundException;
use App\Models\Setting as SettingModel;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Setting
{
    /**
     * @throws SettingNotFoundException
     */
    public static function getSetting(string $name): SettingModel
    {
        try {
            /** @var SettingModel $setting */
            $setting = SettingModel::query()
                ->where('name', $name)
                ->firstOrFail();
        } catch (ModelNotFoundException) {
            throw new SettingNotFoundException();
        }

        return $setting;
    }

    /**
     * @throws SettingDisabledException
     * @throws SettingNotFoundException
     */
    public static function getValue(string $name): float|bool|int|string|CarbonInterface
    {
        $setting = self::getSetting($name);

        if ($setting->active === false) {
            throw new SettingDisabledException();
        }

        return $setting->val;
    }

    public static function exists(string $name): bool
    {
        return SettingModel::query()
            ->where('name', $name)
            ->exists();
    }

    /**
     * @throws SettingNotFoundException
     * @throws SettingInvalidTypeException
     */
    public static function set(
        string $name,
        float|bool|int|string $value,
        ?string $type = null
    ): SettingModel {
        $setting = self::getSetting($name);

        if ($type !== null && !SettingsTypesEnum::exists($type)) {
            throw new SettingInvalidTypeException();
        }

        $type = $type === null ? $setting->type : $type;

        $setting->update([
            'value' => $value,
            'type' => $type,
        ]);

        return $setting;
    }

    /**
     * @throws SettingInvalidTypeException
     */
    public static function create(
        string $name,
        string $title,
        string $type,
        string $value,
        ?string $description = null,
    ): SettingModel {
        if (!in_array(mb_strtolower(trim($type)), SettingsTypesEnum::types())) {
            throw new SettingInvalidTypeException();
        }

        return SettingModel::create([
            'name' => $name,
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'value' => (string)$value
        ]);
    }

    /**
     * @throws SettingNotFoundException
     */
    public static function hasActive(string $name): bool
    {
        $setting = self::getSetting($name);
        return $setting->active === true;
    }

    /**
     * @throws SettingNotFoundException
     */
    public static function disable(string $name): void
    {
        $setting = self::getSetting($name);
        $setting->update(['active' => false]);
    }

    /**
     * @throws SettingNotFoundException
     */
    public static function enable(string $name): void
    {
        $setting = self::getSetting($name);
        $setting->update(['active' => true]);
    }
}
