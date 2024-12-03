<!-- @extends('layout.app')

@section('content')
    <h2>Edit Sports Car</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sportscars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="make">Make:</label>
            <input type="text" name="make" class="form-control" value="{{ $car->make }}" required>
        </div>
        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" name="model" class="form-control" value="{{ $car->model }}" required>
        </div>
        <div class="form-group">
            <label for="year">Year:</label>
            <input type="number" name="year" class="form-control" value="{{ $car->year }}" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" name="price" class="form-control" value="{{ $car->price }}" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" class="form-control" value="{{ $car->quantity }}" required>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" class="form-control-file">
            <p>Current Image: <img src="{{ asset('images/cars/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" style="width: 150px;"></p>
        </div>
        <button type="submit" class="btn btn-primary">Update Sports Car</button>
    </form>
@endsection


 -->