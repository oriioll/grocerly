<?php

namespace App\Services;

use App\DTOs\FoodDTO;
use App\Models\Food;
use Illuminate\Database\Eloquent\Collection;

class FoodService
{
    /**
     * Get all the food items from db
     * @return array array of Food Model Objects
     * @author  Oriol Plazas
     * @since 30/07/2026
     * @see App\Models\Food.php
     */
    public function getAll(): array
    {
        $foods = Food::all();
        $foodsDTO = [];
        foreach ($foods as $food) {
            $foodsDTO[] = new FoodDTO($food->name, $food->kcal, $food->category);
        }
        return $foodsDTO;
    }

    /**
     * Get a food by its id
     * @param int $foodId The id of the food
     * @return FoodDTO The food with the id
     * @author  Oriol Plazas
     * @since 30/07/2026
     * @see App\Models\Food.php
     */
    public function getById(int $foodId): FoodDTO
    {
        $food = Food::findOrFail($foodId);
        return new FoodDTO($food->name, $food->kcal, $food->category);
    }

    /**
     * Create food in db
     * @param FoodDTO $foodDTO food to insert
     * @return FoodDTO Food inserted
     * @author  Oriol Plazas
     * @since 01/08/2026
     * @see App\Models\Food.php
     */
    public function create(FoodDTO $foodDTO): FoodDTO
    {
        $food =  Food::create([
            'name' => $foodDTO->name,
            'kcal' => $foodDTO->kcal,
            'category' => $foodDTO->category
        ]);
        return new FoodDTO($food->name, $food->kcal, $food->category);
    }
}
