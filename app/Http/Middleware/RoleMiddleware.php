<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            abort(403, 'Доступ запрещен');
        }

        $user = Auth::user();
        
        if (!$user->role || $user->role->slug !== $role) {
            abort(403, 'Недостаточно прав');
        }

        return $next($request);
    }
}