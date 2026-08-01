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
            $foodsDTO[] = $this->toDTO($food);
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
        return $this->toDTO($food);
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
        $food = $this->toModel($foodDTO);
        $food->save();
        return $this->toDTO($food);
    }

    /**
     * Maps a Model to a DTO
     * @param Food $food to convert to DTO
     * @return FoodDTO DTO convered from a Model
     * @author Oriol Plazas León
     * @since 02/08/2026
     */
    private function toDTO(Food $food): FoodDTO
    {
        return new FoodDTO($food->food_id, $food->name, $food->kcal, $food->category);
    }

    /**
     * Maps a DTO to a Model instance
     * @param FoodDTO $dto DTO to convert to Model
     * @return Food Model built from the DTO
     * @author Oriol Plazas León
     * @since 02/08/2026
     */
    private function toModel(FoodDTO $dto): Food
    {
        return new Food([
            'name' => $dto->name,
            'kcal' => $dto->kcal,
            'category' => $dto->category,
        ]);
    }
}
