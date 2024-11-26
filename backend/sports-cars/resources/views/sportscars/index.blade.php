@extends('layout.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Sports Cars</h2>
        <a href="{{ route('sportscars.create') }}" class="btn btn-primary">Add New Sports Car</a>
    </div>

    <div class="row">
        @foreach ($sportscars as $car)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('images/cars/' . $car->image) }}" class="card-img-top" alt="{{ $car->make }} Image" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->make }} {{ $car->model }}</h5>
                        <p class="card-text">
                            <strong>Year:</strong> {{ $car->year }}<br>
                            <strong>Price:</strong> ₱{{ number_format($car->price, 2) }}
                        </p>
                        <a href="{{ route('sportscars.show', $car->id) }}" class="btn btn-info">View Details</a>
                        <a href="{{ route('sportscars.edit', $car->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('sportscars.destroy', $car->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection


