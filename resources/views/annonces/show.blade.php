@extends('layouts.app')

@section('content')
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
            @elseif($annonce->status === 'published')
                <span style="color: green; font-weight: bold;">Published</span>
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
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ session('previous') }}" style="color: #007bff; text-decoration: underline;">Back</a>
    </div>
</div>
@endsection


