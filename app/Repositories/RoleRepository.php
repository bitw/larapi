<?php

namespace App\Repositories;

use App\Exceptions\CreateRoleException;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    /**
     * @throws CreateRoleException
     */
    final public function createRoleIfNotExist(
        string $name,
        ?string $guardName,
    ): Role {
        if (empty(trim($name))) {
            throw new CreateRoleException('Role name not specified.');
        }

        /** @var Role $role */
        $role = Role::findOrCreate(
            $name,
            $guardName,
        );

        return $role;
    }

    final public function findByName(string $name): Role
    {
        return Role::where('name', $name)
            ->first();
    }
}
