<?php

namespace Unit\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use WithFaker;

    private UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);
        $this->userRepository = $userRepository;
    }

    public function testFindByIdSuccess(): void
    {
        $employee = User::factory()->create();

        $this->assertInstanceOf(
            User::class,
            $this->userRepository->findById($employee->id)
        );
    }

    public function testFindByIdNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->userRepository->findById(0);
    }

    public function testFindByUlidSuccess(): void
    {
        $employee = User::factory()->create();

        $this->assertInstanceOf(
            User::class,
            $this->userRepository->findByUlid($employee->ulid)
        );
    }

    public function testFindByUlidNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->userRepository->findByUlid(Str::ulid());
    }

    public function testFindByEmailSuccess(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(
            User::class,
            $this->userRepository->findByEmail($user->email)
        );
    }

    public function testFindByEmailNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->userRepository->findByEmail($this->faker->email);
    }
}
