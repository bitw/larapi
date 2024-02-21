<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function findById(int $id): Employee
    {
        return Employee::findOrFail($id);
    }

    public function findByUlid(string $ulid): Employee
    {
        return Employee::query()
            ->where('ulid', $ulid)
            ->firstOrFail();
    }

    public function findByEmail(string $email): Employee
    {
        return Employee::query()
            ->where('email', $email)
            ->firstOrFail();
    }
}
