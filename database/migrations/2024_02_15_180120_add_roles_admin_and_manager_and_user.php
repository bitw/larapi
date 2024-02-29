<?php

declare(strict_types=1);

use App\Enums\RolesEnum;
use App\Services\UserService;
use App\Services\RoleService;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class () extends Migration {
    private UserService $userService;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /** @var UserService $userService */
        $userService = app(UserService::class);
        $this->userService = $userService;

        /** @var RoleService $roleService */
        $roleService = app(RoleService::class);

        $roleAdmin = $roleService->createRoleIfNotExist(
            name: RolesEnum::ADMIN->value,
            guardName: 'api',
        );

        $roleManager = $roleService->createRoleIfNotExist(
            name: RolesEnum::MANAGER->value,
            guardName: 'api',
        );

        $roleCustomer = $roleService->createRoleIfNotExist(
            name: RolesEnum::CUSTOMER->value,
            guardName: 'api',
        );

        $this->createAdmin($roleAdmin);
        $this->createManager($roleManager);
        $this->createCustomer();
    }

    private function createAdmin(Role $role): void
    {
        $this->userService->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password-123-admin',
        ], $role);
    }

    private function createManager(Role $role): void
    {
        $this->userService->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => 'password-123-manager',
        ], $role);
    }

    private function createCustomer(): void
    {
        $this->userService->create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => 'password-123-customer',
        ]);
    }
};
