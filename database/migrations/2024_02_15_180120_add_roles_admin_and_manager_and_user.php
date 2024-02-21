<?php

declare(strict_types=1);

use App\Repositories\CustomerRepository;
use App\Services\EmployeeService;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /** @var EmployeeService $employeeRepository */
        $employeeRepository = app(EmployeeService::class);

        $employeeRepository->createAdmin(
            name: 'Admin',
            email:'admin@example.com',
            password: 'password-123-admin',
        );

        $employeeRepository->createManager(
            name: 'Manager',
            email:'manager@example.com',
            password: 'password-123-manager',
        );

        /** @var CustomerRepository $customerRepository */
        $customerRepository = app(CustomerRepository::class);
        $customerRepository->create([
                'name' => 'Customer',
                'email' => 'customer@example.com',
                'password' => 'password-123-customer',
        ]);
    }
};
