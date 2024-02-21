<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Services\RoleService;

class CustomerRepository
{
    public function __construct(
        protected RoleService $roleService
    ) {
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
