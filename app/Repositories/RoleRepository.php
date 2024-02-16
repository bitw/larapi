<?php

namespace App\Repositories;

use App\Exceptions\CreateEmployeeAdminException;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    /**
     * @throws CreateEmployeeAdminException
     */
    public function createRoleIfNotExist(
        string $name,
        ?string $guardName,
    ): Role {
        /** @var Role $role */
        $role = Role::findOrCreate(
            $name,
            $guardName,
        );

        return $role;
    }
}
