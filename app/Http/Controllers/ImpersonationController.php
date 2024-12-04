<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model
use App\Models\ImpersonationLog; // Import the ImpersonationLog model

class ImpersonationController extends Controller
{
    // Method to start impersonation
    public function impersonate($userId)
    {
        $admin = Auth::user();
    
        // Ensure the user is an admin
        if (!$admin || $admin->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    
        // Automatically stop the current impersonation session if active
        if (session()->has('impersonate_admin_id')) {
            $this->stopImpersonation();
        }
    
        $user = User::findOrFail($userId); // Find the user to impersonate
    
        // Save the admin's ID in the session to allow returning later
        session()->put('impersonate_admin_id', $admin->id);
    
        // Log impersonation start
        ImpersonationLog::create([
            'admin_id' => $admin->id,
            'user_id' => $user->id, // Use the correct column name
            'started_at' => now(),
        ]);
    
        // Log in as the client
        Auth::login($user);
    
        return redirect()->route('dashboard')->with('success', 'You are now impersonating ' . $user->name);
    }
    
    
    // Method to stop impersonation
    public function stopImpersonation()
    {
        if (!session()->has('impersonate_admin_id')) {
            return redirect()->route('admin')->with('error', 'You are not impersonating any user.');
        }
    
        // Log end of impersonation
        $log = ImpersonationLog::where('admin_id', session('impersonate_admin_id'))
            ->whereNull('ended_at')
            ->first();
        if ($log) {
            $log->update(['ended_at' => now()]);
        }
    
        // Get the admin ID and log back in as the admin
        $adminId = session()->get('impersonate_admin_id');
        $admin = User::findOrFail($adminId);
        Auth::login($admin);
    
        // Forget the impersonation session
        session()->forget('impersonate_admin_id');
    
        return redirect()->route('admin')->with('success', 'You are no longer impersonating any user.');
    }
}
