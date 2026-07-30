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
        return $this->belongsToMany(ShoppingList::class, 'food_lists', 'food_id', 'list_id')
            ->using(FoodList::class)
            ->withTimestamps();
    }

    // Relation with recipe
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_foods', 'food_id', 'recipe_id')
            ->using(RecipeFood::class)
            ->withTimestamps();
    }
}
