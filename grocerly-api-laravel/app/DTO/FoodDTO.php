<?php

namespace App\DTOs;

final class FoodDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?int $kcal,
        public readonly string $category
    ) {}
}
