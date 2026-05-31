<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboarded
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // If the user is authenticated, has NOT onboarded, and is not on the onboarding page, redirect to onboarding.
            if (!$user->onboarded && !$request->routeIs('onboarding') && !$request->routeIs('logout')) {
                return redirect()->route('onboarding');
            }

            // If the user has already onboarded and is trying to access the onboarding route, redirect them to the dashboard.
            if ($user->onboarded && $request->routeIs('onboarding')) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
