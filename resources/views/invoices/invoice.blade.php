<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.4;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px 10px;
        }
        .logo img {
            max-width: 300px; /* Increased size for better visibility */
        }
        .company-info {
            text-align: right;
        }
        .company-info p {
            margin: 0;
        }
        .content {
            margin: 0 auto;
            max-width: 800px;
            padding: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
        .footer .black-section {
            background-color: #e2161b;
            color: white;
            padding: 5px 0;
            font-size: 12px;
            font-weight: bold;
        }
        .footer .thank-you {
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/wepress.jpg') }}" alt="WePress Eco">
        </div>
        <div class="company-info">
            <p>06.63.30.60.45</p>
            <p>wepress.ma</p>
            <p>Av. Moulay Ismail, Résidence Moulay Ismail<br>4ème Etg N 16 Tanger 90060, Morocco</p>
        </div>
    </div>
    <div class="content">
        <h2 style="text-align: center; margin-bottom: 20px;">Reçu </h2>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        <p><strong>Reçu N°:</strong> {{ $paiement->invoice_number }}</p>
        <p><strong>A:</strong> {{ $paiement->annonce->user->name }}</p>

        <h3 style="margin-bottom: 10px;">Détails de l'annonce</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Coût</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $paiement->annonce->type }}</td>
                    <td>1</td>
                    <td>{{ number_format($paiement->amount, 2) }} MAD</td>
                    <td>{{ number_format($paiement->amount, 2) }} MAD</td>
                </tr>
            </tbody>
        </table>

        <h3 style="margin-top: 15px;">Résumé</h3>
        <table class="table">
            <tbody>
                <tr>
                    <td>Subtotal</td>
                    <td>{{ number_format($paiement->amount, 2) }} MAD</td>
                </tr>
                <tr>
                    <td>Tax (20%)</td>
                    <td>{{ number_format($paiement->tax, 2) }} MAD</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>{{ number_format($paiement->total, 2) }} MAD</td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top: 15px;">Arrêtée la présente facture à la somme de: <strong>{{ ucfirst(trans(\NumberFormatter::create('fr', \NumberFormatter::SPELLOUT)->format($paiement->total))) }} dirhams</strong></p>
    </div>
    <div class="footer">
        <div class="black-section">
            Wepress SARL, Av. Moulay Ismail, Résidence Moulay Ismail 4ème Etg N 16 Tanger 90060, Morocco<br>
            RC: 1500479 , ICE: 003516488000073 , IF: 65971424
        </div>
        <p class="thank-you">Merci pour votre confiance!</p>
    </div>
</body>
</html>
