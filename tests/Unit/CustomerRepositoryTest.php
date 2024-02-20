<?php

namespace Tests\Unit;

use App\Exceptions\CreateCustomerException;
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
     * @throws CreateCustomerException
     */
    public function testCreateSuccess(): void
    {
        $customer = $this->customerRepository->create(
            name: $name = $this->faker->name,
            email: $email = $this->faker->email,
            password: $this->faker->password,
        );

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
     * @throws CreateCustomerException
     */
    public function testCreateNameError(): void
    {
        $this->expectException(CreateCustomerException::class);
        $this->expectExceptionMessage('The $name cannot be empty.');
        $this->customerRepository->create(
            name: '',
            email: $this->faker->email,
            password: $this->faker->password,
        );
    }

    /**
     * @throws CreateCustomerException
     */
    public function testCreateEmailEmptyError(): void
    {
        $this->expectException(CreateCustomerException::class);
        $this->expectExceptionMessage('The $email cannot be empty.');
        $this->customerRepository->create(
            name: $this->faker->name,
            email: '',
            password: $this->faker->password,
        );
    }

    /**
     * @throws CreateCustomerException
     */
    public function testCreateEmailInvalidError(): void
    {
        $this->expectException(CreateCustomerException::class);
        $this->expectExceptionMessage('The $email invalid format.');
        $this->customerRepository->create(
            name: $this->faker->name,
            email: $this->faker->text,
            password: $this->faker->password,
        );
    }

    /**
     * @throws CreateCustomerException
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
     * @throws CreateCustomerException
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
     * @throws CreateCustomerException
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
     * @throws CreateCustomerException
     */
    private function createCustomer(): Customer
    {
        return $this->customerRepository->create(
            name: $this->faker->name,
            email: $this->faker->email,
            password: $this->faker->password,
        );
    }
}
