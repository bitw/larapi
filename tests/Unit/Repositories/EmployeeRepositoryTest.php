<?php

namespace Unit\Repositories;

use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class EmployeeRepositoryTest extends TestCase
{
    use WithFaker;

    private EmployeeRepository $employeeRepository;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var EmployeeRepository $employeeRepository */
        $employeeRepository = app(EmployeeRepository::class);
        $this->employeeRepository = $employeeRepository;
    }

    public function testFindByIdSuccess(): void
    {
        $employee = Employee::factory()->create();

        $this->assertInstanceOf(
            Employee::class,
            $this->employeeRepository->findById($employee->id)
        );
    }

    public function testFindByIdNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->employeeRepository->findById(0);
    }

    public function testFindByUlidSuccess(): void
    {
        $employee = Employee::factory()->create();

        $this->assertInstanceOf(
            Employee::class,
            $this->employeeRepository->findByUlid($employee->ulid)
        );
    }

    public function testFindByUlidNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->employeeRepository->findByUlid(Str::ulid());
    }

    public function testFindByEmailSuccess(): void
    {
        $employee = Employee::factory()->create();

        $this->assertInstanceOf(
            Employee::class,
            $this->employeeRepository->findByEmail($employee->email)
        );
    }

    public function testFindByEmailNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->employeeRepository->findByEmail($this->faker->email);
    }
}
