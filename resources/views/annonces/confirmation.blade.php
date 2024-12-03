@extends('layouts.app')

@section('content')
<h1 style="text-align: center; margin-bottom: 20px;">Prévisualiser votre annonce</h1>

<div style="display: flex; justify-content: space-between;">
    <!-- Preview Section -->
    <div style="width: 60%; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f5f5f5;">
        <h2><b> Contenu de l'annonce</b> </h2>
        <p>{{ $annonce->content }}</p>
    </div>

    <!-- Confirmation Section -->
    <div style="width: 35%; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
        <h2>Confirmation de contenu</h2>
        
        <!-- User Name -->
        <p><strong>{{ auth()->user()->name }}</strong></p>

        <p>Voici un récapitulatif de votre commande:</p>
        <div style="border: 1px solid #ddd; padding: 10px; border-radius: 4px; background-color: #f5f5f5;">
            <p><strong>Type:</strong> {{ ucfirst($annonce->type) }}</p>
            <p><strong>Référence:</strong> {{ $annonce->ref_web }}</p>
        </div>

        <!-- Pricing Section -->
        <div style="margin-top: 20px;">
            @php
                $packDetails = 'No Pack Selected (Default Price)';
                $priceHT = 150.00;
                $priceTVA = 30.00;
                $priceTTC = 180.00;

                if ($annonce->paiement) {
                    switch ($annonce->paiement->amount) {
                        case 130.00:
                            $packDetails = 'Silver Pack (130 DH per annonce)';
                            $priceHT = 130.00;
                            $priceTVA = 26.00;
                            $priceTTC = 156.00;
                            break;
                        case 120.00:
                            $packDetails = 'Gold Pack (120 DH per annonce)';
                            $priceHT = 120.00;
                            $priceTVA = 24.00;
                            $priceTTC = 144.00;
                            break;
                        case 100.00:
                            $packDetails = 'Platinum Pack (100 DH per annonce)';
                            $priceHT = 100.00;
                            $priceTVA = 20.00;
                            $priceTTC = 120.00;
                            break;
                    }
                }
            @endphp
            <p><strong>Pack Selected:</strong> {{ $packDetails }}</p>
            <p><strong>Prix Total HT:</strong> {{ number_format($priceHT, 2) }} DH</p>
            <p><strong>Prix Total TVA:</strong> {{ number_format($priceTVA, 2) }} DH</p>
            <p><strong>Prix Total TTC:</strong> {{ number_format($priceTTC, 2) }} DH</p>
        </div>

        <!-- Coupon Code Section -->
        <div style="margin-top: 20px;">
            <label for="coupon" style="display: block; font-weight: bold; margin-bottom: 5px;">Utilisez un code coupon</label>
            <input type="text" id="coupon" name="coupon" placeholder="Entrez le code coupon" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <button type="button" onclick="applyCoupon()" style="margin-top: 10px; width: 100%; padding: 10px; background-color: #a7a5a5; color: white; border: none; border-radius: 4px; cursor: pointer;">Appliquer</button>
        </div>

        <!-- Terms and Conditions Checkbox -->
        <div style="margin-top: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 10px;">
                <input type="checkbox" id="termsCheckbox">
                J'ai lu et j'accepte les <a href="#" style="color: #007bff; text-decoration: underline;">conditions générales</a>.
            </label>
        </div>

        <!-- Action Buttons -->
        <div style="margin-top: 20px; display: flex; justify-content: space-between;">
            <form id="paymentForm" action="{{ route('annonces.payment', $annonce) }}" method="POST" style="width: 48%;">
                @csrf
                <input type="hidden" name="terms" value="1">
                <button type="submit" style="width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Payer votre commande
                </button>
            </form>
            <form action="{{ route('annonces.cancel', $annonce) }}" method="POST" style="width: 48%;">
                @csrf
                <button type="submit" style="width: 100%; padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Annuler
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function applyCoupon() {
        alert('Fonctionnalité de coupon à implémenter');
    }

    // Prevent form submission if the checkbox is not checked
    document.getElementById('paymentForm').addEventListener('submit', function(event) {
        const checkbox = document.getElementById('termsCheckbox');
        if (!checkbox.checked) {
            event.preventDefault();
            alert('Vous devez accepter les conditions générales avant de continuer.');
        }
    });
</script>
@endsection
