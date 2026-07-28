<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    protected $table = 'shopping_list';
    protected $primaryKey = 'list_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'modified_at';

    //Relation with user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    //Relation with food
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'food_list', 'list_id', 'food_id')
            ->using(FoodList::class)
            ->withTimestamps();
    }
}
