<?php

declare(strict_types=1);

namespace App\Helpers\Setting;

use Carbon\CarbonImmutable;

enum SettingsTypesEnum: string
{
    case INT = 'int';
    case FLOAT = 'float';
    case BOOL = 'bool';
    case STRING = 'string';
    case DATE = 'date';
    case TIME = 'time';
    case DATETIME = 'datetime';

    public static function parse($type, $value)
    {
        if ($type === self::INT->value) {
            $value = (int)$value;
        } elseif ($type === self::FLOAT->value) {
            $value = (float)$value;
        } elseif ($type === self::BOOL->value) {
            $value = mb_strtolower(trim($value)) === 'true' || mb_strtolower(trim($value)) === '1';
        } elseif ($type === self::DATE->value) {
            $value = CarbonImmutable::parse($value)->format(config('common.formats.date'));
        } elseif ($type === self::TIME->value) {
            $value = CarbonImmutable::parse($value)->format(config('common.formats.time'));
        } elseif ($type === self::DATETIME->value) {
            $value = CarbonImmutable::parse($value)->format(config('common.formats.datetime'));
        }

        return $value;
    }

    public static function types(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function exists($type): bool
    {
        return in_array(mb_strtolower(trim($type)), self::types());
    }
}
