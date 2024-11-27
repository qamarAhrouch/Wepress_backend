@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <style>
        .container {
            max-width: 600px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1, h5 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            color: #555;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-danger:hover {
            background-color: #a71d2a;
        }
        .alert-success, .alert-danger {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .text-danger {
            color: #dc3545;
            font-size: 14px;
        }
        hr {
            margin: 30px 0;
            border: none;
            border-top: 1px solid #ddd;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0 text-center">Profile Management</h3>
                </div>
                <div class="card-body">
                    <!-- Success Message -->
                    @if(session('status') === 'profile-updated')
                        <div class="alert alert-success">
                            Profile updated successfully!
                        </div>
                    @endif

                    @if(session('status') === 'account-deleted')
                        <div class="alert alert-danger">
                            Your account has been deleted successfully!
                        </div>
                    @endif

                    <!-- Update Profile Form -->
                    <form action="{{ route('profile.update') }}" method="POST" class="mb-4">
                        @csrf
                        @method('PATCH')

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" 
                                   placeholder="Enter your current password" required>
                            @error('current_password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password" class="form-control" 
                                   placeholder="Enter your new password">
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                                   placeholder="Confirm your new password">
                            @error('password_confirmation')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>

                    <hr>

                    <!-- Delete Account Form -->
                    <h5 class="text-danger">Delete Account</h5>
                    <form action="{{ route('profile.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="mb-3">
                            <label for="password-delete" class="form-label">Confirm Password</label>
                            <input type="password" name="password" id="password-delete" class="form-control" 
                                   placeholder="Enter your password" required>
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
