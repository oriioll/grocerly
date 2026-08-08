<?php

use App\Http\Controllers\FoodController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\UserController;
use App\Models\ShoppingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


const RECIPE_ID_URL = "/recipes/{recipeId}";


Route::middleware('middleware.auth.token')->group(function () {
    //RECIPES
    //Get all public recipes or created by user
    Route::get("/recipes", [RecipeController::class, 'all']);

    //Get all recipes created by the user
    Route::get("/recipes/me", [RecipeController::class, 'me']);

    //Get a concrete recipe only if is public or made by the user
    Route::get(RECIPE_ID_URL, [RecipeController::class, 'show']);

    //Post a recipe - sent in request body
    Route::post("/recipes", [RecipeController::class, 'post']);

    //Modify the recipe with url recipe id using request body, only if created by the user
    Route::put(RECIPE_ID_URL, [RecipeController::class, 'update']);

    //Delete a concrete recipe, only if created by the user
    Route::delete(RECIPE_ID_URL, [RecipeController::class, 'delete']);

    //SHOPPING LIST
    //Get shopping-lists of the user
    Route::get("/shopping-lists", [ShoppingListController::class, 'me']);

    //Post a new shopping list for the user
    Route::post("/shopping-lists", fn() => "TODO");

    Route::middleware('middleware.listOwner')->group(function () {
        //Get the shopping-list with that id, only created by the user
        Route::get("/shopping-lists/{listId}", [ShoppingListController::class, 'show']);

        //Post a food into that shopping list, only if created by the user
        Route::post("/shopping-lists/{listId}/foods", fn() => "TODO");

        //Modify food in parameter of the list in parameter, only if that list is created by the user
        Route::put("/shopping-lists/{listId}/foods/{foodId}", fn() => "TODO");

        //Delete a concrete food from a concrete shopping list, only if created by the user
        Route::delete("/shopping-lists/{listId}/foods/{foodId}", [ShoppingListController::class, 'destroyListFood']);

        //Delete a concrete shopping list, only if created by the user
        Route::delete("/shopping-lists/{listId}", [ShoppingListController::class, 'destroy']);
    });
});



//AUTH
//Get the info of the current user (who am i) - Use middleware to verify if user is logged and has a token
Route::get("/auth/me", [UserController::class, 'me'])->middleware('middleware.auth.token');

//Register a user
Route::post("/auth/register", [UserController::class, 'register']);


//FOOD
//Get all the foods
Route::get("/food", [FoodController::class, 'all']);

//Get a food by id
Route::get("/food/{foodId}", [FoodController::class, 'show']);

//Post a food - Use middleware to verify if user is logged and has a token
Route::post("/food", [FoodController::class, 'post'])->middleware('middleware.auth.token');

/**
 * === FUTURE IMPLEMENTATION ===
 * Backoffice admin endpoints to handle users, recipes, and lists
 */
