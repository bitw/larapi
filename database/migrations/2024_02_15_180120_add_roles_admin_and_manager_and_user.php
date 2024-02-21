<?php

declare(strict_types=1);

use App\Services\CustomerService;
use App\Services\EmployeeService;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /** @var EmployeeService $employeeService */
        $employeeService = app(EmployeeService::class);

        $employeeService->createAdmin([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password-123-admin',
        ]);

        $employeeService->createManager([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => 'password-123-manager',
        ]);

        /** @var CustomerService $customerService */
        $customerService = app(CustomerService::class);
        $customerService->createCustomer([
                'name' => 'Customer',
                'email' => 'customer@example.com',
                'password' => 'password-123-customer',
        ]);
    }
};
