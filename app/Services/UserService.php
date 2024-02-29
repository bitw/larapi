<?php

namespace App\Services;

use App\Enums\RolesEnum;
use App\Exceptions\UserCreateException;
use App\Exceptions\UserUpdateException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserService
{
    public function __construct(
        protected RoleService $roleService
    ) {
    }

    /**
     * @throws UserCreateException
     */
    public function create(
        array $attributes,
        ?Role $role = null,
    ): User {
        try {
            DB::beginTransaction();
            $user = User::create($attributes);

            if ($role === null) {
                $user->assignRole(
                    $this->roleService->createRoleIfNotExist(
                        RolesEnum::CUSTOMER->value,
                        RolesEnum::GUARD,
                    )
                );
            } else {
                $user->assignRole($role);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new UserCreateException($e);
        }

        return $user;
    }

    public function update(
        User $user,
        array $attributes,
    ): User {
        try {
            DB::beginTransaction();
            $user->update($attributes);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new UserUpdateException($e);
        }

        return $user;
    }
}
