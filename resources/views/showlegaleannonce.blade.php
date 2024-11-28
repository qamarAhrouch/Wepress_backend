@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
    <h1 style="text-align: center; margin-bottom: 20px; font-size: 28px; font-weight: bold; color: #333;">{{ $annonce->title }}</h1>
    <div style="margin-bottom: 15px;">
        <p style="margin: 5px 0; font-size: 16px;">{{ ucfirst($annonce->type) }}</p>
    </div>
    
    <div style="margin-bottom: 15px;">
        <p style="margin: 5px 0; font-size: 16px;">{{ $annonce->date_parution }}</p>
    </div>
    <div style="margin-bottom: 15px;">
        <p style="padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 4px; line-height: 1.6; word-wrap: break-word; white-space: pre-line; overflow-wrap: break-word;">
            {{ $annonce->content }}
        </p>
    </div>

    <a href="{{ url()->previous() }}" style="padding: 10px 20px; background-color: #007bff; color: white; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: bold;">
        Back
    </a>
</div>
@endsection


