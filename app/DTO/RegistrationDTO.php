<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class RegistrationDTO
{
    public function __construct(
        public string $email,
        public string $password,
        public string $name = ''
    ) {
    }
}
