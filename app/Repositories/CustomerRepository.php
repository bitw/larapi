<?php

namespace App\Repositories;

use App\Enums\GuardsEnum;
use App\Enums\RolesEnum;
use App\Exceptions\CreateCustomerException;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

readonly class CustomerRepository
{
    public function __construct(
        protected RoleRepository $roleRepository
    ) {
    }

    /**
     * @throws CreateCustomerException
     */
    public function create(
        string $name,
        string $email,
        string $password,
    ): Customer {
        if (empty(trim($name))) {
            throw new CreateCustomerException('The $name cannot be empty.');
        }

        if (empty(trim($email))) {
            throw new CreateCustomerException('The $email cannot be empty.');
        }

        if (Validator::make(['email' => $email], ['email' => 'email'])->fails()) {
            throw new CreateCustomerException('The $email invalid format.');
        }

        DB::beginTransaction();
        try {
            /** @var Customer $customer */
            $customer = Customer::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $customer->assignRole(
                $this->roleRepository->createRoleIfNotExist(
                    RolesEnum::CUSTOMER->value,
                    GuardsEnum::GUARD_API_CUSTOMER->value
                )
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new CreateCustomerException($e);
        }
        DB::commit();

        return $customer;
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
