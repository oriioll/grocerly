<?php

namespace App\DTOs;

final class RecipeDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly bool $isPublic,
        public readonly int $servings
    ) {}
}
