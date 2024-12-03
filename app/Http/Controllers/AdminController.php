<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
{
    $admin = Auth::user(); // Authenticated admin user
    $users = User::whereIn('role', ['client', 'sous-admin'])->get();

    // Retrieve filter parameters
    $filters = [
        'ref_web' => $request->input('ref_web'),
        'type' => $request->input('type'),
        'date_creation' => $request->input('date_creation'),
        'date_parution' => $request->input('date_parution'),
    ];

    // Start building the query for pending announcements
    $query = Annonce::with(['user', 'paiement']) // Eager load the `paiement` relationship
                    ->where('status', 'pending');

    // Apply filters if they exist
    if ($filters['ref_web']) {
        $query->where('ref_web', $filters['ref_web']);
    }

    if ($filters['type']) {
        $query->where('type', $filters['type']);
    }

    if ($filters['date_creation']) {
        $query->whereDate('created_at', $filters['date_creation']);
    }

    if ($filters['date_parution']) {
        $query->whereDate('date_parution', $filters['date_parution']);
    }

    // Get the filtered results
    $annonces = $query->get();

    return view('/adminPanel/dashAdin', compact('admin', 'annonces', 'filters', 'users'));
}

    


    public function show(Annonce $annonce)
    {
        // Admin viewing the announcement details
        return view('/adminPanel/showAnnonce', compact('annonce'));
    }

    public function approveAnnonce(Request $request, $id)
    {
        $annonce = Annonce::find($id);

        if (!$annonce) {
            return redirect()->back()->with('error', 'Annonce not found');
        }

        $annonce->status = 'approved';
        $annonce->save();

        // Fetch updated approved announcements
        $approvedAnnonces = Annonce::where('status', 'approved')->get();

        return view('/adminPanel/approvedAnnonces', ['annonces' => $approvedAnnonces])
            ->with('success', 'Annonce approved successfully');
    }

    public function rejectAnnonce($id)
    {
        $annonce = Annonce::find($id);

        if (!$annonce) {
            return redirect()->back()->with('error', 'Annonce not found');
        }

        $annonce->status = 'rejected';
        $annonce->save();

        // Fetch updated rejected announcements
        $rejectedAnnonces = Annonce::where('status', 'rejected')->get();

        return view('/adminPanel/rejectedAnnonces', ['annonces' => $rejectedAnnonces])
            ->with('success', 'Annonce rejected successfully');
    }

    public function approvedAnnonce(Request $request)
    {
        $admin = Auth::user();
        // Retrieve filter parameters
        $filters = [
            'ref_web' => $request->input('ref_web'),
            'type' => $request->input('type'),
            'date_creation' => $request->input('date_creation'),
            'date_parution' => $request->input('date_parution'),
        ];

        // Start building the query for approved announcements
        $query = Annonce::with('user')->where('status', 'approved');

        // Apply filters if they exist
        if ($filters['ref_web']) {
            $query->where('ref_web', $filters['ref_web']);
        }

        if ($filters['type']) {
            $query->where('type', $filters['type']);
        }

        if ($filters['date_creation']) {
            $query->whereDate('created_at', $filters['date_creation']);
        }

        if ($filters['date_parution']) {
            $query->whereDate('date_parution', $filters['date_parution']);
        }

        // Get the filtered results
        $annonces = $query->get();

        return view('/adminPanel/approvedAnnonces', compact('annonces', 'filters', 'admin'));
    }

    public function rejectedAnnonce(Request $request)
    {
        $admin = Auth::user();
        // Retrieve filter parameters
        $filters = [
            'ref_web' => $request->input('ref_web'),
            'type' => $request->input('type'),
            'date_creation' => $request->input('date_creation'),
            'date_parution' => $request->input('date_parution'),
        ];

        // Start building the query for rejected announcements
        $query = Annonce::with('user')->where('status', 'rejected');

        // Apply filters if they exist
        
        if ($filters['ref_web']) {
            $query->where('ref_web', $filters['ref_web']);
        }

        if ($filters['type']) {
            $query->where('type', $filters['type']);
        }

        if ($filters['date_creation']) {
            $query->whereDate('created_at', $filters['date_creation']);
        }

        if ($filters['date_parution']) {
            $query->whereDate('date_parution', $filters['date_parution']);
        }

        // Get the filtered results
        $annonces = $query->get();

        return view('/adminPanel/rejectedAnnonces', compact('annonces', 'filters', 'admin'));
    }

    public function viewAnnonce($id)
    {
        // Fetch the announcement with its user
        $annonce = Annonce::with('user')->find($id);

        // Check if the announcement exists
        if (!$annonce) {
            return redirect()->back()->with('error', 'Annonce not found');
        }

        // Return the view with the announcement details
        return view('/adminPanel/viewAnnonce', compact('annonce'));
    }

    public function users(Request $request)
    {
        $authUserId = auth()->id(); // Get the currently authenticated user's ID

        // Get the search query from the request
        $search = $request->input('search');

        // Search users based on name or email, excluding the authenticated user
        $users = User::whereIn('role', ['client', 'sous-admin'])
                    ->where('id', '!=', $authUserId)
                    ->when($search, function ($query, $search) {
                        $query->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                    })
                    ->get();

        return view('/adminPanel/users', compact('users', 'search'));
    }


    public function createUser()
    {
        // Render the form to create a new user
        return view('/adminPanel/createUser');
    }

    public function storeUser(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:client,sous-admin', // Ensure role is valid
        ]);

        // Create the new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin')->with('success', 'User created successfully');
    }




    public function editUser($id)
    {
        $user = User::find($id);

        // Ensure the user exists
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        return view('/adminPanel/editUser', compact('user'));
    }

public function updateUser(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|in:client,sous-admin,admin', // Adjust roles as needed
    ]);

    $user = User::find($id);

    // Ensure the user exists
    if (!$user) {
        return redirect()->back()->with('error', 'User not found');
    }

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;
    $user->save();

    return redirect()->route('admin')->with('success', 'User updated successfully');
}

    public function deleteUser($id)
    {
        $user = User::find($id);

        // Ensure the user exists
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $user->delete();

        return redirect()->route('admin')->with('success', 'User deleted successfully');
    }


}
