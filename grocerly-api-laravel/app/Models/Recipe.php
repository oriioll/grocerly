<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipes';
    protected $primaryKey = 'recipe_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'modified_at';
    protected $fillable = [
        'name',
        'user_id',
        'is_public',
        'servings'
    ];

    //Relation with user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    //Relation with food
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'recipe_foods', 'recipe_id', 'food_id')
            ->using(RecipeFood::class)
            ->withTimestamps();
    }
}
