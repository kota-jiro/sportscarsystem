@extends('layout.app')

@section('title', 'Users')

@section('content')
<div class="dashboard-container">
    <div class="header-section">
        <h1 class="dashboard-title">Users</h1>
        <p class="dashboard-subtitle">Sports Car Dealership</p>
    </div>

    @if(session('archive'))
        <div class="alert alert-success">
            {{ session('archive') }}
            <a href="{{ route('users.archive') }}" class="btn btn-secondary">View Archived Users</a>
        </div>
    @endif

    <form method="GET" action="{{ route('users.index') }}" class="mb-3">
        <p>Total Roles: {{ $totalRoles }}</p>
        <div class="form-group">
            <label for="roleId">Select Role:</label>
            <select name="roleId" id="roleId" class="form-control" onchange="this.form.submit()">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ $roleFilter == $role ? 'selected' : '' }}>{{ $role }}</option>
                @endforeach
            </select>
        </div>
        <p>Total Users: {{ $userCount }}</p>
    </form>
    
    <div class="table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>UserId</th>
                    <th>RoleId</th>
                    <th>Image</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>CreatedAt</th>
                    <th>UpdatedAt</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['userId'] }}</td>
                        <td>{{ $user['roleId'] }}</td>
                        <td><img src="{{ asset('images/users/' . $user['image']) }}" class="user-image"
                                alt="{{ $user['firstName'] }} Image"></td>
                        <td>{{ $user['firstName'] }}</td>
                        <td>{{ $user['lastName'] }}</td>
                        <td>{{ $user['phone'] }}</td>
                        <td>{{ $user['address'] }}</td>
                        <td>{{ $user['username'] }}</td>
                        <td>{{ $user['password'] }}</td>
                        <td>{{ $user['created_at'] }}</td>
                        <td>{{ $user['updated_at'] }}</td>
                        <td>
                            <form action="{{ route('users.edit', $user['id']) }}" method="GET" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning">Edit</button>
                            </form>
                            <form action="{{ route('users.destroy', $user['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Archive</button>
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
    padding: 2px;
    min-height: 100vh;
    background-color: rgb(28, 28, 34);
    color: #ffffff;
    padding-bottom: 2rem;
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

/* Form Styling */
.form-group {
    margin-bottom: 2rem;
    background-color: rgba(255, 255, 255, 0.05);
    padding: 1.5rem;
    border-radius: 10px;
    width: 20%;
}

.form-control {
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    padding: 0.75rem;
    border-radius: 6px;
    width: 100%;
    max-width: 300px;
}

/* Table Styles */
.table-container {
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    padding: 1.5rem;
    overflow-x: auto;
    width: 100%;
}

.users-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.users-table th {
    background-color: rgba(0, 255, 133, 0.1);
    color: #00FF85;
    font-weight: 500;
    text-align: left;
    padding: 1rem;
    border-bottom: 2px solid rgba(0, 255, 133, 0.2);
}

.users-table td {
    padding: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    color: #cccccc;
}

.users-table tr:hover td {
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

.btn-warning {
    background-color: rgba(255, 193, 7, 0.1);
    color: #FFC107;
    border: 1px solid rgba(255, 193, 7, 0.2);
}

.btn-danger {
    background-color: rgba(239, 68, 68, 0.1);
    color: #EF4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.btn:hover {
    transform: translateY(-2px);
}

.mt-4 a {
    position: absolute;
    text-decoration: none;
    margin: 1rem 1rem 1rem 62.7rem;
    width: 15%;
    text-align: center;
    transform: translateY(-75px);
}

.user-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.user-image:hover {
    transform: scale(1.1);
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

    .users-table {
        font-size: 0.9rem;
    }

    .user-image {
        width: 50px;
        height: 50px;
    }
}
</style>
@endsection