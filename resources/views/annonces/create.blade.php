<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Annonce</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
    <a class="navbar-brand" 
        href="{{ match(auth()->user()->role) {
            'admin' => route('admin'),
            'sous-admin' => route('sousAdmin'),
            'client' => route('dashboard'),
            default => route('login')
        } }}">
            {{ auth()->user()->name }}
    </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active"
                       href="{{ match(auth()->user()->role) {
                           'admin' => route('admin'),
                           'sous-admin' => route('sousAdmin'),
                           'client' => route('dashboard'),
                           default => route('login')
                       } }}">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('annonces.index') }}">My Announcements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.view') }}">Profile</a>
                </li>
                <!-- Logout Button -->
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white" style="text-decoration: none;">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-4">
        <h1 style="text-align: center; margin-bottom: 20px;">Create Annonce</h1>

        @php
            // Pack logic
            $pack = request('pack');
            $pricePerAnnonce = 150; // Default price
            if ($pack === 'Silver') {
                $pricePerAnnonce = 130;
            } elseif ($pack === 'Gold') {
                $pricePerAnnonce = 120;
            } elseif ($pack === 'Platinum') {
                $pricePerAnnonce = 100;
            }
        @endphp

        <!-- Pack information section -->
        <div style="margin-bottom: 15px; background: #e9f7ef; padding: 10px; border-radius: 4px;">
            @if($pack)
                <p><strong>Selected Pack:</strong> {{ $pack }}</p>
                <p><strong>Price per Annonce:</strong> {{ $pricePerAnnonce }} DH</p>
            @else
                <p><strong>No Pack Selected:</strong> Default price is 150 DH</p>
            @endif
        </div>

        <div style="display: flex; justify-content: center; gap: 20px;">
            <!-- Form Section -->
            <div style="width: 40%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
                <form action="{{ route('annonces.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Hidden input to pass the selected pack -->
                    <input type="hidden" name="pack" value="{{ $pack }}">

                    <div style="margin-bottom: 10px;">
                        <label for="canal_de_publication" style="display: block; font-weight: bold; margin-bottom: 5px;">Canal de Publication:</label>
                        <select name="canal_de_publication" id="canal_de_publication" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="Papier + Digital">Papier + Digital</option>
                            <option value="Digital uniquement">Digital uniquement</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="title" style="display: block; font-weight: bold; margin-bottom: 5px;">Nom de société:</label>
                        <input type="text" name="title" id="title" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;" oninput="updatePreview()">
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="type" style="display: block; font-weight: bold; margin-bottom: 5px;">Type:</label>
                        <select name="type" id="type" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="" disabled selected>Select Type</option>
                            <option value="constitution">Constitution</option>
                            <option value="cessation">Cessation</option>
                            <option value="modification">Modification</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="content" style="display: block; font-weight: bold; margin-bottom: 5px;">Content:</label>
                        <textarea name="content" id="content" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; height: 80px;" oninput="updatePreview()"></textarea>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="file_attachment" style="display: block; font-weight: bold; margin-bottom: 5px;">Joindre Fichiers (Optional):</label>
                        <input type="file" name="file_attachment" id="file_attachment" accept=".pdf,.jpeg,.png,.docx,.doc" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="ice" style="display: block; font-weight: bold; margin-bottom: 5px;">ICE:</label>
                        <input 
                            type="text" 
                            name="ice" 
                            id="ice" 
                            required 
                            minlength="15" 
                            maxlength="15" 
                            pattern="\d{15}" 
                            style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;" 
                            oninput="validateICE()"
                        >
                        <small id="iceError" style="color: red; display: none;">ICE must be exactly 15 digits.</small>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="ville" style="display: block; font-weight: bold; margin-bottom: 5px;">Ville:</label>
                        <select name="ville" id="ville" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;" onchange="handleVilleChange()">
                            <option value="" disabled selected>Choose a city</option>
                            <option value="Casablanca">Casablanca</option>
                            <option value="Rabat">Rabat</option>
                            <option value="Marrakech">Marrakech</option>
                            <option value="Fes">Fes</option>
                            <option value="Tangier">Tangier</option>
                            <option value="Agadir">Agadir</option>
                            <option value="Oujda">Oujda</option>
                            <option value="Kenitra">Kenitra</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>

                    <div id="autreVilleContainer" style="display: none; margin-bottom: 10px;">
                        <label for="autre_ville" style="display: block; font-weight: bold; margin-bottom: 5px;">Enter your city:</label>
                        <input type="text" name="autre_ville" id="autre_ville" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Publier votre annonce sur le web?</label>
                        <label><input type="radio" name="publication_web" value="1" required> Oui</label>
                        <label><input type="radio" name="publication_web" value="0"> Non</label>
                    </div>

                    <div style="text-align: center;">
                        <button type="submit" style="padding: 8px 16px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Create Annonce</button>
                    </div>
                </form>
            </div>

            <!-- Preview Section -->
            <div style="width: 35%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background-color: #f5f5f5;">
                <h2>Aperçu de l'annonce</h2>
                <div id="previewContent" style="border: 1px solid #000; padding: 8px; text-align: center; overflow-wrap: break-word; word-wrap: break-word; white-space: normal; max-width: 100%; height: auto;">
                    <p id="previewTitle" style="font-weight: bold; word-break: break-word;"></p>
                    <p id="previewBody" style="word-break: break-word; white-space: pre-line;"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function validateICE() {
            const iceInput = document.getElementById('ice');
            const iceError = document.getElementById('iceError');
            if (iceInput.value.length === 15 && /^\d{15}$/.test(iceInput.value)) {
                iceError.style.display = 'none';
                iceInput.setCustomValidity('');
            } else {
                iceError.style.display = 'block';
                iceInput.setCustomValidity('ICE must be exactly 15 digits.');
            }
        }

        function handleVilleChange() {
            const villeSelect = document.getElementById('ville');
            const autreVilleContainer = document.getElementById('autreVilleContainer');
            if (villeSelect.value === 'Autre') {
                autreVilleContainer.style.display = 'block';
            } else {
                autreVilleContainer.style.display = 'none';
            }
        }

        function updatePreview() {
            const title = document.getElementById('title').value.trim();
            const content = document.getElementById('content').value.trim();
            document.getElementById('previewTitle').textContent = title || 'No Title';
            document.getElementById('previewBody').textContent = content || 'No Content';
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('title').addEventListener('input', updatePreview);
            document.getElementById('content').addEventListener('input', updatePreview);
        });
    </script>
</body>
</html>
