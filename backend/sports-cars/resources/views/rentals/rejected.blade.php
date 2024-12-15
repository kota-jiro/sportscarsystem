@extends('layout.app')

@section('content')
<div class="dashboard-container">
    <div class="header-section">
        <h1 class="dashboard-title">Rejected Rentals</h1>
        <p class="dashboard-subtitle">Sports Car Dealership</p>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-container">
        <table class="rental-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Car</th>
                    <th>User</th>
                    <th>Duration</th>
                    <th>Start Date</th>
                    <th>Price</th>
                    <th>Rejected Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                <tr>
                    <td>{{ $rental->rentId }}</td>
                    <td>{{ $rental->brandModel }}</td>
                    <td>{{ $rental->name }}</td>
                    <td>{{ $rental->rentDuration }}</td>
                    <td>{{ $rental->startDate }}</td>
                    <td>${{ number_format($rental->rentPrice, 2) }}</td>
                    <td>{{ $rental->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
.dashboard-container {
    min-height: 100vh;
    background-color: rgb(28, 28, 34);
    color: #ffffff;
    padding-bottom: 2rem;
    padding-right: 2rem;
}

.header-section {
    margin-bottom: 3rem;
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: bold;
    color: #ffffff;
    margin-bottom: 0.5rem;
}

.dashboard-subtitle {
    font-size: 1.2rem;
    color: #888;
    margin-bottom: 2rem;
}

/* Table Styles */
.table-container {
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    padding: 1.5rem;
    overflow-x: auto;
}

.rental-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.rental-table th {
    background-color: rgba(0, 255, 133, 0.1);
    color: #00FF85;
    font-weight: 500;
    text-align: left;
    padding: 1rem;
    border-bottom: 2px solid rgba(0, 255, 133, 0.2);
}

.rental-table td {
    padding: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    color: #cccccc;
}

.rental-table tr:hover td {
    background-color: rgba(0, 255, 133, 0.05);
}

/* Alert Styles */
.alert {
    border-radius: 5px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.alert-success {
    background-color: #003300;
    color: #00FF85;
}

.alert-error {
    background-color: #330000;
    color: #EF4444;
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }

    .dashboard-title {
        font-size: 2rem;
    }

    .table-container {
        padding: 1rem;
    }

    .rental-table {
        font-size: 0.9rem;
    }
}
</style>
@endsection 