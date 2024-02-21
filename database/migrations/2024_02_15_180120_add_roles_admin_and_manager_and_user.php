<?php

declare(strict_types=1);

use App\Enums\GuardsEnum;
use App\Enums\RolesEnum;
use App\Services\CustomerService;
use App\Services\EmployeeService;
use App\Services\RoleService;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class () extends Migration {
    private EmployeeService $employeeService;
    private CustomerService $customerService;
    private RoleService $roleService;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /** @var EmployeeService $employeeService */
        $employeeService = app(EmployeeService::class);
        $this->employeeService = $employeeService;

        /** @var CustomerService $customerService */
        $customerService = app(CustomerService::class);
        $this->customerService = $customerService;

        /** @var RoleService $roleService */
        $roleService = app(RoleService::class);
        $this->roleService = $roleService;

        $permissionApiAdminForAdmin = Permission::create([
            'name' => GuardsEnum::GUARD_API_ADMIN->value,
            'guard_name' => GuardsEnum::GUARD_API_ADMIN->value
        ]);
        $permissionApiManagerForAdmin = Permission::create([
            'name' => GuardsEnum::GUARD_API_MANAGER->value,
            'guard_name' => GuardsEnum::GUARD_API_ADMIN->value
        ]);
        $permissionApiCustomerForAdmin = Permission::create([
            'name' => GuardsEnum::GUARD_API_CUSTOMER->value,
            'guard_name' => GuardsEnum::GUARD_API_ADMIN->value
        ]);
        $roleAdmin = $this->roleService->createRoleIfNotExist(
            name: RolesEnum::EMPLOYEE_ADMIN->value,
            guardName: GuardsEnum::GUARD_API_ADMIN->value
        );
        $roleAdmin->givePermissionTo($permissionApiAdminForAdmin);
        $roleAdmin->givePermissionTo($permissionApiManagerForAdmin);
        $roleAdmin->givePermissionTo($permissionApiCustomerForAdmin);

        $permissionApiManagerForManager = Permission::create([
            'name' => GuardsEnum::GUARD_API_MANAGER->value,
            'guard_name' => GuardsEnum::GUARD_API_MANAGER->value
        ]);
        $permissionApiCustomerForManager = Permission::create([
            'name' => GuardsEnum::GUARD_API_CUSTOMER->value,
            'guard_name' => GuardsEnum::GUARD_API_MANAGER->value
        ]);
        $roleManager = $this->roleService->createRoleIfNotExist(
            name: RolesEnum::EMPLOYEE_MANAGER->value,
            guardName: GuardsEnum::GUARD_API_MANAGER->value
        );
        $roleManager->givePermissionTo($permissionApiManagerForManager);
        $roleManager->givePermissionTo($permissionApiCustomerForManager);

        $permissionApiCustomerForCustomer = Permission::create([
            'name' => GuardsEnum::GUARD_API_CUSTOMER->value,
            'guard_name' => GuardsEnum::GUARD_API_CUSTOMER->value
        ]);
        $roleCustomer = $this->roleService->createRoleIfNotExist(
            name: RolesEnum::CUSTOMER->value,
            guardName: GuardsEnum::GUARD_API_CUSTOMER->value
        );
        $roleCustomer->givePermissionTo($permissionApiCustomerForCustomer);

        $this->createAdmin();
        $this->createManager();
        $this->createCustomer();
    }

    private function createAdmin(): void
    {
        $this->employeeService->createAdmin([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password-123-admin',
        ]);
    }

    private function createManager(): void
    {
        $this->employeeService->createManager([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => 'password-123-manager',
        ]);
    }

    private function createCustomer(): void
    {
        $this->customerService->createCustomer([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => 'password-123-customer',
        ]);
    }
};
