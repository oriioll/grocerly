<?php

namespace App\Services;

use App\DTOs\RecipeDTO;
use App\DTOs\RecipeFoodDTO;
use App\Models\Recipe;
use App\Models\RecipeFood;
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
        $recipes = Recipe::with('foods')->where(function ($query) use ($userId) {
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
        $recipes = Recipe::with('foods')->where('user_id', $userId)->get();
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
        $recipe = Recipe::with('foods')->findOrFail($recipeID);
        return $this->toDTO($recipe);
    }

    /**
     * Create recipe in db
     * @param RecipeDTO $recipeDTO recipe to insert
     * @return RecipeDTO Recipe inserted
     * @author  Oriol Plazas
     * @since 06/08/2026
     */
    public function create(RecipeDTO $recipeDTO, int $userId): RecipeDTO
    {
        $recipe = $this->toModel($recipeDTO, $userId);
        $recipe->save();
        //Handle foods of the recipe (RecipeFoods table)
        $pivotData = collect($recipeDTO->foods)->mapWithKeys(fn($f) => [
            $f->foodId => ['grams' => $f->grams],
        ])->toArray();
        $recipe->foods()->attach($pivotData);

        return $this->toDTO($recipe->load('foods'));
    }

    /**
     * Delete recipe in db
     * @param int $recipeId recipe to insert
     * @return bool If recipe deleted
     * @author  Oriol Plazas
     * @since 06/08/2026
     */
    public function delete(int $recipeId): bool
    {
        $recipe = Recipe::find($recipeId);
        if (!$recipe) {
            return false;
        }
        //Use delete so trigger deleting event and delete foods - recipe relation with that recipe
        $recipe->foods()->detach();
        $recipe->delete();
        return true;
    }

    /**
     * Updates a recipe in db
     * @param int $recipeId recipe to update
     * @param RecipeDTO $recipeDTO the updated data of the recipe
     * @return RecipeDTO updated recipe
     * @author  Oriol Plazas
     * @since 06/08/2026
     */
    public function put(RecipeDTO $recipeDTO, int $recipeId): RecipeDTO
    {
        $recipe = Recipe::findOrFail($recipeId);
        $recipe->update([
            'name' => $recipeDTO->name,
            'is_public' => $recipeDTO->isPublic,
            'servings' => $recipeDTO->servings,
        ]);

        //Update also the foods
        $pivotData = collect($recipeDTO->foods)->mapWithKeys(fn($f) => [
            $f->foodId => ['grams' => $f->grams],
        ])->toArray();
        $recipe->foods()->sync($pivotData);
        return $this->toDTO($recipe->load('foods'));
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
        $foods = $recipe->foods->map(
            fn($food) =>
            new RecipeFoodDTO(
                (int) $food->food_id,
                (float) $food->pivot->grams
            )
        )->all();
        return new RecipeDTO($recipe->recipe_id, $recipe->name, $recipe->is_public, $recipe->servings, $foods);
    }

    /**
     * Maps a DTO to a Model instance
     * @param RecipeDTO $dto DTO to convert to Model
     * @return Recipe Model built from the DTO
     * @author Oriol Plazas León
     * @since 02/08/2026
     */
    private function toModel(RecipeDTO $dto, int $userId): Recipe
    {
        return new Recipe([
            'name' => $dto->name,
            'is_public' => $dto->isPublic,
            'servings' => $dto->servings,
            'user_id' => $userId,
        ]);
    }
}
