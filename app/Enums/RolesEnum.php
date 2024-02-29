<?php

declare(strict_types=1);

namespace App\Enums;

enum RolesEnum: string
{
    public const string GUARD = 'api';

    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case CUSTOMER = 'customer';

    public function label(): string
    {
        return match ($this) {
            RolesEnum::ADMIN => 'Administrator',
            RolesEnum::MANAGER => 'Manager',
            RolesEnum::CUSTOMER => 'Customer'
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
