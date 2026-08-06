<?php

namespace App\Http\Controllers;

use App\DTOs\FoodDTO;
use App\DTOs\RecipeDTO;
use App\DTOs\RecipeFoodDTO;
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

    public function post(RecipePostRequest $request)
    {
        $validated = $request->validated();
        $user = $request->user();
        //Foods array gotten from request
        $foods = array_map(
            fn($f) => new RecipeFoodDTO($f['food_id'], $f['grams']),
            $validated['foods']
        );
        $recipeDTO =  $recipeDTO = new RecipeDTO(
            null,
            $validated['name'],
            $validated['is_public'],
            $validated['servings'],
            $foods,
        );

        $recipeCreated = $this->recipeService->create($recipeDTO, $user->user_id);
        return response()->json($recipeCreated, 201);
    }
}
