<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejected Announcements</title>
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

        /* Button Styling */
        .button-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        button, .reset-button {
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

        button:hover, .reset-button:hover {
            background: #0056b3;
        }

        .reset-button {
            background: #6c757d;
        }

        .reset-button:hover {
            background: #5a6268;
        }

        .filter-container {
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        .filter-container h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
            color: #444;
        }

        .filter-fields {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: space-between;
        }

        .filter-field {
            flex: 1 1 calc(50% - 15px);
        }

        .filter-field label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .filter-field input,
        .filter-field select {
            width: 100%;
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

        .filter-actions button {
            background-color: #007bff;
            border: none;
            cursor: pointer;
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
    <h1>Rejected Announcements</h1>

    <!-- Dashboard Button -->
    <div class="button-container">
        <button>
            <a href="{{ route('admin') }}" style="color: white; text-decoration: none;">Dashboard</a>
        </button>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div style="color: green; margin-bottom: 20px; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Form -->
    <div class="filter-container">
        <h2>Filter Rejected Announcements</h2>
        <form method="GET" action="{{ route('annoncerejected') }}">
            <div class="filter-fields">
                <div class="filter-field">
                    <label for="ref_web">Ref Web:</label>
                    <input type="text" name="ref_web" id="ref_web" value="{{ request()->input('ref_web') }}">
                </div>
                <div class="filter-field">
                    <label for="type">Type d'Annonce:</label>
                    <select name="type" id="type">
                        <option value="">-- Select Type --</option>
                        <option value="constitution" {{ request()->input('type') == 'constitution' ? 'selected' : '' }}>Constitution</option>
                        <option value="cessation" {{ request()->input('type') == 'cessation' ? 'selected' : '' }}>Cessation</option>
                        <option value="modification" {{ request()->input('type') == 'modification' ? 'selected' : '' }}>Modification</option>
                    </select>
                </div>
                <div class="filter-field">
                    <label for="date_creation">Date de Création:</label>
                    <input type="date" name="date_creation" id="date_creation" value="{{ request()->input('date_creation') }}">
                </div>
                <div class="filter-field">
                    <label for="date_parution">Date de Parution:</label>
                    <input type="date" name="date_parution" id="date_parution" value="{{ request()->input('date_parution') }}">
                </div>
            </div>
            <div class="filter-actions">
                <button type="submit">Filter</button>
                <a href="{{ route('annoncerejected') }}" class="reset-button">Reset</a>
            </div>
        </form>
    </div>

    <!-- Announcements Table -->
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Title</th>
                <th>Type</th>
                <th>Ref Web</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($annonces->isEmpty())
                <tr>
                    <td colspan="5" style="text-align: center;">No rejected announcements available.</td>
                </tr>
            @else
                @foreach ($annonces as $ann)
                    <tr>
                        <td>{{ $ann->user->name ?? 'Unknown' }}</td>
                        <td>{{ $ann->title }}</td>
                        <td>{{ $ann->type }}</td>
                        <td>{{ $ann->ref_web }}</td>
                        <td>
                            <a href="{{ route('annonce.view', $ann->id) }}" class="action-link">View</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>
