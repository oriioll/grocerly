<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPostRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}
    /**
     * Gets the information of the current user, knows the user thanks to the middleware
     * @author Oriol Plazas
     * @since 01/08/2026
     */
    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json($user);
    }

    /**
     * Gets creates a user into the db using the name and the token sent in request and previously validated
     * @author Oriol Plazas
     * @since 01/08/2026
     */
    public function register(UserPostRequest $request)
    {
        //Array with name and token, validated using UserPostRequest
        $newUser = $request->validated();
        $userCreated = $this->userService->create($newUser);
        return response()->json($userCreated);
    }
}
