<?php

namespace App\Services;

use App\DTOs\RecipeDTO;
use App\DTOs\RecipeFoodDTO;
use App\DTOs\ShoppingListDTO;
use App\Models\FoodList;
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
     * @return ShoppingListDTO The Shoppinglist with that id
     * @author  Oriol Plazas
     * @since 07/08/2026
     */
    public function getById(int $shoppingListId): ShoppingListDTO
    {
        $shoppingList = ShoppingList::with('foods')->findOrFail($shoppingListId);
        return $this->toDTO($shoppingList);
    }

    /**
     * Checks if the list is created by the user
     * @param int $listId The id of the list to check
     * @param int $userId The user id to check
     * @return bool If list was created by the user or not
     * @author Oriol Plazas
     * @since 08/08/2026
     */
    public function listCreatedByUser(int $listId, int $userId): bool
    {
        $list = ShoppingList::findOrFail($listId);
        return $list->user_id == $userId;
    }
    /**
     * Inserts a food into the list
     * @param int $listId id of the list where insert the food
     * @param int $foodId id of the food to insert
     * @return ShoppingList List with the foods were food inserted
     * @author  Oriol Plazas
     * @since 09/08/2026
     */
    public function create(int $listId, int $foodId): ShoppingList
    {
        $list = ShoppingList::findOrFail($listId);
        $list->foods()->attach($foodId);
        return $list->load('foods');
    }


    /**
     * Creates a list for the user
     * @param int $userId The id of the user
     * @return ShoppingListDTO List created
     * @author Oriol Plazas
     * @since 09/08/2026
     */
    public function createList(int $userId): ShoppingListDTO
    {
        $list = ShoppingList::create(['user_id' => $userId]);
        return $this->toDTO($list);
    }

    /**
     * Delete list in db
     * @param int $listId list to delete
     * @return bool If list deleted
     * @author  Oriol Plazas
     * @since 08/08/2026
     */
    public function delete(int $listId): bool
    {
        $list = ShoppingList::findOrFail($listId);
        //Use delete so trigger deleting event and delete foods - recipe relation with that recipe
        $list->foods()->detach();
        $list->delete();
        return true;
    }


    /**
     * Deletes a food from a list
     * @param int $listId The id of the list to delete the food
     * @param int $foodId The if of the food to delete
     * @return bool If delete affected more than 0 rows
     * @author  Oriol Plazas
     * @since 08/08/2026
     */
    public function deleteFoodFromList(int $listId, int $foodId): bool
    {
        $deleted = FoodList::where('shopping_list_id', $listId)
            ->where('food_id', $foodId)
            ->delete();
        return $deleted > 0;
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
        $foods = $shoppingList->foods->pluck('food_id')->all();
        return new ShoppingListDTO($shoppingList->list_id, $shoppingList->user_id, $foods);
    }

    /**
     * Maps a DTO to a Model instance
     * @return ShoppingList Model built from the DTO
     * @author Oriol Plazas León
     * @since 07/08/2026
     */
    private function toModel(ShoppingListDTO $dto): ShoppingList
    {
        return new ShoppingList([
            'user_id' => $dto->userId,
        ]);
    }
}
