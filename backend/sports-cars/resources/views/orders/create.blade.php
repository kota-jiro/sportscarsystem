@extends('layout.app')

@section('title', 'Add New Order')

@section('content')
<div class="container">
    <h1>Add New Order</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="orderedBy">OrderedBy</label>
            <input type="text" class="form-control" id="orderedBy" name="orderedBy" required>
        </div>
        <div class="form-group">
            <label for="orderedCar">OrderedCar</label>
            <input type="text" class="form-control" id="orderedCar" name="orderedCar" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Order</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
