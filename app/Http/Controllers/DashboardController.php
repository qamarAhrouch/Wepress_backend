<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;
use App\Models\Pack;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $announcementsCount = Annonce::where('user_id', $user->id)->count();
        $pendingCount = Annonce::where('user_id', $user->id)->where('status', 'pending')->count();
        $approvedCount = Annonce::where('user_id', $user->id)->where('status', 'approved')->count();
        $rejectedCount = Annonce::where('user_id', $user->id)->where('status', 'rejected')->count();

        // Define all available packs
        $availablePacks = [
            (object)[
                'name' => 'Silver',
                'number_of_annonces' => 10,
                'unit_price' => 130,
                'total_price' => 1300,
            ],
            (object)[
                'name' => 'Gold',
                'number_of_annonces' => 20,
                'unit_price' => 120,
                'total_price' => 2400,
            ],
            (object)[
                'name' => 'Platinum',
                'number_of_annonces' => 50,
                'unit_price' => 100,
                'total_price' => 5000,
            ],
        ];

        // Fetch user purchased packs
        $userPacks = $user->packs;

        return view('dashboard', [
            'user' => $user,
            'announcementsCount' => $announcementsCount,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'userPacks' => $userPacks, // Purchased packs
            'availablePacks' => $availablePacks, // Packs for purchase
        ]);
    }
}
