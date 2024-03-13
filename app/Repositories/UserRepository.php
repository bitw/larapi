<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findById(int $id): ?User
    {
        /** @var User $user */
        $user = User::find($id);

        return $user;
    }

    public function findByUlid(string $ulid): ?User
    {
        /** @var User $user */
        $user = User::query()
            ->where('ulid', $ulid)
            ->first();

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        /** @var User $user */
        $user = User::query()
            ->where('email', $email)
            ->first();

        return $user;
    }
}
