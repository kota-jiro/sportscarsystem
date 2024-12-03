@extends('layout.app')

@section('title', 'Sports Car Details')

@section('content')
<div class="container">
    <h2>{{ $sportsCars->brand }} {{ $sportsCars->model }}</h2>
    <div class="card mb-4">
        <img src="{{ asset('images/cars/' . $sportsCars->image) }}" class="card-img-top" alt="{{ $sportsCars->brand }} {{ $sportsCars->model }}">
        <div class="card-body">
            <p class="card-text">Year: {{ $sportsCars->year }}</p>
            <p class="card-text">Description: {{ $sportsCars->description }}</p>
            <p class="card-text">Speed: {{ $sportsCars->speed }}</p>
            <p class="card-text">Drivetrain: {{ $sportsCars->drivetrain }}</p>
            <p class="card-text">Price: ${{ number_format($sportsCars->price, 2) }}</p>
            <a href="{{ route('sportsCars.showAll') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection 