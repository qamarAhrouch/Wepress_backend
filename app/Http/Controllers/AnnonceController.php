<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Annonce;
use App\Models\Paiement;
use Barryvdh\DomPDF\Facade\Pdf;
class AnnonceController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Current authenticated user
        // dd($user);
    
        // Fetch announcements for the authenticated user
        $annonces = Annonce::where('user_id', auth()->id())
            ->with('paiement') // Eager load the paiement relationship to get payment details
            ->get();
    
        $annoncess = Annonce::all(); // Fetch all announcements
        // dd($annoncess);
    
        return view('annonces.index', compact('annonces', 'user', 'annoncess')); // Pass all variables to the view
    }
    
    // public function create()
    // {
    //     // Pass the current date to the view for calculating valid date options
    //     $today = now();
    //     return view('annonces.create', compact('today'));
    // }
    // Create a new annonce
    public function create(Request $request)
    {
        $today = now();
        $pack = $request->query('pack', null);
        return view('annonces.create', compact('today', 'pack'));
    }
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'content' => 'required',
    //         'type' => 'required|in:constitution,cessation,modification',
    //         'canal_de_publication' => 'required|string',
    //         'ville' => 'required|string',
    //         'autre_ville' => 'nullable|string|max:255',
    //         'publication_web' => 'required|boolean',
    //         'file_attachment' => 'nullable|mimes:pdf,jpeg,png,docx,doc|max:2048',
    //         'ice' => 'required|digits:15', // Validation rule for exactly 15 digits
    //     ]);
    
    //     // Check if "Autre" was selected and use the manually entered city
    //     $ville = $request->input('ville') === 'Autre' ? $request->input('autre_ville') : $request->input('ville');
    
    //     // Handle file upload
    //     $filePath = null;
    //     if ($request->hasFile('file_attachment')) {
    //         $filePath = $request->file('file_attachment')->store('annonces_files', 'public');
    //     }
    
    //     // Create the announcement
    //     $annonce = Annonce::create([
    //         'user_id' => auth()->id(),
    //         'title' => $request->input('title'),
    //         'content' => $request->input('content'),
    //         'type' => $request->input('type'),
    //         'ice' => $request->input('ice'),
    //         'status' => 'pending',
    //         'canal_de_publication' => $request->input('canal_de_publication'),
    //         'ville' => $ville,
    //         'publication_web' => $request->boolean('publication_web'),
    //         'file_attachment' => $filePath,
    //         'ref_web' => 'REF-' . strtoupper(uniqid()),
    //     ]);
    
    //     // Create a corresponding payment record
    //     $annonce->paiement()->create([
    //         'user_id' => auth()->id(),
    //         'amount' => 150.00,
    //         'tax' => 30.00,
    //         'total' => 180.00,
    //         'status' => 'pending',
    //         'method' => null,
    //         'reference_number' => uniqid('PAY'),
    //     ]);
    
    //     // Redirect to confirmation page
    //     return redirect()->route('annonces.confirmation', $annonce->id);
    // }

    // Store annonce
    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'type' => 'required|in:constitution,cessation,modification',
            'canal_de_publication' => 'required|string',
            'ville' => 'required|string',
            'autre_ville' => 'nullable|string|max:255',
            'publication_web' => 'required|boolean',
            'file_attachment' => 'nullable|mimes:pdf,jpeg,png,docx,doc|max:2048',
            'ice' => 'required|digits:15',
            'pack' => 'nullable|in:Silver,Gold,Platinum',
        ]);

        // Determine city input
        $ville = $request->input('ville') === 'Autre' ? $request->input('autre_ville') : $request->input('ville');

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file_attachment')) {
            $filePath = $request->file('file_attachment')->store('annonces_files', 'public');
        }

        // Initialize pricing and pack-related variables
        $pricePerAnnonce = 150.00; // Default price
        $packType = $request->input('pack');
        $user = auth()->user();
        $packId = null;

        if ($packType) {
            $pack = $user->packs()->where('pack_type', $packType)->first();

            // Validate pack availability
            if (!$pack || $pack->remaining_annonces <= 0) {
                return redirect()->back()->withErrors([
                    'pack' => 'You do not have sufficient remaining annonces in the selected pack.',
                ]);
            }

            $pricePerAnnonce = $pack->price_per_annonce;
            $packId = $pack->id; // Save the pack_id

            // Decrement remaining annonces
            $pack->decrement('remaining_annonces'); // Deduct one annonce from the pack
            
            // *** Update Total Price of Pack ***
            // Explanation: We deduct the price of the used annonce from the total pack price.
            $pack->total_price -= $pricePerAnnonce;
            $pack->save(); // Save the updated total price to the database
        }

        // Create the announcement
        $annonce = Annonce::create([
            'user_id' => $user->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'ice' => $request->input('ice'),
            'status' => 'pending',
            'canal_de_publication' => $request->input('canal_de_publication'),
            'ville' => $ville,
            'publication_web' => $request->boolean('publication_web'),
            'file_attachment' => $filePath,
            'ref_web' => 'REF-' . strtoupper(uniqid()),
        ]);

        // Create a corresponding payment record
        $paiement = $annonce->paiement()->create([
            'user_id' => $user->id,
            'annonce_id' => $annonce->id,
            'pack_id' => $packId, // Link the payment to the pack
            'amount' => $pricePerAnnonce,
            'tax' => $pricePerAnnonce * 0.2, // Example tax calculation
            'total' => $pricePerAnnonce * 1.2,
            'status' => 'pending',
            'method' => null,
            'reference_number' => uniqid('PAY'),
        ]);

        // Log an error if the pack_id is not saved
        if (!$paiement->pack_id) {
            \Log::error('Pack ID not saved to paiement', ['pack_id' => $packId]);
        }

        // Redirect to confirmation page
        return redirect()->route('annonces.confirmation', $annonce->id);
    }


    


   

    // public function confirmation(Annonce $annonce)
    // {
    //     return view('annonces.confirmation', compact('annonce'));
    // }
    public function confirmation(Annonce $annonce)
    {
        $user = Auth::user();
        $packDetails = null;

        // Fetch pack details based on the payment amount
        if ($annonce->paiement) {
            switch ($annonce->paiement->amount) {
                case 130.00:
                    $packDetails = 'Silver Pack (130 DH per annonce)';
                    break;
                case 120.00:
                    $packDetails = 'Gold Pack (120 DH per annonce)';
                    break;
                case 100.00:
                    $packDetails = 'Platinum Pack (100 DH per annonce)';
                    break;
                default:
                    $packDetails = 'No Pack Selected (150 DH default)';
            }
        }

        return view('annonces.confirmation', compact('annonce', 'packDetails', 'user'));
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
        'ice' => 'required|digits:15', // Enforce 15 numeric characters for ICE
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
        'canal_de_publication' => $request->input('canal_de_publication'),
        'ville' => $request->input('ville'),
        'publication_web' => $request->boolean('publication_web'),
    ]);

    return redirect()->route('annonces.index');
}

    public function show(Annonce $annonce)
    {
        // \Log::info('Annonce show method called', ['id' => $annonce->id]);
        session(['previous' => url()->previous()]);
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
    public function payment(Request $request, Annonce $annonce)
    {
        // Ensure terms are accepted (server-side validation)
        if (!$request->has('terms')) {
            return back()->withErrors(['terms' => 'Vous devez accepter les conditions générales avant de continuer.']);
        }

        // Update the payment status to 'complet'
        $annonce->paiement->update(['status' => 'complet']);

        // Redirect back to the index page with a success message
        return redirect()->route('annonces.index') ;
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



    

    public function generateInvoice($paiementId)
{
    $paiement = Paiement::with('annonce.user')->findOrFail($paiementId);

    // Assign a sequential invoice number if not already set
    if (!$paiement->invoice_number) {
        $lastInvoiceNumber = Paiement::max('invoice_number'); // Get the last used invoice number
        $paiement->invoice_number = $lastInvoiceNumber ? $lastInvoiceNumber + 1 : 1; // Start with 1 if no previous invoice exists
        $paiement->save();
    }

    // List of society types to match
    $societyTypes = [
        'SARL',
        'SARLAU',
        'SNC',
        'SCS',
        'SCA',
        'Société Anonyme Simplifiée \(SAS\)',
        'Société Anonyme \(SA\)',
        'Groupement d\'Intérêt Économique \(GIE\)'
    ];

    // Build the regex pattern
    $pattern = '/\b(' . implode('|', $societyTypes) . ')\b/i';

    // Extract the society type from the content
    $societyType = 'Non spécifié'; // Default value
    if ($paiement->annonce && preg_match($pattern, $paiement->annonce->content, $matches)) {
        $societyType = $matches[1]; // First match
    }

    $data = [
        'paiement' => $paiement,
        'societyType' => $societyType, // Pass extracted society type
    ];

    // Ensure the view exists before generating PDF
    if (!view()->exists('invoices.invoice')) {
        abort(500, "Invoice view not found.");
    }

    $pdf = Pdf::loadView('invoices.invoice', $data);
    return $pdf->download('invoice_' . $paiement->invoice_number . '.pdf');
}
    

}
