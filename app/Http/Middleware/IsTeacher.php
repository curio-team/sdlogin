<?php

namespace App\Http\Middleware;

use Closure;

class IsTeacher
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user()->isTeacher()) {
            return abort(403, 'Geen toegang voor studenten.');
        }

        return $next($request);
    }
}
