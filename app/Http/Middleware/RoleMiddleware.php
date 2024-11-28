<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // If the user is not authenticated, redirect to login
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        // If the user's role is not in the allowed roles, deny access
        if (!in_array($user->role, $roles)) {
            // Log the unauthorized attempt (optional)
            \Log::warning('Unauthorized access attempt by user ' . $user->id);
            return abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
