<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserService;

class AuthenticateWithToken
{
    public function __construct(private UserService $userService) {}

    /**
     * Handle an incoming request seeing if the petition comes with the token of the user.
     * @author  Oriol Plazas
     * @since 01/08/2026
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'No token provided'], 401);
        }

        $user = $this->userService->getByToken($token);
        if (!$user) {
            return response()->json(['message' => 'Invalid Token'], 401);
        }
        //Store user info so controller can access
        $request->setUserResolver(fn() => $user);
        return $next($request);
    }
}
