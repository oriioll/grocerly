<?php

namespace App\Http\Controllers;

use App\DTOs\FoodDTO;
use App\DTOs\RecipeDTO;
use App\DTOs\RecipeFoodsDTO;
use App\Http\Requests\FoodPostRequest;
use App\Http\Requests\RecipePostRequest;
use App\Services\RecipeService;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function __construct(private RecipeService $recipeService) {}
    /**
     * Gets all the publics or created by user recipes in the db
     * @author Oriol Plazas
     * @since 01/08/2026
     */
    public function all(Request $request)
    {
        $user = $request->user();
        $allRecipes = $this->recipeService->getAll($user->user_id);
        return response()->json($allRecipes);
    }


    /**
     * Gets all the recipes created by the user
     * @author Oriol Plazas
     * @since 01/08/2026
     */
    public function me(Request $request)
    {
        $user = $request->user();
        $recipes = $this->recipeService->getByUserId($user->user_id);
        return response()->json($recipes);
    }

    /**
     * Gets information of the recipe with that id
     * @param int $recipeId the id of the recipe to show
     * @author Oriol Plazas
     * @since 02/08/2026
     */
    public function show(int $recipeId)
    {
        $recipe = $this->recipeService->getById($recipeId);
        return response()->json($recipe);
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
            fn($f) => new RecipeFoodsDTO($f['food_id'], $f['grams']),
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
     * Deletes the recipe with that id
     * @param int $recipeId the id of the recipe to delete
     * @author Oriol Plazas
     * @since 06/08/2026
     */
    public function destroy(int $recipeId)
    {
        $deleted = $this->recipeService->delete($recipeId);
        if ($deleted) {
            return response()->json(['message' => 'Recipe deleted successfully', 'success' => true]);
        } else {
            return response()->json(['error' => 'Recipe not found'], 404);
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
            fn($f) => new RecipeFoodsDTO($f['food_id'], $f['grams']),
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
