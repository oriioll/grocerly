<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FoodList extends Pivot
{
    protected $table = 'food_list';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'modified_at';

    protected $fillable = ['food_id', 'list_id'];
}
