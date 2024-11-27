<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
            color: #333;
        }

        .form-container {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            font-size: 24px;
            text-align: center;
            color: #444;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-actions {
            text-align: center;
            margin-top: 20px;
        }

        .form-actions button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-actions button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Edit User</h1>
        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="client" {{ $user->role == 'client' ? 'selected' : '' }}>Client</option>
                    <option value="sous-admin" {{ $user->role == 'sous-admin' ? 'selected' : '' }}>Sous-Admin</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
