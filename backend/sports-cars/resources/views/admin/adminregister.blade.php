<div class="container">
    <h1>Admin Register</h1>
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

    <form action="{{ route('admin.register.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="{{ route('admin.login') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
