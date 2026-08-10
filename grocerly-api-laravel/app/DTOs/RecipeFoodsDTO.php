<?php

namespace App\DTOs;

final class RecipeFoodsDTO
{
    public function __construct(
        public readonly int $foodId,
        public readonly float $grams,
    ) {}
}
