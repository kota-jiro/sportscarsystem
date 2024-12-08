<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('sportsCars.index') }}">Exotic Cars</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sportsCars.index') }}">Sports Cars Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sportsCars.showAll') }}">Sports Cars</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sportsCars.archive') }}">Archive Sports Cars</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">Users Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.showAll') }}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.archive') }}">Archive Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.index') }}">Orders Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.showAll') }}">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.archive') }}">Archive Orders</a>
                </li>
            </ul>
        </div>
    </nav>