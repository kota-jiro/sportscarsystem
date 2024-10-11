@extends('layout.app')

@section('content')
    <h2>{{ $car->make }} {{ $car->model }}</h2>
    <div class="card mb-4">
        <img src="{{ asset('images/cars/' . $car->image) }}" class="card-img-top" alt="{{ $car->make }} {{ $car->model }}">
        <div class="card-body">
            <p>Year: {{ $car->year }}</p>
            <p>Price: ${{ number_format($car->price, 2) }}</p>
            <p>Quantity: {{ $car->quantity }}</p>
            <a href="{{ route('sportscars.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection