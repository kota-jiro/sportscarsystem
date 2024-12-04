@extends('layout.app')

@section('title', 'Archived Sports Cars')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-gray-800 text-center mb-4">Archived Sports Cars</h1>

    @if(session('restore'))
        <div class="alert alert-success">
            {{ session('restore') }}
            <a href="{{ route('sportsCars.index') }}" class="btn btn-secondary">View Cars</a>
        </div>
    @endif

    <form method="GET" action="{{ route('sportsCars.archive') }}" class="mb-3">
        <p>Total Archived Brands: {{ $totalBrands }}</p>
        <div class="form-group">
            <label for="brand">Select Brand:</label>
            <select name="brand" id="brand" class="form-control" onchange="this.form.submit()">
                <option value="">All Brands</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand }}" {{ $brandFilter == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                @endforeach
            </select>
        </div>
        <p>Total Archived Sports Cars: {{ $totalArchived }}</p>
    </form>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table border="1" width="100%" class="min-w-full divide-y divide-gray-200">
            <thead class="">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id</th>
                    <th class="">SportsCarId</th>
                    <th class="">Image</th>
                    <th class="">Brand</th>
                    <th class="">Model</th>
                    <th class="">Year</th>
                    <th class="">Description</th>
                    <th class="">Speed</th>
                    <th class="">Drivetrain</th>
                    <th class="">Price</th>
                    <th class="">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($deletedSportsCars as $car)
                    @if($car->isDeleted)
                        <tr>
                            <td class="">{{ $car->id }}</td>
                            <td class="">{{ $car->sportsCarId }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('images/cars/' . $car->image) }}" alt="Car Image"
                                    class="h-10 w-10 rounded-full object-cover">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $car->brand }}</td>
                            <td class="">{{ $car->model }}</td>
                            <td class="">{{ $car->year }}</td>
                            <td class="">{{ $car->description }}</td>
                            <td class="">{{ $car->speed }}</td>
                            <td class="">{{ $car->drivetrain }}</td>
                            <td class="">{{ $car->price }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('sportsCars.restore', $car->id) }}" method="GET" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">Restore</button>
                                </form>
                                <form action="{{ route('sportsCars.permanentDelete', $car->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection