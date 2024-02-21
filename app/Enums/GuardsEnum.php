<?php

declare(strict_types=1);

namespace App\Enums;

enum GuardsEnum: string
{
    case GUARD_API_ADMIN = 'api-admin';
    case GUARD_API_MANAGER = 'api-manager';
    case GUARD_API_CUSTOMER = 'api-customer';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
