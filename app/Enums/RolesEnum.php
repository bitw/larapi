<?php

declare(strict_types=1);

namespace App\Enums;

enum RolesEnum: string
{
    case ADMIN = 'admin';
    case EMPLOYEE_MANAGER = 'employee-manager';
    case CUSTOMER_MANAGER = 'customer-manager';
    case CUSTOMER = 'customer';

    public function label(): string
    {
        return match ($this) {
            RolesEnum::ADMIN => 'Admin',
            RolesEnum::EMPLOYEE_MANAGER => 'Employee manager',
            RolesEnum::CUSTOMER_MANAGER => 'Customer manager',
            RolesEnum::CUSTOMER => 'Customer'
        };
    }
}
