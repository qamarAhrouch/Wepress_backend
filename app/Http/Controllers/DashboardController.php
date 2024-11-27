<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
         #var_dump($user);
        // Fetch user-specific statistics
        $announcementsCount = Annonce::where('user_id', $user->id)->count();
        $pendingCount = Annonce::where('user_id', $user->id)->where('status', 'pending')->count();
        $approvedCount = Annonce::where('user_id', $user->id)->where('status', 'approved')->count();
        $rejectedCount = Annonce::where('user_id', $user->id)->where('status', 'rejected')->count();

        // Return data to the view
        return view('dashboard', [
            'user' => $user,
            'announcementsCount' => $announcementsCount,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }
}
