@extends('layout.app')

@section('title', 'Edit Order')

@section('content')
<div class="container">
    <h1>Edit Order</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="orderedBy">OrderedBy</label>
            <input type="text" name="orderedBy" class="form-control" value="{{ $order->orderedBy }}" required>
        </div>
        <div class="form-group">
            <label for="orderedCar">OrderedCar</label>
            <input type="text" name="orderedCar" class="form-control" value="{{ $order->orderedCar }}" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" value="{{ $order->address }}" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
                <input type="file" name="image" class="form-control-file" value="{{ $order->image }}" >
            <p>Current Image: <img src="{{ asset('images/' . $order->image) }}" alt="{{ $order->orderedCar }} " style="width: 150px;"></p>
        </div>
        <button type="submit" class="btn btn-primary">Update Order</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
