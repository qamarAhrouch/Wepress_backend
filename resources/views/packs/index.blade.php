@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Available Packs</h2>
    <div class="row g-4 justify-content-center">
        @foreach ($packs as $pack)
            <div class="col-md-4">
                <div class="card shadow border-info">
                    <div class="card-body text-center">
                        <h5 class="card-title text-info">{{ $pack->name }}</h5>
                        <p class="card-text">{{ $pack->number_of_annonces }} annonces at {{ $pack->unit_price }} DH each</p>
                        <p class="card-text"><strong>Total: {{ $pack->total_price }} DH</strong></p>
                        <a href="{{ route('annonces.create', ['pack' => $pack->name]) }}" class="btn btn-info">Select Pack</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
