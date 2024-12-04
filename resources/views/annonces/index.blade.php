<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
@extends('layouts.app')

@section('content')

<!-- Create Annonce Button -->
<div style="text-align: center; margin-bottom: 16px;">
    <a href="{{ route('annonces.create') }}" style="padding: 10px 10px; background-color: gray; color: white; text-decoration: none; border-radius: 4px; font-size: 14px; display: inline-block;">
        Create Annonce
    </a>
</div>
<br><br>
<!-- Success Message -->
@if (session('success'))
    <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #d4edda; background-color: #d4edda; color: #155724; border-radius: 4px;">
        {{ session('success') }}
    </div>
@endif

<!-- Error Message -->
@if (session('error'))
    <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #f5c6cb; background-color: #f8d7da; color: #721c24; border-radius: 4px;">
        {{ session('error') }}
    </div>
@endif

<!-- Table for Authenticated User's Announcements -->
<h1 style="text-align: center; margin-bottom: 20px;">Mes Annonces</h1> <br> <br>
<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f8f9fa; text-align: left; border-bottom: 2px solid #dee2e6;">
            <th style="padding: 10px;">Title</th>
            <th style="padding: 10px;">Type</th>
            <th style="padding: 10px;">Status</th>
            <th style="padding: 10px;">Paiement</th>
            <th style="padding: 10px;">Date Creation</th>
            <th style="padding: 10px;">Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($annonces as $annonce)
    <tr style="border-bottom: 1px solid #dee2e6;">
        <td style="padding: 10px;">{{ $annonce->title }}</td>
        <td style="padding: 10px;">{{ $annonce->type }}</td>
        <td style="padding: 10px; color: {{ $annonce->status === 'approved' ? 'green' : ($annonce->status === 'rejected' ? 'red' : 'orange') }};">
            <b>
            {{ ucfirst($annonce->status) }}
            </b>
        </td>
        <td style="padding: 10px;">
            @if ($annonce->paiement)
                {{ ucfirst($annonce->paiement->status) }}
            @else
                Not Paid
            @endif
        </td>
        <td style="padding: 10px;">{{ $annonce->created_at->format('Y-m-d') }}</td>
        <td style="padding: 10px;">
            <a href="{{ route('annonces.show', $annonce) }}" style="margin-right: 10px; text-decoration: none; color: #007bff;">Voir</a>

            @if (!in_array($annonce->status, ['approved', 'rejected']))
                <a href="{{ route('annonces.edit', $annonce->id) }}" style="margin-right: 10px; text-decoration: none; color: #28a745;">Modifier</a>
                <form action="{{ route('annonces.destroy', $annonce) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event);">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer;">Supp</button>
                </form>
            @else
                <span style="color: gray; cursor: not-allowed;">Modifier</span>
                <span style="color: gray; cursor: not-allowed;">Supp</span>
            @endif

            @if ($annonce->paiement && $annonce->paiement->status === 'complet')
                <a href="{{ route('annonces.invoice', $annonce->id) }}" style="margin-left: 10px; text-decoration: none; color: #007bff;">
                    Telecharger reçu
                </a>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

<script>
    function confirmDelete(event) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this announcement?')) {
            event.target.closest('form').submit();
        }
    }
</script>
@endsection
</body>
</html>
