<?php

namespace App\Repositories;

use App\Enums\GuardsEnum;
use App\Enums\RolesEnum;
use App\Exceptions\CreateRoleException;
use App\Models\Customer;
use App\Services\RoleService;

class CustomerRepository
{
    public function __construct(
        protected RoleService $roleService
    ) {
    }

    /**
     * @throws CreateRoleException
     */
    public function create(
        array $attributes,
    ): Customer {
        $customer = Customer::create($attributes);

        $customer->assignRole(
            $this->roleService->createRoleIfNotExist(
                RolesEnum::CUSTOMER->value,
                GuardsEnum::GUARD_API_CUSTOMER->value
            )
        );

        return $customer;
    }

    public function update(Customer $customer, array $attributes): bool
    {
        return $customer->update($attributes);
    }

    public function findById(int $id): Customer
    {
        return Customer::findOrFail($id);
    }

    public function findByUlid(string $ulid): Customer
    {
        return Customer::query()
            ->where('ulid', $ulid)
            ->firstOrFail();
    }

    public function findByEmail(string $email): Customer
    {
        return Customer::query()
            ->where('email', $email)
            ->firstOrFail();
    }
}
