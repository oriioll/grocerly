<?php

namespace App\DTOs;

final class ShoppingListDTO
{
    public function __construct(
        public readonly ?int $listId,
        public readonly int $userId,
        public readonly array $foods,
    ) {}
}
