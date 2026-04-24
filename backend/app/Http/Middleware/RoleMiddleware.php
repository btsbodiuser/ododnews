<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Usage: ->middleware('role:admin') or ->middleware('role:admin,editor')
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();
        if (! $user || ! $user->canAccessAdmin()) {
            abort(403);
        }

        if ($roles && ! $user->hasRole($roles) && ! $user->isAdmin()) {
            abort(403, 'Танд энэ хуудасны эрх байхгүй байна.');
        }

        return $next($request);
    }
}
