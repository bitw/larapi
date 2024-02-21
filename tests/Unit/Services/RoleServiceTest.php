<?php

namespace Tests\Unit\Services;

use App\Enums\GuardsEnum;
use App\Enums\RolesEnum;
use App\Exceptions\CreateRoleException;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleServiceTest extends TestCase
{
    private RoleService $roleService;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var RoleService $roleService */
        $roleService = app(RoleService::class);
        $this->roleService = $roleService;
    }

    /**
     * @throws CreateRoleException
     */
    public function testCreateRoleIfNotExistSuccess(): void
    {
        $role = $this->roleService->createRoleIfNotExist(
            name: RolesEnum::EMPLOYEE_ADMIN->value,
            guardName: GuardsEnum::GUARD_API_ADMIN->value
        );
        $this->assertInstanceOf(Role::class, $role);
    }

    public function testCreateRoleIfNotExistErrorEmptyName(): void
    {
        $this->expectException(CreateRoleException::class);
        $this->roleService->createRoleIfNotExist(
            name: '',
            guardName: GuardsEnum::GUARD_API_ADMIN->value
        );
    }

    /**
     * @throws CreateRoleException
     */
    public function testCreateRoleIfNotExistErrorNameIsNull(): void
    {
        $this->expectException(\TypeError::class);
        $this->roleService->createRoleIfNotExist(
            name: null, // @phpstan-ignore-line
            guardName: GuardsEnum::GUARD_API_ADMIN->value
        );
    }
}
