<?php

namespace App\DTOs;

final class FoodDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?int $kcal,
        public readonly string $category
    ) {}
}
