<?php

namespace App\Repositories;

use App\Enums\GuardsEnum;
use App\Enums\RolesEnum;
use App\Exceptions\CreateEmployeeAdminException;
use App\Exceptions\CreateEmployeeManagerException;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

readonly class EmployeeRepository
{
    public function __construct(
        protected RoleRepository $roleRepository
    ) {
    }

    /**
     * @throws CreateEmployeeAdminException
     */
    public function createAdmin(
        string $name,
        string $email,
        string $password,
    ): Employee {
        DB::beginTransaction();
        try {
            /** @var Employee $employee */
            $employee = Employee::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $employee->assignRole(
                $this->roleRepository->createRoleIfNotExist(
                    RolesEnum::ADMIN->value,
                    GuardsEnum::GUARD_API_ADMIN->value
                )
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new CreateEmployeeAdminException($e);
        }
        DB::commit();

        return $employee;
    }

    public function createManager(
        string $name,
        string $email,
        string $password,
    ): Employee {
        DB::beginTransaction();
        try {
            /** @var Employee $employee */
            $employee = Employee::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $employee->assignRole(
                $this->roleRepository->createRoleIfNotExist(
                    RolesEnum::EMPLOYEE_MANAGER->value,
                    GuardsEnum::GUARD_API_MANAGER->value
                )
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new CreateEmployeeManagerException($e);
        }
        DB::commit();

        return $employee;
    }
}
