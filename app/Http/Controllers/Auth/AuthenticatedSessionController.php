<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

    $user = Auth::user(); // Get the authenticated user

    // Redirect based on role
    switch ($user->role) {
        case 'sous-admin':
            return redirect()->route('sousAdmin'); // Redirect to sous-admin dashboard
        case 'admin':
            return redirect()->route('admin'); // Redirect to admin dashboard
        case 'client':
            return redirect()->route('dashboard'); // Redirect to client dashboard
        default:
            // Handle unknown roles (Optional)
            Auth::logout(); // Log out user if the role is unrecognized
            return redirect()->route('login')->with('error', 'Unauthorized access.');
    }
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
