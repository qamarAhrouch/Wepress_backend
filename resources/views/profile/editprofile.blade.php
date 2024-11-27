@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Profile Management</h1>

    @if(session('status') === 'profile-updated')
        <div class="alert alert-success">
            Profile updated successfully!
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep current password">
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <!-- Account Deletion -->
    <form action="{{ route('profile.destroy') }}" method="POST" class="mt-4">
        @csrf
        @method('DELETE')
        <div>
            <label for="password-delete" class="form-label">Confirm your password to delete account</label>
            <input type="password" name="password" id="password-delete" class="form-control" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-danger mt-2">Delete Account</button>
    </form>
</div>
@endsection
