<title>Admin Login</title>
<div class="container">
    <h1>Admin Login</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <button type="button" onclick="window.location.href='{{ route('admin.register') }}'"
            class="btn btn-secondary mt-3">Register</button>
    </form>
</div>
<style>
    /* General Styles */
    body {
        --tw-bg-opacity: 1;
        background-color: rgb(28 28 34 / var(--tw-bg-opacity));
        /* Dark background */
        --tw-text-opacity: 1;
        color: rgb(255 255 255 / var(--tw-text-opacity));
        /* White text */
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    /* Container */
    .container {
        background-color: rgb(28 28 34 / var(--tw-bg-opacity));
        /* Slightly lighter dark for the container */
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 255, 153, 0.8);
        width: 100%;
        max-width: 400px;
    }

    /* Heading */
    .container h1 {
        font-size: 2rem;
        margin-bottom: 1.5rem;
        text-align: center;
        color: rgb(0 255 133 / var(--tw-text-opacity));
        /* Green accent */
    }

    /* Alerts */
    .alert {
        border-radius: 5px;
        padding: 1rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .alert-danger {
        background-color: rgb(102 0 0 / var(--tw-bg-opacity));
        /* Dark red for error */
        color: rgb(255 102 102 / var(--tw-text-opacity));
        /* Light red text for error */
    }

    .alert-success {
        background-color: rgb(0 51 0 / var(--tw-bg-opacity));
        /* Dark green for success */
        color: rgb(0 255 133 / var(--tw-text-opacity));
        /* Green accent for success text */
    }

    /* Form */
    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: rgb(204 204 204 / var(--tw-text-opacity));
        /* Light grey for labels */
    }

    input {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #444444;
        border-radius: 5px;
        background-color: rgb(28 28 34 / var(--tw-bg-opacity));
        color: rgb(255 255 255 / var(--tw-text-opacity));
        font-size: 1rem;
    }

    input:focus {
        outline: none;
        border-color: #00FF85;
        /* Green outline on focus */
    }

    /* Buttons */
    button {
        width: 100%;
        padding: 0.8rem;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    button.btn-primary {
        background-color: #00FF85;
        /* Green button */
        color: #111111;
        /* Dark text */
    }

    button.btn-primary:hover {
        background-color: #00CC70;
        /* Darker green on hover */
        transform: scale(1.02);
        /* Slight zoom effect */
    }

    button.btn-secondary {
        background-color: #333333;
        /* Dark grey button */
        color: #FFFFFF;
        margin-top: 0.5rem;
    }

    button.btn-secondary:hover {
        background-color: #444444;
        /* Lighter grey on hover */
        transform: scale(1.02);
        /* Slight zoom effect */
    }

    /* Media Queries */
    @media (max-width: 768px) {
        .container {
            padding: 1.5rem;
        }

        h1 {
            font-size: 1.8rem;
        }
    }
</style>