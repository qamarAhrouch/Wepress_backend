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
    <style>
        .pack-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .pack-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .pack-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-light">
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


    <!-- Main Content -->
    <div class="container py-5">
        <h2 class="text-center mb-4">Welcome, {{ $user->name }}!</h2>
        <div class="row g-4">
            <!-- Announcements Stats -->
            <div class="col-md-4">
                <div class="card text-white bg-info">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="fas fa-bullhorn"></i> Announcements</h5>
                        <p class="card-text">Total: <strong>{{ $announcementsCount }}</strong></p>
                        <p class="card-text">Pending: <strong>{{ $pendingCount }}</strong></p>
                        <p class="card-text">Approved: <strong>{{ $approvedCount }}</strong></p>
                        <p class="card-text">Rejected: <strong>{{ $rejectedCount }}</strong></p>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="fas fa-user"></i> Profile</h5>
                        <p class="card-text">Name: <strong>{{ $user->name }}</strong></p>
                        <p class="card-text">Email: <strong>{{ $user->email }}</strong></p>
                        <a href="{{ route('profile.view') }}" class="btn btn-light mt-3">Manage Profile</a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-md-4">
                <div class="card text-white bg-warning">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="fas fa-tools"></i> Quick Actions</h5>
                        <a href="{{ route('annonces.create') }}" class="btn btn-light mt-3">Create Announcement</a>
                        <a href="{{ route('annonces.index') }}" class="btn btn-dark mt-3">My Announcements</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Packs Section -->
    <div class="container py-4">
        <h3 class="text-center mb-3">Your Packs</h3>
        <div class="row g-4 justify-content-center">
            @foreach ($userPacks as $pack)
                <div class="col-md-4">
                    <div class="card shadow border-info">
                        <div class="card-body text-center">
                            <h5 class="card-title text-info">{{ $pack->pack_type }}</h5>
                            <p>Total Annonces: <strong>{{ $pack->total_annonces }}</strong></p>
                            <p>Remaining: <strong>{{ $pack->remaining_annonces }}</strong></p>
                            <p>Price per Annonce: <strong>{{ $pack->price_per_annonce }} DH</strong></p>
                            <p>Total Price: <strong>{{ $pack->total_price }} DH</strong></p>
                            <button class="btn btn-success" onclick="window.location='{{ route('annonces.create', ['pack' => $pack->pack_type]) }}'">Use Pack</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h3 class="text-center mt-5">Available Packs</h3>
        <div class="row g-4 justify-content-center">
            @foreach ($availablePacks as $pack)
                <div class="col-md-4">
                    <div class="card shadow border-primary">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">{{ $pack->name }}</h5>
                            <p>{{ $pack->number_of_annonces }} annonces at {{ $pack->unit_price }} DH each</p>
                            <p><strong>Total: {{ $pack->total_price }} DH</strong></p>
                            <form action="{{ route('packs.purchase') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pack_type" value="{{ $pack->name }}">
                                <button type="submit" class="btn btn-primary">Command</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
