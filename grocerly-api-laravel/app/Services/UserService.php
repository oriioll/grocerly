<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{

    /**
     * Get a user by its id
     * @param int $userId The id of the user
     * @return User The user with the id
     * @author  Oriol Plazas
     * @since 30/07/2026
     * @see App\Models\Food.php
     */
    public function getById(int $userId): User
    {
        return User::findOrFail($userId);
    }

    /**
     * Create user in db
     * @param User $user User to insert
     * @return bool Insert result
     * @author  Oriol Plazas
     * @since 30/07/2026
     * @see App\Models\Food.php
     */
    public function create(User $user): bool
    {
        return $user->save();
    }
}
