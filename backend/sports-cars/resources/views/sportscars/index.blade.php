@extends('layout.app')

@section('title', 'Exotic Cars')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Exotic Cars</h1>
        <a href="{{ route('sportsCars.create') }}" class="btn btn-primary">Add New Sports Car</a>
    </div>
    
    @if(session('archive'))
        <div class="alert alert-success">
            {{ session('archive') }}
            <a href="{{ route('sportsCars.archive') }}" class="btn btn-secondary">View Archived Cars</a>
        </div>
    @endif

    <form method="GET" action="{{ route('sportsCars.index') }}" class="mb-3">
        <p>Total Brands: {{ $totalBrands }}</p>
        <div class="form-group">
            <label for="brand">Select Brand:</label>
            <select name="brand" id="brand" class="form-control" onchange="this.form.submit()">
                <option value="">All Brands</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand }}" {{ $brandFilter == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                @endforeach
            </select>
        </div>
        <p>Total Sports Cars: {{ $sportsCarCount }}</p>
    </form>

    <table border="1" width="100%" class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>SportsCarId</th>
                <th>Image</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Year</th>
                <th>Description</th>
                <th>Speed</th>
                <th>DriveTrain</th>
                <th>Price</th>
                <th>CreatedAt</th>
                <th>UpdatedAt</th>
                <th></th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sportsCars as $car)
                <tr>
                    <td>{{ $car['id'] }}</td>
                    <td>{{ $car['sportsCarId'] }}</td>
                    <td><img src="{{ asset('images/' . $car['image']) }}" class="card-img-top"
                            alt="{{ $car['brand'] }} Image" style="height: 200px; object-fit: cover;"></td>
                    <td>{{ $car['brand'] }}</td>
                    <td>{{ $car['model'] }}</td>
                    <td>{{ $car['year'] }}</td>
                    <td>{{ $car['description'] }}</td>
                    <td>{{ $car['speed'] }}</td>
                    <td>{{ $car['drivetrain'] }}</td>
                    <td>{{ $car['price'] }}</td>
                    <td>{{ $car['created_at'] }}</td>
                    <td>{{ $car['updated_at'] }}</td>
                    <td>
                        <form action="{{ route('sportsCars.edit', $car['id']) }}" method="GET" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning">Edit</button>
                        </form>
                        <form action="{{ route('sportsCars.destroy', $car['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Archive</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection