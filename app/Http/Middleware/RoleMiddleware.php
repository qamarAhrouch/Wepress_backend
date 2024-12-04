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
    
        // Allow access if the user is impersonating someone else
        if (session()->has('impersonate_admin_id')) {
            return $next($request);
        }
    
        // Regular role check
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }
    
        if (!in_array($user->role, $roles)) {
            \Log::warning('Unauthorized access attempt by user ' . $user->id);
            return abort(403, 'Unauthorized access.');
        }
    
        return $next($request);
    }
    
}
