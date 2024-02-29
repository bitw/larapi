<?php

namespace Tests\Unit\Services;

use App\Exceptions\CreateRoleException;
use App\Exceptions\UserCreateException;
use App\Exceptions\UserUpdateException;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use WithFaker;

    private readonly UserService $userService;
    private readonly RoleService $roleService;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var UserService $userService */
        $userService = app(UserService::class);
        $this->userService = $userService;

        /** @var RoleService $roleService */
        $roleService = app(RoleService::class);
        $this->roleService = $roleService;
    }

    /**
     * @throws UserCreateException
     * @throws CreateRoleException
     */
    public function testCreateSuccess(): void
    {
        $role = $this->roleService->createRoleIfNotExist('test');

        $customer = $this->userService->create(
            [
                'name' => $name = $this->faker->name,
                'email' => $email = $this->faker->email,
                'password' => $this->faker->password,
            ]
        );

        $this->assertInstanceOf(User::class, $customer);
        $this->assertDatabaseHas(
            (new User())->getTable(),
            [
                'name' => $name,
                'email' => $email
            ]
        );
    }

    /**
     * @throws CreateRoleException
     * @throws UserCreateException
     */
    public function testCreateWithTestRoleSuccess(): void{
        $role = $this->roleService->createRoleIfNotExist('test');

        $customer = $this->userService->create(
            [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => $this->faker->password,
            ],
            $role
        );

        $this->assertTrue($customer->hasRole('test'));
    }

    /**
     * @throws UserCreateException
     */
    public function testCreateNameError(): void
    {
        $this->expectException(UserCreateException::class);
        $this->userService->create([
            'name' => '',
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ]);
    }

    /**
     * @throws UserCreateException
     */
    public function testCreateEmailEmptyError(): void
    {
        $this->expectException(UserCreateException::class);
        $this->userService->create([
            'name' => $this->faker->name,
            'email' => '',
            'password' => $this->faker->password,
        ]);
    }

    /**
     * @throws UserUpdateException
     */
    public function testUpdateCustomerSuccess(): void
    {
        $customer = User::factory()->create();

        $this->userService->update($customer, [
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
        ]);

        $customer = User::find($customer->id);

        $this->assertEquals($customer->name, $name);
        $this->assertEquals($customer->email, $email);
    }

    /**
     * @throws UserUpdateException
     */
    public function testUpdateCustomerError(): void
    {
        $customer = User::factory()->create();

        $this->expectException(UserUpdateException::class);
        $this->userService->update($customer, [
            'name' => '',
            'email' => $email = $this->faker->email,
        ]);
    }
}
