<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Auth Check:', [
            'session_id' => $request->session()->getId(),
            'is_authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'current_route' => $request->route()->getName(),
            'request_path' => $request->path()
        ]);
        if (Auth::check()) {
            // If this is already the login page, redirect to dashboard
            if ($request->routeIs('login')) {
                return Inertia::location('/dashboard');
            }
        } else {
            // User is not authenticated and trying to access protected route
            if (!$request->routeIs('login')) {
                return Inertia::location('/login');
            }
        }

        return $next($request);
    }
}
