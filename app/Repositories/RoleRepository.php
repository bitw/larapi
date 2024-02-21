<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepository
{
    final public function findByName(string $name): Role
    {
        return Role::where('name', $name)
            ->firstOrFail();
    }
}
