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
            <p><strong>Date de parution:</strong> {{ $annonce->date_parution }}</p>
        </div>

        <!-- Pricing Section -->
        <div style="margin-top: 20px;">
            <p><strong>Prix Total HT:</strong> 150.00 DH</p>
            <p><strong>Prix Total TVA:</strong> 30.00 DH</p>
            <p><strong>Prix Total TTC:</strong> 180.00 DH</p>
        </div>

        <!-- Coupon Code Section -->
        <div style="margin-top: 20px;">
            <label for="coupon" style="display: block; font-weight: bold; margin-bottom: 5px;">Utilisez un code coupon</label>
            <input type="text" id="coupon" name="coupon" placeholder="Entrez le code coupon" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <button type="button" onclick="applyCoupon()" style="margin-top: 10px; width: 100%; padding: 10px; background-color: #a7a5a5; color: white; border: none; border-radius: 4px; cursor: pointer;">Appliquer</button>
        </div>

        <!-- Action Buttons -->
        <div style="margin-top: 20px; display: flex; justify-content: space-between;">
            <form action="{{ route('annonces.payment', $annonce) }}" method="POST" style="width: 48%;">
                @csrf
                <button type="submit" style="width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">Payer votre commande</button>
            </form>
            <form action="{{ route('annonces.cancel', $annonce) }}" method="POST" style="width: 48%;">
                @csrf
                <button type="submit" style="width: 100%; padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">Annuler</button>
            </form>
        </div>
    </div>
</div>

<script>
    function applyCoupon() {
        // Placeholder function for applying a coupon code
        alert('Fonctionnalité de coupon à implémenter');
    }
</script>
@endsection
