@extends('layout.app')

@section('title', 'Sports Car Details')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">{{ $order->orderedBy }} {{ $order->orderedCar }}</h2>
        </div>
        <img src="{{ asset('images/' . $order->image) }}" class="card-img-top" alt="{{ $order->orderedBy }}" style="height: 400px; object-fit: cover;">
        <div class="card-body">
            <div class="card-text">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Address:</strong> {{ $order->address }}</p>
                        <p><strong>Status:</strong> {{ $order->status }}</p>
                        <p><strong>OrderedAt:</strong> {{ $order->orderedAt }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>OrderedCar:</strong> {{ $order->orderedCar }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center mt-3">
                <a href="{{ route('orders.showAll') }}" class="btn btn-secondary">Confirm Order</a>
                <a href="{{ route('orders.showAll') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection