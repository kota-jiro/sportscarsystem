<!-- @extends('layout.app')

@section('content')
    <h2>Add New Sports Car</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sportscars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="make">Make:</label>
            <input type="text" name="make" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" name="model" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="year">Year:</label>
            <input type="number" name="year" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" class="form-control-file" required>
        </div>
        <button type="submit" class="btn btn-success">Add Sports Car</button>
    </form>
@endsection

 -->