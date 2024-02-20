<?php

namespace Tests\Unit;

use App\Enums\GuardsEnum;
use App\Enums\RolesEnum;
use App\Exceptions\CreateRoleException;
use App\Repositories\RoleRepository;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleRepositoryTest extends TestCase
{
    public RoleRepository $roleRepository;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var RoleRepository $roleRepository */
        $roleRepository = app(RoleRepository::class);
        $this->roleRepository = $roleRepository;
    }

    /**
     * @throws CreateRoleException
     */
    public function testCreateRoleIfNotExistSuccess(): void
    {
        $role = $this->roleRepository->createRoleIfNotExist(
            name: RolesEnum::ADMIN->value,
            guardName: GuardsEnum::GUARD_API_ADMIN->value
        );
        $this->assertInstanceOf(Role::class, $role);
    }

    public function testCreateRoleIfNotExistErrorEmptyName(): void
    {
        $this->expectException(CreateRoleException::class);
        $this->roleRepository->createRoleIfNotExist(
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
        $this->roleRepository->createRoleIfNotExist(
            name: null, // @phpstan-ignore-line
            guardName: GuardsEnum::GUARD_API_ADMIN->value
        );
    }
}
