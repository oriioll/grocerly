<?php

namespace App\Services;

use App\DTOs\RecipeDTO;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;

class RecipeService
{
    /**
     * Get all public recipes or created by the user
     * @param int $userId the id of the user logged
     * @return array of Recipe Model Objects
     * @author  Oriol Plazas
     * @since 02/08/2026
     * @see App\Models\Recipe.php
     */
    public function getAll(int $userId): array
    {
        $recipes = Recipe::where(function ($query) use ($userId) {
            $query->where('is_public', true)->orWhere('user_id', $userId);
        })->get();
        $recipesDTO = [];
        foreach ($recipes as $recipe) {
            $recipesDTO[] = new RecipeDTO($recipe->recipe_id, $recipe->name, $recipe->is_public, $recipe->servings);
        }
        return $recipesDTO;
    }

    /**
     * Get the recipes from a userId
     * @param int $userId User id to filter recipes
     * @return array The recipes created by the user
     * @author  Oriol Plazas
     * @since 02/08/2026
     * @see App\Models\Recipe.php
     */
    public function getByUserId(int $userId): array
    {
        $recipes = Recipe::where('user_id', $userId)->get();
        $recipesDTO = [];
        foreach ($recipes as $recipe) {
            $recipesDTO[] = new RecipeDTO($recipe->recipe_id, $recipe->name, $recipe->is_public, $recipe->servings);
        }
        return $recipesDTO;
    }

    /**
     * Create food in db
     * @param FoodDTO $foodDTO food to insert
     * @return Food Food inserted
     * @author  Oriol Plazas
     * @since 01/08/2026
     * @see App\Models\Food.php
     */
    public function create(FoodDTO $foodDTO): Food
    {
        return Food::create([
            'name' => $foodDTO->name,
            'kcal' => $foodDTO->kcal,
            'category' => $foodDTO->category
        ]);
    }
}
