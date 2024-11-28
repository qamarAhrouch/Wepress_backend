<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;

class AnnonceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $annonces = Annonce::where('user_id', auth()->id())->get();
        return view('annonces.index', compact('annonces', 'user'));
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
            'date_parution' => 'required|date|after_or_equal:' . now()->addDays(2)->format('Y-m-d'),
            'canal_de_publication' => 'required|string',
            'ville' => 'required|string',
            'publication_web' => 'required|boolean',
            'file_attachment' => 'nullable|mimes:pdf,jpeg,png,docx,doc|max:2048',
        ]);

        $filePath = $request->file('file_attachment') ? $request->file('file_attachment')->store('annonces_files', 'public') : null;

        $annonce = Annonce::create([
            'user_id' => auth()->id(),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'ice' => $request->input('ice'),
            'status' => 'pending',
            'ref_web' => 'web-' . uniqid(),
            'date_parution' => $request->input('date_parution'),
            'canal_de_publication' => $request->input('canal_de_publication'),
            'ville' => $request->input('ville'),
            'publication_web' => $request->boolean('publication_web'),
            'file_attachment' => $filePath,
        ]);

        return redirect()->route('annonces.confirmation', $annonce->id)->with('success', 'Annonce created successfully!');
    }


    public function confirmation(Annonce $annonce)
    {
        return view('annonces.confirmation', compact('annonce'));
    }

    public function edit(Annonce $annonce)
    {
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

        return redirect()->route('annonces.index')->with('success', 'Annonce updated successfully!');
    }

    public function show(Annonce $annonce)
    {
        // \Log::info('Annonce show method called', ['id' => $annonce->id]);

        return view('annonces.show', compact('annonce'));
    }



    public function destroy(Annonce $annonce)
    {
        $annonce->delete();
        return redirect()->route('annonces.index')->with('success', 'Annonce deleted successfully!');
    }

    public function payment(Annonce $annonce)
    {
        return redirect()->route('annonces.index')->with('success', 'Payment process started.');
    }

    public function cancel(Annonce $annonce)
    {
        $annonce->delete();
        return redirect()->route('annonces.index')->with('success', 'Annonce canceled successfully.');
    }
}
