@extends('layout.app')

@section('title', 'Archived Orders')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-gray-800 text-center mb-4">Archived Orders</h1>

    @if(session('restore'))
        <div class="alert alert-success">
            {{ session('restore') }}
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">View Orders</a>
        </div>
    @endif

    <form method="GET" action="{{ route('orders.archive') }}" class="mb-3">
        <p>Total Archived OrderedBy: {{ $totalOrderedBy }}</p>
        <div class="form-group">
            <label for="brand">Select Brand:</label>
            <select name="brand" id="brand" class="form-control" onchange="this.form.submit()">
                <option value="">All Brands</option>
                @foreach($orderedBy as $order)
                    <option value="{{ $order }}" {{ $orderedByFilter == $order ? 'selected' : '' }}>{{ $order }}</option>
                @endforeach
            </select>
        </div>
        <p>Total Archived Orders: {{ $totalArchived }}</p>
    </form>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table border="1" width="100%" class="min-w-full divide-y divide-gray-200">
            <thead class="">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id</th>
                    <th class="">OrderId</th>
                    <th class="">Image</th>
                    <th class="">OrderedBy</th>
                    <th class="">OrderedAt</th>
                    <th class="">Status</th>
                    <th class="">CreatedAt</th>
                    <th class="">UpdatedAt</th>
                    <th class="">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($deleteOrders as $order)
                    @if($order->isDeleted)
                        <tr>
                            <td class="">{{ $order->id }}</td>
                            <td class="">{{ $order->orderId }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('images/cars/' . $order->image) }}" alt="Car Image"
                                    class="h-10 w-10 rounded-full object-cover">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->orderedBy }}</td>
                            <td class="">{{ $order->orderedAt }}</td>
                            <td class="">{{ $order->status }}</td>
                            <td class="">{{ $order->created_at }}</td>
                            <td class="">{{ $order->updated_at }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('orders.restore', $order->id) }}" method="GET" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">Restore</button>
                                </form>
                                <form action="{{ route('orders.permanentDelete', $order->id) }}" method="POST" style="display:inline;">
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