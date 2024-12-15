@extends('layout.app')

@section('title', 'Sports Cars')

@section('content')
<div class="container">
    <h2>All Exotic Cars</h2>
    <div class="list-group">
        @foreach($sportsCars as $car)
            @if(!$car['isDeleted'])
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ asset('images/' . $car['image']) }}" alt="{{ $car['brand'] }} {{ $car['model'] }}" class="img-fluid" style="height: 150px; object-fit: cover;">
                        </div>
                        <div class="col-md-9">
                            <h5 class="mb-1">{{ $car['brand'] }} {{ $car['model'] }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1">Year: {{ $car['year'] }}</p>
                                    <p class="mb-1">Description: {{ $car['description'] }}</p>
                                    <p class="mb-1">Speed: {{ $car['speed'] }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1">Drivetrain: {{ $car['drivetrain'] }}</p>
                                    <p class="mb-1">Price: ₱{{ number_format($car['price'], 2) }}</p>
                                    <a href="{{ route('sportsCars.show', $car['id']) }}" class="btn btn-primary mt-2">View Details</a>
                                    <a href="{{ route('orders.create') }}" class="btn btn-primary mt-2">Order Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
