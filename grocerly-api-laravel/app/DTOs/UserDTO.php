<?php

namespace App\DTOs;

final class UserDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly string $token,
    ) {}
}
