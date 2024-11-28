<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Annonces</title>
</head>
<body>
<h1 style="text-align: center; margin-bottom: 20px;">Mes Annonces</h1>

<!-- Success message -->
@if (session('success'))
    <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #d4edda; background-color: #d4edda; color: #155724; border-radius: 4px;">
        {{ session('success') }}
    </div>
@endif

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background-color: #f8f9fa; text-align: left; border-bottom: 2px solid #dee2e6;">
            <th style="padding: 10px;">Title</th>
            <th style="padding: 10px;">Type</th>
            <th style="padding: 10px;">Status</th>
            <th style="padding: 10px;">Date Parution</th>
            <th style="padding: 10px;">Date Creation</th>
            <th style="padding: 10px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($annonces as $annonce)
        <tr style="border-bottom: 1px solid #dee2e6;">
            <td style="padding: 10px;">{{ $annonce->title }}</td>
            <td style="padding: 10px;">{{ $annonce->type }}</td>
            <td style="padding: 10px;">{{ $annonce->status }}</td>
            <td style="padding: 10px;">{{ $annonce->date_parution }}</td>
            <td style="padding: 10px;">{{ $annonce->created_at->format('Y-m-d') }}</td>
            <td style="padding: 10px;">
                <!-- Approve form -->
                <form action="{{ route('annonces.approve', $annonce->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="margin-right: 10px; border: none; background: none; color: #007bff; cursor: pointer; text-decoration: underline;">
                        Approve
                    </button>
                </form>

                <!-- Reject form -->
                <form action="{{ route('annonces.reject', $annonce->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="border: none; background: none; color: #dc3545; cursor: pointer; text-decoration: underline;">
                        Reject
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h1>Welcome to Dash Admin {{$user->name}}</h1>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <x-dropdown-link :href="route('logout')"
            onclick="event.preventDefault();
                        this.closest('form').submit();">
        {{ __('Log Out') }}
    </x-dropdown-link>
</form>
</body>
</html>
