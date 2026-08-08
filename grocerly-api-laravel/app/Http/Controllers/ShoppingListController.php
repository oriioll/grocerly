<?php

namespace App\Http\Controllers;

use App\DTOs\FoodDTO;
use App\DTOs\RecipeDTO;
use App\DTOs\RecipeFoodDTO;
use App\Http\Requests\FoodPostRequest;
use App\Http\Requests\RecipePostRequest;
use App\Services\RecipeService;
use App\Services\ShoppingListService;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    public function __construct(private ShoppingListService $shoppingListService) {}

    /**
     * Gets all the shopping lists created by the user
     * @author Oriol Plazas
     * @since 07/08/2026
     */
    public function me(Request $request)
    {
        $user = $request->user();
        $recipes = $this->shoppingListService->getAll($user->user_id);
        return response()->json($recipes);
    }

    /**
     * Gets information of the shopping list with that id
     * @author Oriol Plazas
     * @since 07/08/2026
     */
    public function show(Request $request, int $listId)
    {
        $list = $this->shoppingListService->getById($listId);
        return response()->json($list);
    }

    /**
     * Inserts a recipe into db - validated
     * @author Oriol Plazas
     * @since 06/08/2026
     */
    public function post(RecipePostRequest $request)
    {
        $validated = $request->validated();
        $user = $request->user();
        //Foods array gotten from request
        $foods = array_map(
            fn($f) => new RecipeFoodDTO($f['food_id'], $f['grams']),
            $validated['foods']
        );
        $recipeDTO = new RecipeDTO(
            null,
            $validated['name'],
            $validated['is_public'],
            $validated['servings'],
            $foods,
        );

        $recipeCreated = $this->recipeService->create($recipeDTO, $user->user_id);
        return response()->json($recipeCreated, 201);
    }


    /**
     * Deletes the shopping list with that id
     * @param int $listId the id of the list to delete
     * @author Oriol Plazas
     * @since 08/08/2026
     */
    public function destroy(int $listId)
    {
        $deleted = $this->shoppingListService->delete($listId);
        if ($deleted) {
            return response()->json(['message' => 'Shopping list deleted successfully', 'success' => true]);
        } else {
            return response()->json(['error' => 'Shopping list not found'], 404);
        }
    }

    public function destroyListFood(int $listId, int $foodId)
    {
        $deleted = $this->shoppingListService->deleteFoodFromList($listId, $foodId);
        if ($deleted) {
            return response()->json(['message' => 'Food deleted successfully from shopping list', 'success' => 'true']);
        } else {
            return response()->json(['error' => 'Food not found in shopping list'], 404);
        }
    }

    /**
     * Updates a recipe (PUT)
     * @param int $recipeId The id of the recipe
     * @author Oriol Plazas
     * @since 06/08/2026
     */
    public function update(RecipePostRequest $request, int $recipeId)
    {
        $validated = $request->validated();
        //Foods array gotten from request
        $foods = array_map(
            fn($f) => new RecipeFoodDTO($f['food_id'], $f['grams']),
            $validated['foods']
        );
        $updatedRecipeData = new RecipeDTO(
            $recipeId,
            $validated['name'],
            $validated['is_public'],
            $validated['servings'],
            $foods,
        );
        $updated = $this->recipeService->put($updatedRecipeData, $recipeId);
        return response()->json($updated, 200);
    }
}
