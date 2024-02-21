<?php

namespace Tests\Unit\Repositories;

use App\Exceptions\CreateRoleException;
use App\Repositories\RoleRepository;
use App\Services\RoleService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class RoleRepositoryTest extends TestCase
{
    public RoleRepository $roleRepository;
    public RoleService $roleService;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var RoleRepository $roleRepository */
        $roleRepository = app(RoleRepository::class);
        $this->roleRepository = $roleRepository;

        $roleService = app(RoleService::class);
        $this->roleService = $roleService;
    }

    /**
     * @throws CreateRoleException
     */
    public function testFindByNameSuccess(): void
    {
        $this->roleService->createRoleIfNotExist($name = $this->faker->jobTitle);

        $this->assertModelExists($this->roleRepository->findByName($name));
    }

    public function testFindByNameNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->roleRepository->findByName($this->faker->jobTitle);
    }
}
