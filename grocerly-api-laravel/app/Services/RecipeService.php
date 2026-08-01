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
            $recipesDTO[] = $this->toDTO($recipe);
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
            $recipesDTO[] = $this->toDTO($recipe);
        }
        return $recipesDTO;
    }

    /**
     * Get the recipe with that id
     * @param int $recipeID recipe id to filter recipes
     * @return RecipeDTO The recipe with that id
     * @author  Oriol Plazas
     * @since 02/08/2026
     * @see App\Models\Recipe.php
     */
    public function getById(int $recipeID): RecipeDTO
    {
        $recipe = Recipe::findOrFail($recipeID);
        return $this->toDTO($recipe);
    }


    /**
     * Maps a Model to a DTO
     * @param Recipe $recipe to convert to DTO
     * @return RecipeDTO DTO convered from a Model
     * @author Oriol Plazas León
     * @since 02/08/2026
     */
    private function toDTO(Recipe $recipe): RecipeDTO
    {
        return new RecipeDTO($recipe->recipe_id, $recipe->name, $recipe->is_public, $recipe->servings);
    }

    /**
     * Maps a DTO to a Model instance
     * @param RecipeDTO $dto DTO to convert to Model
     * @return Recipe Model built from the DTO
     * @author Oriol Plazas León
     * @since 02/08/2026
     */
    private function toModel(RecipeDTO $dto): Recipe
    {
        return new Recipe([
            'name' => $dto->name,
            'is_public' => $dto->isPublic,
            'servings' => $dto->servings,
        ]);
    }
}
