<?php

namespace App\Http\Controllers;

use App\DTOs\FoodDTO;
use App\Http\Requests\FoodPostRequest;
use App\Services\FoodService;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function __construct(private FoodService $foodService) {}
    /**
     * Gets all the foods in the db
     * @author Oriol Plazas
     * @since 01/08/2026
     */
    public function all(Request $request)
    {
        $foods = $this->foodService->getAll();
        return response()->json($foods);
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
        $foodDTO = new FoodDTO(null, $validated['name'],  isset($validated['kcal']) ? (int) $validated['kcal'] : null, $validated['category']);

        $foodCreated = $this->foodService->create($foodDTO);
        return response()->json($foodCreated, 201);
    }
}
