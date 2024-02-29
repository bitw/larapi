<?php

namespace Tests\Unit\Services;

use App\Exceptions\CreateUserException;
use App\Exceptions\UserUpdateException;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use WithFaker;

    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var UserService $userService */
        $userService = app(UserService::class);
        $this->userService = $userService;
    }

    /**
     * @throws CreateUserException
     */
    public function testCreateSuccess(): void
    {
        $customer = $this->userService->create([
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
            'password' => $this->faker->password,
        ]);

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
     * @throws CreateUserException
     */
    public function testCreateNameError(): void
    {
        $this->expectException(CreateUserException::class);
        $this->userService->create([
            'name' => '',
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ]);
    }

    /**
     * @throws CreateUserException
     */
    public function testCreateEmailEmptyError(): void
    {
        $this->expectException(CreateUserException::class);
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
