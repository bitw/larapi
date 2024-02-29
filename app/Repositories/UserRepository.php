<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findById(int $id): User
    {
        return User::findOrFail($id);
    }

    public function findByUlid(string $ulid): User
    {
        return User::query()
            ->where('ulid', $ulid)
            ->firstOrFail();
    }

    public function findByEmail(string $email): User
    {
        return User::query()
            ->where('email', $email)
            ->firstOrFail();
    }
}
