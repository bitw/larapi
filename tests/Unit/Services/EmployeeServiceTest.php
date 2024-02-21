<?php

namespace Unit\Services;

use App\Exceptions\CreateEmployeeAdminException;
use App\Exceptions\CreateEmployeeManagerException;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeServiceTest extends TestCase
{
    use WithFaker;

    private EmployeeService $employeeService;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var EmployeeService $employeeService */
        $employeeService = app(EmployeeService::class);
        $this->employeeService = $employeeService;
    }

    /**
     * @throws CreateEmployeeAdminException
     */
    public function testCreateEmployeeAdminSuccess(): void
    {
        $attributes = [
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
            'password' => $this->faker->password,
        ];
        $customer = $this->employeeService->createAdmin($attributes);

        $this->assertInstanceOf(Employee::class, $customer);
        $this->assertDatabaseHas(
            (new Employee())->getTable(),
            [
                'name' => $name,
                'email' => $email
            ]
        );
    }

    /**
     * @throws CreateEmployeeAdminException
     */
    public function testCreateEmployeeAdminNameError(): void
    {
        $this->expectException(CreateEmployeeAdminException::class);
        $attributes = [
            'name' => '',
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ];
        $this->employeeService->createAdmin($attributes);
    }

    /**
     * @throws CreateEmployeeAdminException
     */
    public function testCreateEmployeeAdminEmailEmptyError(): void
    {
        $this->expectException(CreateEmployeeAdminException::class);
        $attributes = [
            'name' => $this->faker->name,
            'email' => '',
            'password' => $this->faker->password,
        ];
        $this->employeeService->createAdmin($attributes);
    }


    /**
     * @throws CreateEmployeeManagerException
     */
    public function testCreateEmployeeManagerSuccess(): void
    {
        $attributes = [
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
            'password' => $this->faker->password,
        ];
        $customer = $this->employeeService->createManager($attributes);

        $this->assertInstanceOf(Employee::class, $customer);
        $this->assertDatabaseHas(
            (new Employee())->getTable(),
            [
                'name' => $name,
                'email' => $email
            ]
        );
    }

    /**
     * @throws CreateEmployeeManagerException
     */
    public function testCreateEmployeeManagerNameError(): void
    {
        $this->expectException(CreateEmployeeManagerException::class);
        $attributes = [
            'name' => '',
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ];
        $this->employeeService->createManager($attributes);
    }

    /**
     * @throws CreateEmployeeManagerException
     */
    public function testCreateManagerEmailEmptyError(): void
    {
        $this->expectException(CreateEmployeeManagerException::class);
        $attributes = [
            'name' => $this->faker->name,
            'email' => '',
            'password' => $this->faker->password,
        ];
        $this->employeeService->createManager($attributes);
    }
}
