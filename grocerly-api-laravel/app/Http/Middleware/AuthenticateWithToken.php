<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateWithToken
{
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

        $user = User::where('token', hash('sha256', $token))->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid Token'], 401);
        }
        //Store user info so controller can access
        $request->setUserResolver(fn() => $user);
        return $next($request);
    }
}
