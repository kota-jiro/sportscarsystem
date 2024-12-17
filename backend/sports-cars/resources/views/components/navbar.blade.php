<nav class="navbar">
    <a class="navbar-brand" href="{{ route('sportsCars.index') }}">Exotic Car</a>
    <div class="navbar-collapse">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('rentals.statistics') }}">Rental Statistics</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sportsCars.index') }}">Sports Cars</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('rentals.index') }}">Rentals</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('rentals.pending') }}">Pending Rentals</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('rentals.active') }}">Active Rentals</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sportsCars.archive') }}">Archive Sports Cars</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.archive') }}">Archive Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('orders.archive') }}">Archive Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('rentals.rejected') }}">Rejected Rentals</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.profile') }}">Profile</a>
            </li>
            <li class="nav-item">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<style>
.navbar {
    background-color: rgb(28, 28, 34);
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0, 255, 153, 0.1);
}

.navbar-brand {
    color: #ffffff;
    font-size: 1.5rem;
    font-weight: bold;
    text-decoration: none;
}

.navbar-nav {
    display: flex;
    gap: 1.5rem;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-link {
    color: #cccccc;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: #00FF85;
}

.nav-link.active {
    color: #00FF85;
    border-bottom: 2px solid #00FF85;
}

.logout-btn {
    background-color: #00FF85;
    color: #111111;
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.logout-btn:hover {
    background-color: #00CC70;
}

@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        padding: 1rem;
    }

    .navbar-nav {
        flex-direction: column;
        width: 100%;
        text-align: center;
        gap: 0.5rem;
    }

    .nav-item {
        width: 100%;
        padding: 0.5rem 0;
    }
}
</style>