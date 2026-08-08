<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\ShoppingListService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserService;

class ListCreatedByUser
{
    public function __construct(private ShoppingListService $listService) {}

    /**
     * Handle an incoming request seeing if the listId in the parameter is created by the user
     * @author  Oriol Plazas
     * @since 08/08/2026
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->user()->user_id;
        $listId = $request->route('listId');
        if ($this->listService->listCreatedByUser($listId, $userId)) {
            return $next($request);
        } else {
            return response()->json(['message' => 'Invalid list'], 403);
        }
    }
}
