<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

function todo()
{
    return "TODO";
}

//RECIPES
//Get all public recipes
Route::get("/recipes", todo());

//Get all recipes created by the user
Route::get("/recipes/me", todo());

//Get a concrete recipe only if is public or made by the user
Route::get("/recipes/{recipeId}", todo());

//Post a recipe - sent in request body
Route::post("/recipes", todo());

//Modify the recipe with url recipe id using request body, only if created by the user
Route::put("/recipes/{recipeId}", todo());

//Delete a concrete recipe, only if created by the user
Route::delete("/recipes/{recipeId}", todo());

//SHOPPING LIST
//Get shopping-list of the user
Route::get("/shopping-lists", todo());

//Get the recipe with that id, only created by the user
Route::get("/shopping-lists/{listId}", todo());

//Post a new shopping list for the user
Route::post("/shopping-lists", todo());

//Post a food into that shopping list, only if created by the user
Route::post("/shopping-lists/{listId}/foods", todo());

//Modify food in parameter of the list in parameter, only if that list is created by the user
Route::put("/shopping-lists/{listId}/foods/{foodId}", todo());

//Delete a concrete food from a concrete shopping list, only if created by the user
Route::delete("/shopping-lists/{listId}/foods/{foodId}", todo());

//Delete a concrete shopping list, only if created by the user
Route::delete("/shopping-lists/{listId}", todo());

//AUTH
//Get the info of the current user (who am i)
Route::get("/auth/me", todo());

//Register a user
Route::post("/auth/register", todo());

/**
 * === FUTURE IMPLEMENTATION ===
 * Backoffice admin endpoints to handle users, recipes, and lists
 */
