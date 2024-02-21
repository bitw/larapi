<?php

namespace Tests\Unit\Repositories;

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

    public function testFindByIdSuccess(): void
    {
        $customer = Customer::factory()->create();

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

    public function testFindByUlidSuccess(): void
    {
        $customer = Customer::factory()->create();

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

    public function testFindByEmailSuccess(): void
    {
        $customer = Customer::factory()->create();

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
}
