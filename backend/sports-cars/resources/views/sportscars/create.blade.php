@extends('layout.app')

@section('title', 'Add New Sports Car')

@section('content')
<div class="container">
    <h1>Add New Sports Car</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('sportsCars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Brand</label>
            <input type="text" class="form-control" id="name" name="brand" required>
        </div>
        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" class="form-control" id="model" name="model" required>
        </div>
        <div class="form-group">
            <label for="year">Year</label>
            <input type="text" class="form-control" id="year" name="year" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="form-group">
            <label for="speed">Speed</label>
            <input type="text" class="form-control" id="speed" name="speed" required>
        </div>
        <div class="form-group">
            <label for="drivetrain">Drivetrain</label>
            <input type="text" class="form-control" id="drivetrain" name="drivetrain" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control-file" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Sports Car</button>
        <a href="{{ route('sportsCars.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
