<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipe';
    protected $primaryKey = 'recipe_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'modified_at';
    protected $fillable = [
        'is_public',
        'servings'
    ];

    //Relation with user
    public function user()
    {
        // Una receta pertenece a un usuario
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    //Relation with food
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'recipe_food', 'recipe_id', 'food_id')
            ->using(RecipeFood::class)
            ->withTimestamps();
    }
}
