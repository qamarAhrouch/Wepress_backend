@extends('layouts.app')

@section('content')
<h1 style="text-align: center; margin-bottom: 20px;">Edit Annonce</h1>

<form action="{{ route('annonces.update', $annonce) }}" method="POST" enctype="multipart/form-data" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
    @csrf
    @method('PATCH')

    <div style="margin-bottom: 15px;">
        <label for="title" style="display: block; font-weight: bold; margin-bottom: 5px;">Title:</label>
        <input type="text" name="title" id="title" value="{{ $annonce->title }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="content" style="display: block; font-weight: bold; margin-bottom: 5px;">Content:</label>
        <textarea name="content" id="content" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; height: 100px;">{{ $annonce->content }}</textarea>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="type" style="display: block; font-weight: bold; margin-bottom: 5px;">Type:</label>
        <select name="type" id="type" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="constitution" @if($annonce->type == 'constitution') selected @endif>Constitution</option>
            <option value="cessation" @if($annonce->type == 'cessation') selected @endif>Cessation</option>
            <option value="modification" @if($annonce->type == 'modification') selected @endif>Modification</option>
        </select>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="ice" style="display: block; font-weight: bold; margin-bottom: 5px;">ICE:</label>
        <input type="text" name="ice" id="ice" value="{{ $annonce->ice }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="date_parution" style="display: block; font-weight: bold; margin-bottom: 5px;">Date Parution:</label>
        <input type="date" name="date_parution" id="date_parution" value="{{ $annonce->date_parution }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <!-- Canal de Publication Field -->
    <div style="margin-bottom: 15px;">
        <label for="canal_de_publication" style="display: block; font-weight: bold; margin-bottom: 5px;">Canal de Publication:</label>
        <select name="canal_de_publication" id="canal_de_publication" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="Papier + Digital" @if($annonce->canal_de_publication == 'Papier + Digital') selected @endif>Papier + Digital</option>
            <option value="Digital uniquement" @if($annonce->canal_de_publication == 'Digital uniquement') selected @endif>Digital uniquement</option>
        </select>
    </div>

    <!-- Ville Field -->
    <div style="margin-bottom: 15px;">
        <label for="ville" style="display: block; font-weight: bold; margin-bottom: 5px;">Ville:</label>
        <select name="ville" id="ville" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="" disabled>Select Ville</option>
            <option value="Casablanca" @if($annonce->ville == 'Casablanca') selected @endif>Casablanca</option>
            <option value="Rabat" @if($annonce->ville == 'Rabat') selected @endif>Rabat</option>
            <option value="Marrakech" @if($annonce->ville == 'Marrakech') selected @endif>Marrakech</option>
            <option value="Fes" @if($annonce->ville == 'Fes') selected @endif>Fes</option>
            <option value="Tangier" @if($annonce->ville == 'Tangier') selected @endif>Tangier</option>
            <!-- Add more cities as needed -->
        </select>
    </div>

    <!-- Publication Web Field -->
    <div style="margin-bottom: 15px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Publier votre annonce sur le web?</label>
        <label><input type="radio" name="publication_web" value="1" @if($annonce->publication_web == 1) checked @endif> Oui</label>
        <label><input type="radio" name="publication_web" value="0" @if($annonce->publication_web == 0) checked @endif> Non</label>
    </div>

    <!-- Joindre Fichiers (Optional): -->
    <div style="margin-bottom: 15px;">
        <label for="file_attachment" style="display: block; font-weight: bold; margin-bottom: 5px;">Joindre Fichiers (Optional):</label>
        <!-- Display link to the current file if it exists -->
        @if($annonce->file_attachment)
            <p>Current File: <a href="{{ Storage::url($annonce->file_attachment) }}" target="_blank">View Attachment</a></p>
        @endif
        <input type="file" name="file_attachment" id="file_attachment" accept=".pdf,.jpeg,.png,.docx,.doc" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <div style="text-align: center;">
        <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">Update Annonce</button>
    </div>
</form>
@endsection
