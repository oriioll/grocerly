<?php

namespace App\Http\Controllers;

use App\DTOs\FoodDTO;
use App\Http\Requests\FoodPostRequest;
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
     * Gets information of the Food with that id
     * @param int $foodId the id of the food to show
     * @author Oriol Plazas
     * @since 01/08/2026
     */
    public function show(int $foodId)
    {
        $food = $this->foodService->getById($foodId);
        return response()->json($food);
    }

    public function post(FoodPostRequest $request)
    {
        //Object with name kcal and category, validated using FoodPostRequest
        $validated = $request->validated();
        $foodDTO = new FoodDTO($validated['name'],  isset($validated['kcal']) ? (int) $validated['kcal'] : null, $validated['category']);

        $foodCreated = $this->foodService->create($foodDTO);
        return response()->json($foodCreated, 201);
    }
}
