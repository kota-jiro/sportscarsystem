@extends('layout.app')

@section('title', 'Users')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Users</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Add New User</a>
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

    <table border="1" width="100%" class="table table-striped">
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
                    <td><img src="{{ asset('images/users/' . $user['image']) }}" class="card-img-top"
                            alt="{{ $user['firstName'] }} Image" style="height: 200px; object-fit: cover;"></td>
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
@endsection