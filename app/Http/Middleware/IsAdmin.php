<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user()->isAdmin()) {
            return abort(403, 'Geen toegang. Adminrechten vereist.');
        }

        return $next($request);
    }
}
