@extends('layout.app')

@section('title', 'Orders')

@section('content')
<div class="container">
    <h2>All Orders</h2>
    <div class="list-group">
        @foreach($orders as $order)
            @if(!$order['isDeleted'])
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ asset('images/' . $order['image']) }}" alt="{{ $order['orderedBy'] }}" class="img-fluid" style="height: 150px; object-fit: cover;">
                        </div>
                        <div class="col-md-9">
                            <h5 class="mb-1">{{ $order['orderedBy'] }}</h5>
                            <h6 class="mb-1">{{ $order['orderedCar'] }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1">Address: {{ $order['address'] }}</p>
                                    <p class="mb-1">Status: {{ $order['status'] }}</p>
                                    <p class="mb-1">OrderedAt: {{ $order['orderedAt'] }}</p>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('orders.show', $order['id']) }}" class="btn btn-primary mt-2">Order Now</a>
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
