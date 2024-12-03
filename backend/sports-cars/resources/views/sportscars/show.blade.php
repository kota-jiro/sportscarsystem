@extends('layout.app')

@section('title', 'Sports Cars')

@section('content')
<div class="container">
    <h2>All Exotic Cars</h2>
    <div class="row">
        @foreach($sportsCars as $car)
            @if(!$car['isDeleted'])
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('images/cars/' . $car['image']) }}" class="card-img-top" alt="{{ $car['brand'] }} {{ $car['model'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $car['brand'] }} {{ $car['model'] }}</h5>
                            <p class="card-text">Year: {{ $car['year'] }}</p>
                            <p class="card-text">Description: {{ $car['description'] }}</p>
                            <p class="card-text">Speed: {{ $car['speed'] }}</p>
                            <p class="card-text">Drivetrain: {{ $car['drivetrain'] }}</p>
                            <p class="card-text">Price: ${{ number_format($car['price'], 2) }}</p>
                            <a href="{{ route('sportsCars.show', $car['id']) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
