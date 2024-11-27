<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Validate the current password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return Redirect::route('profile.edit')->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the user's information
        $user->fill($request->except(['password', 'current_password', 'password_confirmation']));

        // Update the password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validate the password before deleting the account
        $request->validate([
            'password' => ['required', 'current_password'], // Ensure the user enters the correct password
        ]);

        $user = $request->user();

        // Log the user out
        Auth::logout();

        // Delete the user's account
        $user->delete();

        // Invalidate the session and regenerate the token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'account-deleted');
    }

}
