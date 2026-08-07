<?php

namespace App\Services;

use App\DTOs\RecipeDTO;
use App\DTOs\RecipeFoodDTO;
use App\DTOs\ShoppingListDTO;
use App\Models\Recipe;
use App\Models\RecipeFood;
use App\Models\ShoppingList;
use Illuminate\Database\Eloquent\Collection;

class ShoppingListService
{
    /**
     * Get shopping lists of the user
     * @param int $userId the id of the user logged
     * @return array Shopping lists
     * @author  Oriol Plazas
     * @since 07/08/2026
     */
    public function getAll(int $userId): array
    {
        $shoppingLists = ShoppingList::with('foods')->where('user_id', $userId)->get();
        $shoppingListsDTO = [];
        foreach ($shoppingLists as $sp) {
            $shoppingListsDTO[] = $this->toDTO($sp);
        }
        return $shoppingListsDTO;
    }

    /**
     * Get the shopping list with that id
     * @param int $shoppingListId id of the shopping list
     * @param int $userId the id of the user logged
     * @return ShoppingListDTO The Shoppinglist with that id
     * @author  Oriol Plazas
     * @since 07/08/2026
     */
    public function getById(int $shoppingListId, int $userId): ShoppingListDTO
    {
        $shoppingList = $shoppingList = ShoppingList::with('foods')
            ->where('list_id', $shoppingListId)
            ->where('user_id', $userId)
            ->firstOrFail();
        return $this->toDTO($shoppingList);
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
     * @param ShoppingList $shoppingList to convert to DTO
     * @return ShoppingListDTO DTO convered from a Model
     * @author Oriol Plazas León
     * @since 07/08/2026
     */
    private function toDTO(ShoppingList $shoppingList): ShoppingListDTO
    {
        $foods = $shoppingList->foods->map(
            fn($food) =>
            (int) $food->food_id
        )->all();
        return new ShoppingListDTO($shoppingList->list_id, $shoppingList->user_id, $foods);
    }

    /**
     * Maps a DTO to a Model instance
     * @return ShoppingList Model built from the DTO
     * @author Oriol Plazas León
     * @since 07/08/2026
     */
    private function toModel(int $userId): ShoppingList
    {
        return new ShoppingList([
            'user_id' => $userId,
        ]);
    }
}
