<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <!-- Bootstrap CSS -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding: 1px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background: white;
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            font-size: 14px;
            padding: 5px 10px;
        }

        .search-bar {
            margin-bottom: 15px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
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

<br><br>
<div class="header-actions">

        <h1>Manage Users</h1>
     
   
        <!-- Add User Button -->
        <a href="{{ route('admin.createUser') }}" class="btn btn-success">Add User</a>
    </div>
    <form method="GET" action="{{ route('admin.users') }}" class="search-bar d-flex gap-2">
    <!-- Search Input -->
        <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
        
        <!-- Search Button -->
        <button type="submit" class="btn btn-primary">Search</button>

        <!-- Reset Button -->
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Reset</a>
    </form>



    <!-- Success message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error message -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th> <!-- New column for user status -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($users->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">No users found.</td>
                </tr>
            @else
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <!-- Display Active/Not Active based on email_verified_at -->
                            @if ($user->email_verified_at)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Not Active</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Edit</a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <!-- Pagination Links -->
    
</body>
</html>
