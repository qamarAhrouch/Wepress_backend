<?php

namespace App\Http\Controllers;
use App\Models\Annonce;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    
    public function index()
{
    $user = Auth::user();
    $annonces = Annonce::where('status', 'pending')->get(); 
    return view('/adminPanel/dashAdin', compact('user', 'annonces'));
}

public function approveAnnonce(Request $request, $id)
{
    // Find the annonce by ID
    $annonce = Annonce::find($id);

    // Check if the annonce exists
    if (!$annonce) {
        return response()->json(['message' => 'Annonce not found'], 404);
    }

    // Update the status to approved
    $annonce->status = 'approved';
    $annonce->save();

    // Return a success response
    return response()->json(['message' => 'Annonce approved successfully'], 200);
}
public function rejectAnnonce($id)
{
    $annonce = Annonce::find($id);

    if (!$annonce) {
        return redirect()->back()->with('error', 'Annonce not found');
    }

    $annonce->status = 'rejected';
    $annonce->save();

    return redirect()->back()->with('success', 'Annonce rejected successfully');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
