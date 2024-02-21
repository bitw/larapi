<?php

declare(strict_types=1);

namespace App\DTO;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Support\Arrayable;

readonly class CustomerDTO implements Arrayable
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?CarbonImmutable $emailVerifiedAt = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => empty(trim($this->name)) ? null : $this->name,
            'email' => empty(trim($this->email)) ? null : $this->email,
            'password' => empty(trim($this->password)) ? null : $this->password,
            'email_verified_at' => $this->emailVerifiedAt ?? now(),
        ];
    }
}
