<?php

namespace Tests\Unit\Services;

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
            name: RolesEnum::ADMIN->value,
            guardName: RolesEnum::GUARD
        );
        $this->assertInstanceOf(Role::class, $role);
    }

    public function testCreateRoleIfNotExistErrorEmptyName(): void
    {
        $this->expectException(CreateRoleException::class);
        $this->roleService->createRoleIfNotExist(
            name: '',
            guardName: RolesEnum::GUARD
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
            guardName: RolesEnum::GUARD
        );
    }
}
