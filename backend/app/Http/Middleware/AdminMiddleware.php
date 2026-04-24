<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user || ! $user->canAccessAdmin()) {
            if ($request->expectsJson()) {
                abort(403);
            }
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
