<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Announcements</title>
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

        /* Filter Form Styling */
        .filter-form {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .filter-form h2 {
            margin-bottom: 20px;
            font-size: 20px;
            color: #444;
            text-align: center;
        }

        .filter-fields {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: space-between;
        }

        .filter-field {
            flex: 1 1 calc(50% - 15px);
            display: flex;
            flex-direction: column;
        }

        .filter-field label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .filter-field input,
        .filter-field select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
        }

        .filter-actions {
            text-align: center;
            margin-top: 20px;
        }

        .filter-actions button,
        .filter-actions a {
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            color: white;
        }

        .filter-actions button {
            background-color: #007bff;
            border: none;
            cursor: pointer;
        }

        .filter-actions button:hover {
            background-color: #0056b3;
        }

        .filter-actions a {
            background-color: #6c757d;
        }

        .filter-actions a:hover {
            background-color: #5a6268;
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

        th,
        td {
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

<h1>Welcome to Dash Admin, {{ $admin->name }}</h1>

<!-- Logout and Announcement Links -->
<div class="button-container">
    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
        @csrf
        <button type="submit" class="button logout">Log Out</button>
    </form>
    <a href="{{ route('annonceapproved') }}" class="button success">View Approved Announcements</a>
    <a href="{{ route('annoncerejected') }}" class="button danger">View Rejected Announcements</a>
    <a href="{{ route('admin.users') }}" class="button success">Manage Users</a>
    <a href="{{ route('profile.edit') }}" class="button success">Manage Profile</a></div>



<!-- Filter Form -->
<div class="filter-form">
    <h2>Filter Pending Announcements</h2>
    <form method="GET" action="{{ route('admin') }}">
        <div class="filter-fields">
            <div class="filter-field">
                <label for="ref_web">Ref Web:</label>
                <input type="text" name="ref_web" id="ref_web" value="{{ $filters['ref_web'] ?? '' }}">
            </div>
            <div class="filter-field">
                <label for="type">Type d'Annonce:</label>
                <select name="type" id="type">
                    <option value="">-- Select Type --</option>
                    <option value="constitution" {{ $filters['type'] == 'constitution' ? 'selected' : '' }}>Constitution</option>
                    <option value="cessation" {{ $filters['type'] == 'cessation' ? 'selected' : '' }}>Cessation</option>
                    <option value="modification" {{ $filters['type'] == 'modification' ? 'selected' : '' }}>Modification</option>
                </select>
            </div>
            <div class="filter-field">
                <label for="date_creation">Date de Création:</label>
                <input type="date" name="date_creation" id="date_creation" value="{{ $filters['date_creation'] ?? '' }}">
            </div>
            <div class="filter-field">
                <label for="date_parution">Date de Parution:</label>
                <input type="date" name="date_parution" id="date_parution" value="{{ $filters['date_parution'] ?? '' }}">
            </div>
        </div>
        <div class="filter-actions">
            <button type="submit">Filter</button>
            <a href="{{ route('admin') }}">Reset</a>
        </div>
    </form>
</div>
<!-- Table for Announcements -->

<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>User Name</th>
            <th>Type</th>
            <th>Status</th>
            <th>Date Creation</th>
            <th>Date Parution</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($annonces as $annonce)
        <tr>
            <td>{{ $annonce->title }}</td>
            <td>{{ $annonce->user->name ?? 'Unknown' }}</td>
            <td>{{ $annonce->type }}</td>
            <td>{{ ucfirst($annonce->status) }}</td>
            <td>{{ $annonce->created_at->format('Y-m-d') }}</td>
            <td>
                @if ($annonce->date_parution)
                    {{ \Carbon\Carbon::parse($annonce->date_parution)->format('Y-m-d') }}
                @else
                    N/A
                @endif
            </td>
            <td>
                <a href="{{ route('admin.annonces.show', $annonce->id) }}" class="action-link">View</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- JavaScript -->


<script>
    function confirmDelete(event, form) {
        event.preventDefault(); // Prevent the form from submitting immediately
        const confirmed = confirm("Are you sure you want to delete this user?");
        if (confirmed) {
            form.submit(); // Submit the form if the user confirms
        }
    }
</script>
</body>
</html>
