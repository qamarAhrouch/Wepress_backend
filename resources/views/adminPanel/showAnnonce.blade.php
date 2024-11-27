@extends('layouts.app')

@section('content')

<!-- ----------------------------css-------------------- -->
<style>
    .back-button {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            text-decoration: none;
            color: white;
            background: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .back-button a:hover {
            background: #0056b3;
        }
</style>


<div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
    <h1 style="text-align: center; margin-bottom: 20px; font-size: 28px; font-weight: bold; color: #333;">{{ $annonce->title }}</h1>

    <div style="margin-bottom: 15px;">
        <strong>Content:</strong>
        <p style="padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 4px; line-height: 1.6; word-wrap: break-word; white-space: pre-line; overflow-wrap: break-word;">
            {{ $annonce->content }}
        </p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Type:</strong>
        <p style="margin: 5px 0; font-size: 16px;">{{ ucfirst($annonce->type) }}</p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Status:</strong>
        <p style="margin: 5px 0; font-size: 16px;">
            @if($annonce->status === 'pending')
                <span style="color: orange; font-weight: bold;">Pending</span>
            @elseif($annonce->status === 'approved')
                <span style="color: green; font-weight: bold;">Approved</span>
            @else
                <span style="color: red; font-weight: bold;">{{ ucfirst($annonce->status) }}</span>
            @endif
        </p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>ICE:</strong>
        <p style="margin: 5px 0; font-size: 16px;">{{ $annonce->ice }}</p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Ref Web:</strong>
        <p style="margin: 5px 0; font-size: 16px; font-style: italic;">{{ $annonce->ref_web }}</p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Date Parution:</strong>
        <p style="margin: 5px 0; font-size: 16px;">{{ $annonce->date_parution }}</p>
    </div>

    <!-- Approve, Reject, and Back Buttons -->
    <div style="text-align: center; margin-top: 20px;">
        <div style="display: inline-flex; gap: 15px; justify-content: center; align-items: center;">
            <form action="{{ route('annonces.approve', $annonce->id) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: bold;">
                    Approve
                </button>
            </form>

            <form action="{{ route('annonces.reject', $annonce->id) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="padding: 10px 20px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: bold;">
                    Reject
                </button>
            </form>

            <a href="{{ url()->previous() }}" style="padding: 10px 20px; background-color: #007bff; color: white; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: bold;">
                Back
            </a>
        </div>
    </div>



</div>
@endsection
