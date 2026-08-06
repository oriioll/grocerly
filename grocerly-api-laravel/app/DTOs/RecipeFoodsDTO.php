<?php

namespace App\DTOs;

final class RecipeFoodDTO
{
    public function __construct(
        public readonly int $foodId,
        public readonly float $grams,
    ) {}
}
