<?php

namespace App\Services;

use App\Enums\RolesEnum;
use App\Exceptions\CreateRoleException;
use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * @throws CreateRoleException
     */
    final public function createRoleIfNotExist(
        string $name,
        ?string $guardName = null,
    ): Role {
        if (empty(trim($name))) {
            throw new CreateRoleException('Role name not specified.');
        }

        if($guardName === null){
            $guardName = RolesEnum::GUARD;
        }

        /** @var Role $role */
        $role = Role::findOrCreate(
            $name,
            $guardName,
        );

        return $role;
    }
}
