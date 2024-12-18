@extends('layout.app')

@section('content')
<div class="dashboard-container">
    <div class="header-section">
        <h1 class="dashboard-title">Pending Rentals</h1>
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

    <div class="stats-section">
        <div class="stats-container">
        <a href="{{ route('rentals.index') }}" class="stat-card-link">
            <div class="stat-card">
                <h2>{{ $stats['total'] ?? 0 }}</h2>
                <p>Total Rentals</p>
            </div>
        </a>

        <!-- Pending Rentals -->
        <a href="{{ route('rentals.pending') }}" class="stat-card-link">
            <div class="stat-card" style="background-color: rgba(255, 193, 7, 0.1); border-color: rgba(255, 193, 7, 0.2);">
                <h2 style="color: #FFC107;">{{ $stats['pending'] ?? 0 }}</h2>
                <p>Pending Rentals</p>
            </div>
        </a>

        <!-- Active Rentals -->
        <a href="{{ route('rentals.active') }}" class="stat-card-link">
            <div class="stat-card" style="background-color: rgba(0, 255, 133, 0.1); border-color: rgba(0, 255, 133, 0.2);">
                <h2 style="color: #00FF85;">{{ $stats['approved'] ?? 0 }}</h2>
                <p>Active Rentals</p>
            </div>
        </a>

        <!-- Completed Rentals -->
        <a href="{{ route('rentals.statistics') }}" class="stat-card-link">
            <div class="stat-card" style="background-color: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.2);">
                <h2 style="color: #3B82F6;">{{ $stats['completed'] ?? 0 }}</h2>
                <p>Completed Rentals</p>
            </div>
        </a>
        </div>
    </div>

    <div class="table-container">
        <table class="rental-table">
            <thead>
                <tr>
                    <th>Rent ID</th>
                    <th>Sports Car</th>
                    <th>User</th>
                    <th>Duration</th>
                    <th>Start Date</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                <tr>
                    <td>{{ $rental->rentId }}</td>
                    <td class="brand-model">{{ $rental->brandModel }}</td>
                    <td class="user-name">{{ $rental->name }}</td>
                    <td class="duration">{{ $rental->rentDuration }}</td>
                    <td class="start-date">{{ $rental->startDate }}</td>
                    <td>₱{{ number_format($rental->rentPrice, 2) }}</td>
                    <td>
                        <form action="{{ route('rentals.approve', $rental->rentId) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary">Approve</button>
                        </form>
                        <form action="{{ route('rentals.reject', $rental->rentId) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                    </td>
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

/* Stats Section Styles */
.stats-section {
    margin-bottom: 3rem;
}
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.stat-card {
    background-color: rgba(0, 255, 133, 0.1);
    border: 1px solid rgba(0, 255, 133, 0.2);
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-card h2 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

.stat-card p {
    color: #888;
    font-size: 1rem;
}

.stat-card-link {
    text-decoration: none;
}

/* Table Styles */
.table-container {
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    padding: 1.5rem;
    overflow-x: auto;
}

.brand-model, .user-name, .duration {
    text-transform: capitalize;
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

/* Button Styles */
.btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 0 0.25rem;
}

.btn-primary {
    background-color: rgba(0, 255, 133, 0.1);
    color: #00FF85;
    border: 1px solid rgba(0, 255, 133, 0.2);
}

.btn-danger {
    background-color: rgba(239, 68, 68, 0.1);
    color: #EF4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.btn:hover {
    transform: translateY(-2px);
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

    .stats-container {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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