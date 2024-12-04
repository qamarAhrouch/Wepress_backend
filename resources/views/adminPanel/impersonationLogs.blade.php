@extends('layouts.app')

@section('title', 'Impersonation Logs')

@section('content')
    <h1 class="text-center mb-4">Impersonation Logs</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Admin</th>
                <th>User</th>
                <th>Started At</th>
                <th>Ended At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->admin->name }} ({{ $log->admin->email }})</td>
                    <td>{{ $log->user->name }} ({{ $log->user->email }})</td>
                    <td>{{ $log->started_at }}</td>
                    <td>{{ $log->ended_at ?? 'Still Active' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
