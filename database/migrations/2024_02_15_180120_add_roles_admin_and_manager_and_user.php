<?php

declare(strict_types=1);

use App\Repositories\EmployeeRepository;
use App\Repositories\RoleRepository;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /** @var EmployeeRepository $employeeRepository */
        $employeeRepository = app(EmployeeRepository::class);

        $employeeRepository->createAdmin(
            name: 'Admin',
            email:'admin@example.com',
            password: Hash::make('password-123-secret'),
            roleRepository: app(RoleRepository::class)
        );
    }
};
