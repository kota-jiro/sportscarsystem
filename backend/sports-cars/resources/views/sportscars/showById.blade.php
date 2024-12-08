@extends('layout.app')

@section('title', 'Sports Car Details')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">{{ $sportsCars->brand }} {{ $sportsCars->model }}</h2>
        </div>
        <img src="{{ asset('images/' . $sportsCars->image) }}" class="card-img-top" alt="{{ $sportsCars->brand }} {{ $sportsCars->model }}" style="height: 400px; object-fit: cover;">
        <div class="card-body">
            <div class="card-text">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Year:</strong> {{ $sportsCars->year }}</p>
                        <p><strong>Description:</strong> {{ $sportsCars->description }}</p>
                        <p><strong>Speed:</strong> {{ $sportsCars->speed }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Drivetrain:</strong> {{ $sportsCars->drivetrain }}</p>
                        <p><strong>Price:</strong> ${{ number_format($sportsCars->price, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center mt-3">
                <a href="{{ route('sportsCars.showAll') }}" class="btn btn-secondary">Confirm Order</a>
                <a href="{{ route('sportsCars.showAll') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection