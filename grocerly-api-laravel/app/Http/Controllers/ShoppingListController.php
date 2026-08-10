<?php

namespace App\Http\Controllers;

use App\DTOs\FoodDTO;
use App\DTOs\RecipeDTO;
use App\DTOs\RecipeFoodDTO;
use App\Http\Requests\FoodPostRequest;
use App\Http\Requests\ListPostRequest;
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
        $lists = $this->shoppingListService->getAll($user->user_id);
        return response()->json($lists);
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
     * @since 09/08/2026
     */
    public function storeFood(ListPostRequest $request, int $listId)
    {
        $validated = $request->validated();
        $list = $this->shoppingListService->create($listId, $validated['food_id']);
        return response()->json($list, 201);
    }

    /**
     * Creates a shopping list for the user
     * @author Oriol Plazas
     * @since 09/08/2026
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $list = $this->shoppingListService->createList($user->user_id);
        return response()->json($list, 201);
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
}
