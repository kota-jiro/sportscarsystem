@extends('layout.app')

@section('title', 'Orders')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Orders</h1>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Add New Order</a>
    </div>
    
    @if(session('archive'))
        <div class="alert alert-success">
            {{ session('archive') }}
            <a href="{{ route('orders.archive') }}" class="btn btn-secondary">View Archived Orders</a>
        </div>
    @endif

    <form method="GET" action="{{ route('orders.index') }}" class="mb-3">
        <p>Total OrderedBy: {{ $totalOrderedBy }}</p>
        <div class="form-group">
            <label for="orderedBy">Select OrderedBy:</label>
            <select name="orderedBy" id="orderedBy" class="form-control" onchange="this.form.submit()">
                <option value="">All OrderedBy</option>
                @foreach($orderedBy as $order)
                    <option value="{{ $order }}" {{ $orderedByFilter == $order ? 'selected' : '' }}>{{ $order }}</option>
                @endforeach
            </select>
        </div>
        <p>Total Orders: {{ $orderCount }}</p>
    </form>

    <table border="1" width="100%" class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>OrderId</th>
                <th>OrderedCar</th>
                <th>OrderedImage</th>
                <th>OrderedBy</th>
                <th>Status</th>
                <th>CreatedAt</th>
                <th>UpdatedAt</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deleteOrders as $order)
                <tr>
                    <td>{{ $order['id'] }}</td>
                    <td>{{ $order['orderId'] }}</td>
                    <td>{{ $order['orderedCar'] }}</td>
                    <td><img src="{{ asset('images/' . $order['image']) }}" class="card-img-top"
                            alt="{{ $order['orderedCar'] }} Image" style="height: 200px; object-fit: cover;"></td>
                    <td>{{ $order['orderedBy'] }}</td>
                    <td>
                        <form action="{{ route('orders.updateStatus', $order['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()">
                                <option value="pending" {{ $order['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $order['status'] == 'approved' ? 'selected' : '' }}>Approved</option>
                            </select>
                        </form>
                    </td>
                    <td>{{ $order['created_at'] }}</td>
                    <td>{{ $order['updated_at'] }}</td>
                    <td>
                        <form action="{{ route('orders.destroy', $order['id']) }}" method="POST" style="display:inline;">
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