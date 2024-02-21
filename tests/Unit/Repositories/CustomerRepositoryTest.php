<?php

namespace Tests\Unit\Repositories;

use App\Exceptions\CreateRoleException;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class CustomerRepositoryTest extends TestCase
{
    use WithFaker;

    private CustomerRepository $customerRepository;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var CustomerRepository $customerRepository */
        $customerRepository = app(CustomerRepository::class);
        $this->customerRepository = $customerRepository;
    }

    /**
     * @throws CreateRoleException
     */
    public function testCreateSuccess(): void
    {
        $customer = $this->customerRepository->create([
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
            'password' => $this->faker->password,
        ]);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertDatabaseHas(
            (new Customer())->getTable(),
            [
                'name' => $name,
                'email' => $email
            ]
        );
    }

    /**
     * @throws CreateRoleException
     */
    public function testCreateEmailEmptyError(): void
    {
        $this->expectException(\Exception::class);
        $this->customerRepository->create([
            'name' => $this->faker->name,
            'email' => '',
            'password' => $this->faker->password,
        ]);
    }

    /**
     * @throws CreateRoleException
     */
    public function testFindByIdSuccess(): void
    {
        $customer = $this->createCustomer();

        $this->assertInstanceOf(
            Customer::class,
            $this->customerRepository->findById($customer->id)
        );
    }

    public function testFindByIdNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->customerRepository->findById(0);
    }

    /**
     * @throws CreateRoleException
     */
    public function testFindByUlidSuccess(): void
    {
        $customer = $this->createCustomer();

        $this->assertInstanceOf(
            Customer::class,
            $this->customerRepository->findByUlid($customer->ulid)
        );
    }

    public function testFindByUlidNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->customerRepository->findByUlid(Str::ulid());
    }

    /**
     * @throws CreateRoleException
     */
    public function testFindByEmailSuccess(): void
    {
        $customer = $this->createCustomer();

        $this->assertInstanceOf(
            Customer::class,
            $this->customerRepository->findByEmail($customer->email)
        );
    }

    public function testFindByEmailNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->customerRepository->findByEmail($this->faker->email);
    }

    /**
     * @throws CreateRoleException
     */
    public function testUpdateCustomerSuccess(): void
    {
        $customer = $this->createCustomer();

        $this->customerRepository->update($customer, [
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
        ]);

        $customer = $this->customerRepository->findById($customer->id);

        $this->assertEquals($customer->name, $name);
        $this->assertEquals($customer->email, $email);
    }

    /**
     * @throws CreateRoleException
     */
    private function createCustomer(): Customer
    {
        return $this->customerRepository->create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ]);
    }
}
