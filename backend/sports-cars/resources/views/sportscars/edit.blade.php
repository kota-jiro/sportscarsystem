@extends('layout.app')

@section('title', 'Edit Sports Car')

@section('content')
<div class="container">
    <h1>Edit Sports Car</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('sportsCars.update', $sportsCar->sportsCarId) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" name="brand" class="form-control" value="{{ $sportsCar->brand }}" required>
        </div>
        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" name="model" class="form-control" value="{{ $sportsCar->model }}" required>
        </div>
        <div class="form-group">
            <label for="year">Year</label>
            <input type="text" name="year" class="form-control" value="{{ $sportsCar->year }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control" value="{{ $sportsCar->description }}" required>
        </div>
        <div class="form-group">
            <label for="speed">Speed</label>
            <input type="text" name="speed" class="form-control" value="{{ $sportsCar->speed }}" required>
        </div>
        <div class="form-group">
            <label for="drivetrain">Drivetrain</label>
            <input type="text" name="drivetrain" class="form-control" value="{{ $sportsCar->drivetrain }}" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" value="{{ $sportsCar->price }}" required>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" class="form-control-file">
            <p>Current Image: <img src="{{ asset('images/cars/' . $sportsCar->image) }}" alt="{{ $sportsCar->brand }} {{ $sportsCar->model }} " style="width: 150px;"></p>
        </div>
        <button type="submit" class="btn btn-primary">Update Sports Car</button>
        <a href="{{ route('sportsCars.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
