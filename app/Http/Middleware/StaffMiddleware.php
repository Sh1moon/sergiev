<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            abort(403, 'Доступ запрещен');
        }

        $user = Auth::user();
        if (!$user->role || !in_array($user->role->slug, [Role::ADMIN, Role::EMPLOYEE], true)) {
            abort(403, 'Недостаточно прав для управления контентом');
        }

        return $next($request);
    }
}
