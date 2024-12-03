<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('sportsCars.index') }}">Exotic Cars</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sportsCars.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sportsCars.showAll') }}">Sports Car</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sportsCars.archive') }}">Archive Sports Car</a>
                </li>
            </ul>
        </div>
    </nav>