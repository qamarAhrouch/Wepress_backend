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
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">{{ $user->name }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('annonces.index') }}">My Announcements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">Profile</a>
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
                        <p class="card-text">Approved: <strong>{{ $rejectedCount }}</strong></p>
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
                        <a href="{{ route('profile.edit') }}" class="btn btn-light mt-3">Manage Profile</a>
                       
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
