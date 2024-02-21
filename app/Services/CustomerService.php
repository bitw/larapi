<?php

namespace App\Services;

use App\Enums\GuardsEnum;
use App\Enums\RolesEnum;
use App\Exceptions\CreateCustomerException;
use App\Exceptions\UpdateCustomerException;
use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function __construct(
        public CustomerRepository $customerRepository,
        public RoleService $roleService,
    ) {
    }

    /**
     * @throws CreateCustomerException
     */
    public function createCustomer(
        array $attributes
    ): Customer {
        try {
            DB::beginTransaction();
            $customer = Customer::create($attributes);

            $customer->assignRole(
                $this->roleService->createRoleIfNotExist(
                    RolesEnum::CUSTOMER->value,
                    GuardsEnum::GUARD_API_CUSTOMER->value
                )
            );
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new CreateCustomerException($e->getMessage());
        }

        return $customer;
    }

    /**
     * @throws UpdateCustomerException
     */
    public function updateCustomer(
        Customer $customer,
        array $attributes,
    ): bool {
        try {
            DB::beginTransaction();
            $customer = $customer->update($attributes);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new UpdateCustomerException($e->getMessage());
        }
        return $customer;
    }
}