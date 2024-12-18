@extends('layout.app')
@section('title', 'Statistics')
@section('content')
<div class="dashboard-container">
    <div class="header-section">
        <h1 class="dashboard-title">Statistics</h1>
        <p class="dashboard-subtitle">Sports Car Dealership</p>
    </div>

    <div class="stats-container">
        <!-- Total Rentals -->
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
        <a href="{{ route('rentals.completed') }}" class="stat-card-link">
            <div class="stat-card" style="background-color: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.2);">
                <h2 style="color: #3B82F6;">{{ $stats['completed'] ?? 0 }}</h2>
                <p>Completed Rentals</p>
            </div>
        </a>

        <!-- Damaged Rentals -->
        <a href="{{ route('rentals.damaged') }}" class="stat-card-link">
            <div class="stat-card" style="background-color: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2);">
                <h2 style="color: #EF4444;">{{ $stats['damaged'] ?? 0 }}</h2>
                <p>Damaged Rentals</p>
            </div>
        </a>

        <!-- Total Revenue -->
        <div class="stat-card" style="background-color: rgba(0, 255, 133, 0.1); border-color: rgba(0, 255, 133, 0.2);">
            <h2 style="color: #00FF85;">₱{{ number_format($stats['totalRevenue'] ?? 0, 2) }}</h2>
            <p>Total Revenue</p>
        </div>

        <!-- Damage Charges -->
        <div class="stat-card" style="background-color: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2);">
            <h2 style="color: #EF4444;">₱{{ number_format($stats['damageCharges'] ?? 0, 2) }}</h2>
            <p>Damage Charges</p>
        </div>
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

@media (max-width: 768px) {
    .stats-container {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}
</style>
@endsection 