@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-header h1 {
            font-size: 24px;
            color: #333;
        }
        .profile-header p {
            font-size: 16px;
            color: #777;
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .profile-info h5 {
            font-size: 18px;
            color: #444;
            margin-bottom: 8px;
        }
        .profile-info p {
            font-size: 16px;
            color: #666;
            margin-bottom: 8px;
        }
        .profile-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            color: #fff;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .edit-btn {
            display: block;
            margin: 20px auto 0;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .edit-btn:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <h1>{{ $user->name }}</h1>
            <p>Profile Overview</p>
        </div>

        <!-- Profile Information -->
        <div class="profile-info">
            <h5>Email:</h5>
            <p>{{ $user->email }}</p>
            <h5>Status:</h5>
            <p>
                @if ($user->email_verified_at)
                    <span class="profile-badge badge-success">Verified</span>
                @else
                    <span class="profile-badge badge-danger">Not Verified</span>
                @endif
            </p>
        </div>

        <!-- Edit Profile Button -->
        <a href="{{ route('profile.edit') }}" class="edit-btn">Edit Profile</a>
    </div>
</div>
@endsection
