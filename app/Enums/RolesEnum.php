<?php

declare(strict_types=1);

namespace App\Enums;

enum RolesEnum: string
{
    case EMPLOYEE_ADMIN = 'employee-admin';
    case EMPLOYEE_MANAGER = 'employee-manager';
    case CUSTOMER = 'customer';

    public function label(): string
    {
        return match ($this) {
            RolesEnum::EMPLOYEE_ADMIN => 'Employee Admin',
            RolesEnum::EMPLOYEE_MANAGER => 'Employee manager',
            RolesEnum::CUSTOMER => 'Customer'
        };
    }
}
