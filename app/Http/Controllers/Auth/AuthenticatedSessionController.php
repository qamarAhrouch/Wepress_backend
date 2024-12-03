<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request; // Import the correct Request class

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
    
        $user = Auth::user();
    
        if (!$user->role) {
            Auth::logout(); // Logout the user if role is invalid
            return redirect()->route('login')->with('error', 'Your account is not properly configured.');
        }
    
        // Redirect users based on role
        return match ($user->role) {
            'sous-admin' => redirect()->route('sousAdmin'),
            'admin' => redirect()->route('admin'),
            'client' => redirect()->route('dashboard'),
            default => redirect()->route('login')->with('error', 'Invalid role.'),
        };
    }
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

}
