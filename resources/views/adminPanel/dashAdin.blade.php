<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Admin Dashboard</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            font-size: 28px;
            color: #444;
        }

        /* Button Styles */
        .button-container {
            display: inline-flex;
            gap: 15px;
            justify-content: center;
            margin: 20px 0;
        }

        .button {
            text-decoration: none;
            color: white;
            background: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            border: none;
            cursor: pointer;
        }

        .button:hover {
            background: #0056b3;
        }

        .success {
            background: #28a745;
        }

        .success:hover {
            background: #218838;
        }

        .danger {
            background: #dc3545;
        }

        .danger:hover {
            background: #c82333;
        }

        .logout {
            background: #6c757d;
        }

        .logout:hover {
            background: #5a6268;
        }

        /* Table Styling */
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        td {
            color: #555;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-link {
            color: #007bff;
            text-decoration: underline;
            cursor: pointer;
        }

        .action-link:hover {
            color: #0056b3;
        }
    </style>
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

<h1>Welcome to Admin Dashboard, {{ $admin->name }}</h1>

<!-- Logout and Announcement Links -->
<div class="button-container">
    <a href="{{ route('annonceapproved') }}" class="button success">View Approved Announcements</a>
    <a href="{{ route('annoncerejected') }}" class="button danger">View Rejected Announcements</a>
    <a href="{{ route('admin.users') }}" class="button success">Manage Users</a>
    <a href="{{ route('profile.view') }}" class="button success">Manage Profile</a>
</div>

<h2 class="text-center mt-4">Users and Impersonation</h2>
<table class="table table-bordered mt-4">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ ucfirst($user->role) }}</td>
            <td>
                <!-- Impersonate Button -->
                <a href="{{ route('admin.impersonate', $user->id) }}" class="btn btn-primary">Impersonate</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<h2 class="text-center mt-4">Pending Announcements</h2>
<table class="table table-bordered mt-4">
    <thead>
    <tr>
        <th>Title</th>
        <th>User Name</th>
        <th>Type</th>
        <th>Status</th>
        <th>Date Creation</th>
        <th>Paiment Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($annonces as $annonce)
        <tr>
            <td>{{ $annonce->title }}</td>
            <td>{{ $annonce->user->name ?? 'Unknown' }}</td>
            <td>{{ $annonce->type }}</td>
            <td style="color: orange;"><b> {{ ucfirst($annonce->status) }} </b></td>
            <td>{{ $annonce->created_at->format('Y-m-d') }}</td>
            <td style="color: green;"> <b>
                @if ($annonce->paiement)
                    {{ ucfirst($annonce->paiement->status) }}
                @else
                    Imcomplet
                @endif
                </b>
            </td>
            <td>
                <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="action-link">View</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
