<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RecipeFood extends Pivot
{
    protected $table = 'recipe_foods';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'modified_at';

    protected $fillable = ['food_id', 'recipe_id', 'grams'];
}
