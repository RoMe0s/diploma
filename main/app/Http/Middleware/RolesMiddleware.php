<?php

namespace App\Http\Middleware;

use Closure;

class RolesMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param string ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, string ...$roles)
    {
        $user = $request->user();
        if ($user && in_array($user->role, array_filter($roles))) {
            return $next($request);
        }
        abort(403);
    }
}
