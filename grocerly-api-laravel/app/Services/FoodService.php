<?php

namespace App\Services;

use App\Models\Food;
use Illuminate\Database\Eloquent\Collection;

class FoodService
{
    /**
     * Get all the food items from db
     * @return Collection<int, Food> Collection of Food Model Objects
     * @author  Oriol Plazas
     * @since 30/07/2026
     * @see App\Models\Food.php
     */
    public function getAll(): Collection
    {
        return Food::all();
    }

    /**
     * Get a food by its id
     * @param int $foodId The id of the food
     * @return Food The food with the id
     * @author  Oriol Plazas
     * @since 30/07/2026
     * @see App\Models\Food.php
     */
    public function getById(int $foodId): Food
    {
        return Food::findOrFail($foodId);
    }

    /**
     * Create foods in db
     * @param Food[] $data Array of foods to insert
     * @return bool Insert result
     * @author  Oriol Plazas
     * @since 30/07/2026
     * @see App\Models\Food.php
     */
    public function create(array $data): bool
    {
        return Food::insert($data);
    }
}
