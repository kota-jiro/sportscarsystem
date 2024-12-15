@extends('layout.app')

@section('content')
<div class="dashboard-container">
    <div class="header-section">
        <h1 class="dashboard-title">Rentals Management</h1>
        <p class="dashboard-subtitle">Sports Car Dealership</p>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="stats-container">
            
        </div>
    </div>

    <!-- Clear separation -->
    <div style="margin-top: 2rem;"></div>

    <!-- Table Section -->
    <div class="table-container">
        <table class="rental-table">
            <thead>
                <tr>
                    <th>Rent ID</th>
                    <th>Car</th>
                    <th>User</th>
                    <th>Duration</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                <tr>
                    <td>{{ $rental->rentId }}</td>
                    <td class="captalize">{{ $rental->brandModel }}</td>
                    <td>{{ $rental->name }}</td>
                    <td>{{ $rental->rentDuration }}</td>
                    <td>{{ ucfirst($rental->status) }}</td>
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
}

/* Table Styles */
.table-container {
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    padding: 1.5rem;
    overflow-x: auto;
    margin-top: 2rem;
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

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }

    .dashboard-title {
        font-size: 2rem;
    }

    .stats-container {
        grid-template-columns: 1fr;
    }

    .table-container {
        padding: 1rem;
    }

    .rental-table {
        font-size: 0.9rem;
    }
}

/* Link Styles */
.stat-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

/* Animation for hover effects */
.stat-card-link:hover .stat-card {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 255, 133, 0.2);
}

/* Dark
</style>
@endsection
