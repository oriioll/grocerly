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
     * @see App\Models\User.php
     */
    public function getById(int $userId): User
    {
        return User::findOrFail($userId);
    }

    /**
     * Get a user by its token
     * @param string $unhashedToken The token of the user
     * @return User The user with the token
     * @author  Oriol Plazas
     * @since 01/08/2026
     * @see App\Models\User.php
     */
    public function getByToken(string $unhashedToken): ?User
    {
        $hashedToken = hash('sha256', $unhashedToken);
        return User::where('token', $hashedToken)->first();
    }

    /**
     * Create user in db
     * @param User $user User to insert
     * @return bool Insert result
     * @author  Oriol Plazas
     * @since 30/07/2026
     * @see App\Models\User.php
     */
    public function create(User $user): bool
    {
        return $user->save();
    }
}
