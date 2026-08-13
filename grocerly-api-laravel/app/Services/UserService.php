<?php

namespace App\Services;

use App\DTOs\UserDTO;
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
     * @param string $token The token of the user
     * @return User The user with the token
     * @author  Oriol Plazas
     * @since 01/08/2026
     * @see App\Models\User.php
     */
    public function getByToken(string $token): ?User
    {
        return User::where('token', $token)->first();
    }

    /**
     * Create user in db
     * @param UserDTO $userDTO userDTO object of the user to insert
     * @return User The user inserted
     * @author  Oriol Plazas
     * @since 30/07/2026
     * @see App\Models\User.php
     */
    public function create(UserDTO $userDTO): User
    {
        return User::create([
            'name' => $userDTO->name,
            'token' => $userDTO->token,
        ]);
    }
}
