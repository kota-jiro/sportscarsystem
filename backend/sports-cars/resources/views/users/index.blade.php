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
                    <th>FullName</th>
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
                        <td class="full-name">{{ $user['firstName'] . ' ' . $user['lastName'] }}</td>
                        <td class="phone">{{ $user['phone'] }}</td>
                        <td class="address">{{ $user['address'] }}</td>
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
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1em;
}

.form-control:focus {
    outline: none;
    border-color: rgba(0, 255, 133, 0.5);
    box-shadow: 0 0 0 2px rgba(0, 255, 133, 0.2);
}

.form-control option {
    background-color: rgb(28, 28, 34);
    color: #ffffff;
    padding: 10px;
}

.form-control option:hover,
.form-control option:focus,
.form-control option:active,
.form-control option:checked {
    background-color: rgba(0, 255, 133, 0.1);
}

/* Table Styles */
.table-container {
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    padding: 1.5rem;
    overflow-x: auto;
    width: 100%;
    margin-right: 20%;
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

.full-name, .address {
    text-transform: capitalize;
}

/* Button Styles */
.btn {
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: rgba(0, 255, 133, 0.1);
    color: #00FF85;
    border: 1px solid rgba(0, 255, 133, 0.2);
}

.btn-secondary {
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

.mt-4 a {
    position: absolute;
    text-decoration: none;
    margin: 1rem 1rem 1rem 61rem;
    width: 15%;
    text-align: center;
    transform: translateY(-75px);
    transition: transform 0.3s ease;
}

.mt-4 a:hover {
    transform: translateY(-73px);
}

.alert {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: rgb(28, 28, 34);
    color: #00FF85;
    padding: 1rem;
    border-radius: 5px;
    margin-bottom: 1rem;
    border: 1px solid rgba(0, 255, 133, 0.2);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.alert a {
    position: static;
    transform: none;
    margin: 0;
    padding: 0.5rem 1rem;
    text-decoration: none;
    border-radius: 6px;
    background-color: rgba(0, 255, 133, 0.1);
    color: #00FF85;
    border: 1px solid rgba(0, 255, 133, 0.2);
    transition: all 0.3s ease;
}

.alert a:hover {
    transform: translateY(-2px);
    background-color: rgba(0, 255, 133, 0.15);
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

    .form-group {
        width: 100%;
    }
}
</style>
@endsection