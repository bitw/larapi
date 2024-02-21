<?php

namespace Tests\Unit\Services;

use App\Exceptions\CreateCustomerException;
use App\Exceptions\UpdateCustomerException;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerServiceTest extends TestCase
{
    use WithFaker;

    private CustomerService $customerService;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var CustomerService $customerService */
        $customerService = app(CustomerService::class);
        $this->customerService = $customerService;
    }

    /**
     * @throws CreateCustomerException
     */
    public function testCreateSuccess(): void
    {
        $customer = $this->customerService->createCustomer([
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
     * @throws CreateCustomerException
     */
    public function testCreateNameError(): void
    {
        $this->expectException(CreateCustomerException::class);
        $this->customerService->createCustomer([
            'name' => '',
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ]);
    }

    /**
     * @throws CreateCustomerException
     */
    public function testCreateEmailEmptyError(): void
    {
        $this->expectException(CreateCustomerException::class);
        $this->customerService->createCustomer([
            'name' => $this->faker->name,
            'email' => '',
            'password' => $this->faker->password,
        ]);
    }

    /**
     * @throws CreateCustomerException
     * @throws UpdateCustomerException
     */
    public function testUpdateCustomer(): void
    {
        $customer = $this->customerService->createCustomer([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ]);

        $this->customerService->updateCustomer($customer, [
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
        ]);

        $customer = Customer::find($customer->id);

        $this->assertEquals($customer->name, $name);
        $this->assertEquals($customer->email, $email);
    }
}
