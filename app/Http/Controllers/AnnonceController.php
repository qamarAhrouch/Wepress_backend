<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;

class AnnonceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // dd($user);
        $annonces = Annonce::where('user_id', auth()->id())->get();
        $annoncess = Annonce::all();
        // dd($annoncess);

        return view('annonces.index', compact('annonces', 'user','annoncess'));
    }

    public function create()
    {
        // Pass the current date to the view for calculating valid date options
        $today = now();
        return view('annonces.create', compact('today'));
    }
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required',
        'type' => 'required|in:constitution,cessation,modification',
        'ice' => 'required|string',
        'date_parution' => [
            'required',
            'date',
            function ($attribute, $value, $fail) {
                $date = new \DateTime($value);
                $weekendDays = [0, 6]; // Sunday = 0, Saturday = 6
                $publicHolidays = [
                    "01-01", "05-01", "07-30", "08-20", "08-21", "11-06", "11-18"
                ];
                $formattedDate = $date->format('m-d');
                if (in_array($date->format('w'), $weekendDays) || in_array($formattedDate, $publicHolidays)) {
                    $fail("The selected date falls on a weekend or a public holiday.");
                }
            },
        ],
        'canal_de_publication' => 'required|string',
        'ville' => 'required|string',
        'publication_web' => 'required|boolean',
        'file_attachment' => 'nullable|mimes:pdf,jpeg,png,docx,doc|max:2048',
    ]);

    // Handle file upload
    $filePath = null;
    if ($request->hasFile('file_attachment')) {
        $filePath = $request->file('file_attachment')->store('annonces_files', 'public');
    }

    // Create the announcement
    $annonce = Annonce::create([
        'user_id' => auth()->id(),
        'title' => $request->input('title'),
        'content' => $request->input('content'),
        'type' => $request->input('type'),
        'ice' => $request->input('ice'),
        'status' => 'pending',
        'date_parution' => $request->input('date_parution'),
        'canal_de_publication' => $request->input('canal_de_publication'),
        'ville' => $request->input('ville'),
        'publication_web' => $request->boolean('publication_web'),
        'file_attachment' => $filePath,
        'ref_web' => 'REF-' . strtoupper(uniqid()), // Generate ref_web
    ]);

    // Redirect to confirmation page
    return redirect()->route('annonces.confirmation', $annonce->id);
}
    



    public function confirmation(Annonce $annonce)
    {
        return view('annonces.confirmation', compact('annonce'));
    }

    public function edit(Annonce $annonce)
    {
        // Check if the status is approved or rejected
        if (in_array($annonce->status, ['approved', 'rejected'])) {
            return redirect()->route('annonces.index')->with('error', 'You cannot edit an announcement that has been approved or rejected.');
        }

        // If status is not approved or rejected, allow editing
        return view('annonces.edit', compact('annonce'));
    }



    public function update(Request $request, Annonce $annonce)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'type' => 'required|in:constitution,cessation,modification',
            'ice' => 'required|string',
            'date_parution' => 'required|date',
            'canal_de_publication' => 'required|string',
            'ville' => 'required|string',
            'publication_web' => 'required|boolean',
            'file_attachment' => 'nullable|mimes:pdf,jpeg,png,docx,doc|max:2048',
        ]);

        if ($request->hasFile('file_attachment')) {
            $filePath = $request->file('file_attachment')->store('annonces_files', 'public');
            $annonce->file_attachment = $filePath;
        }

        $annonce->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'ice' => $request->input('ice'),
            'status' => 'pending',
            'date_parution' => $request->input('date_parution'),
            'canal_de_publication' => $request->input('canal_de_publication'),
            'ville' => $request->input('ville'),
            'publication_web' => $request->boolean('publication_web'),
        ]);

        return redirect()->route('annonces.index');
    }

    public function show(Annonce $annonce)
    {
        // \Log::info('Annonce show method called', ['id' => $annonce->id]);

        return view('annonces.show', compact('annonce'));
    }



    public function destroy(Annonce $annonce)
    {
        // Check if the status is approved or rejected
        if (in_array($annonce->status, ['approved', 'rejected'])) {
            return redirect()->route('annonces.index')->with('error', 'You cannot delete an announcement that has been approved or rejected.');
        }

        // Delete the announcement if allowed
        $annonce->delete();

        return redirect()->route('annonces.index');
    }

    public function payment(Annonce $annonce)
    {
        return redirect()->route('annonces.index');
    }

    public function cancel(Annonce $annonce)
    {
        $annonce->delete();
        return redirect()->route('annonces.index')->with('success', 'Annonce canceled successfully.');
    }

    public function publierIndex()
    {
        // Fetch all announcements with pagination
        $annoncess = Annonce::where('status', 'approved')->paginate(10); // Change `10` to the desired items per page
        return view('annoncepublier', compact('annoncess'));
    }
    

}
