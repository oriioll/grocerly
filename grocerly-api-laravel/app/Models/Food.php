<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'food';
    protected $primaryKey = 'food_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'modified_at';
    protected $fillable = [
        'name',
        'kcal',
        'category'
    ];

    //Relation with shopping list
    public function shoppingLists()
    {
        return $this->belongsToMany(ShoppingList::class, 'FOOD_LIST', 'food_id', 'list_id')
            ->using(FoodList::class) // <--- Aquí vinculas el modelo pivote
            ->withTimestamps();      // <--- Vital para leer created_at/modified_at del pivote
    }

    // Relation with recipe
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'RECIPE_FOODS', 'food_id', 'recipe_id')
            ->using(RecipeFood::class)
            ->withTimestamps();
    }
}
