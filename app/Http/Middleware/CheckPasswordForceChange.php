<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordForceChange
{
    private const EXCLUDED_ROUTES = ['users.profile_update', 'users.profile', 'logout'];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->password_force_change) {
            if (!in_array($request->route()->getName(), self::EXCLUDED_ROUTES)) {
                return redirect()->route('users.profile', $request->user())
                    ->withErrors('Je wachtwoord is verlopen. Wijzig je wachtwoord voordat je verder gaat.');
            }
        }

        return $next($request);
    }
}
