<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'modified_at';
    protected $fillable = [
        'name',
        'token',
    ];

    //Relation with recipe
    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'user_id', 'user_id');
    }

    //Relation with shoppingList
    public function shoppingLists()
    {
        return $this->hasMany(ShoppingList::class, 'user_id', 'user_id');
    }
}
