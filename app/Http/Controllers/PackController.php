<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pack;

class PackController extends Controller
{
    // Purchase a pack
    public function purchase(Request $request)
    {
        $request->validate([
            'pack_type' => 'required|in:Silver,Gold,Platinum',
        ]);

        $packDetails = $this->getPackDetails($request->pack_type);

        $user = auth()->user();
        $existingPack = $user->packs()->where('pack_type', $packDetails['type'])->first();

        if ($existingPack) {
            $existingPack->increment('remaining_annonces', $packDetails['annonces']);
        } else {
            $user->packs()->create([
                'pack_type' => $packDetails['type'],
                'total_annonces' => $packDetails['annonces'],
                'remaining_annonces' => $packDetails['annonces'],
                'price_per_annonce' => $packDetails['price_per_annonce'],
                'total_price' => $packDetails['total_price'],
            ]);
        }

        // Redirect directly to the create announcement form
        return redirect()->route('annonces.create', ['pack' => $request->pack_type]);
    }

    private function getPackDetails($type)
    {
        $packs = [
            'Silver' => ['type' => 'Silver', 'annonces' => 10, 'price_per_annonce' => 130, 'total_price' => 1300],
            'Gold' => ['type' => 'Gold', 'annonces' => 20, 'price_per_annonce' => 120, 'total_price' => 2400],
            'Platinum' => ['type' => 'Platinum', 'annonces' => 50, 'price_per_annonce' => 100, 'total_price' => 5000],
        ];

        return $packs[$type];
    }
}
