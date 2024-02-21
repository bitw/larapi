<?php

namespace App\Services;

use App\Enums\GuardsEnum;
use App\Enums\RolesEnum;
use App\Exceptions\CreateEmployeeAdminException;
use App\Exceptions\CreateEmployeeManagerException;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeService
{
    public function __construct(
        protected RoleService $roleService
    ) {
    }

    /**
     * @throws CreateEmployeeAdminException
     */
    public function createAdmin(
        array $attributes
    ): Employee {
        try {
            DB::beginTransaction();
            $employee = Employee::create($attributes);

            $employee->assignRole(
                $this->roleService->createRoleIfNotExist(
                    RolesEnum::EMPLOYEE_ADMIN->value,
                    GuardsEnum::GUARD_API_ADMIN->value
                )
            );
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new CreateEmployeeAdminException($e);
        }

        return $employee;
    }

    /**
     * @throws CreateEmployeeManagerException
     */
    public function createManager(
        array $attributes
    ): Employee {
        if (isset($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }
        try {
            DB::beginTransaction();
            /** @var Employee $employee */
            $employee = Employee::create($attributes);

            $employee->assignRole(
                $this->roleService->createRoleIfNotExist(
                    RolesEnum::EMPLOYEE_MANAGER->value,
                    GuardsEnum::GUARD_API_MANAGER->value
                )
            );
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new CreateEmployeeManagerException($e);
        }

        return $employee;
    }
}
