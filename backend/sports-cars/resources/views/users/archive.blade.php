@extends('layout.app')

@section('title', 'Archived Users')

@section('content')
<div class="dashboard-container">
    <div class="header-section">
        <h1 class="dashboard-title">Archived Users</h1>
        <p class="dashboard-subtitle">Sports Car Dealership</p>
    </div>

    @if(session('restore'))
        <div class="alert alert-success">
            {{ session('restore') }}
            <a href="{{ route('users.index') }}" class="btn btn-secondary">View Users</a>
        </div>
    @endif

    <form method="GET" action="{{ route('users.archive') }}" class="mb-3">
        <p>Total Archived Roles: {{ $totalRoles }}</p>
        <div class="form-group">
            <label for="roleId">Select Role:</label>
            <select name="roleId" id="roleId" class="form-control" onchange="this.form.submit()">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ $roleFilter == $role ? 'selected' : '' }}>{{ $role }}</option>
                @endforeach
            </select>
        </div>
        <p>Total Archived Users: {{ $totalArchived }}</p>
    </form>
    
    <div class="table-container">
        <table class="users-table">
            <thead class="">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id</th>
                    <th class="">UserId</th>
                    <th class="">RoleId</th>
                    <th class="">Image</th>
                    <th class="">First Name</th>
                    <th class="">Last Name</th>
                    <th class="">Phone</th>
                    <th class="">Address</th>
                    <th class="">Username</th>
                    <th class="">Password</th>
                    <th class="">Created At</th>
                    <th class="">Updated At</th>
                    <th class="">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($deletedUsers as $user)
                    @if($user->isDeleted)
                        <tr>
                            <td class="">{{ $user->id }}</td>
                            <td class="">{{ $user->userId }}</td>
                            <td class="">{{ $user->roleId }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('images/users/' . $user->image) }}" alt="User Image"
                                    class="h-10 w-10 rounded-full object-cover">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->firstName }}</td>
                            <td class="">{{ $user->lastName }}</td>
                            <td class="">{{ $user->phone }}</td>
                            <td class="">{{ $user->address }}</td>
                            <td class="">{{ $user->username }}</td>
                            <td class="">{{ $user->password }}</td>
                            <td class="">{{ $user->created_at }}</td>
                            <td class="">{{ $user->updated_at }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('users.restore', $user->id) }}" method="GET" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">Restore</button>
                                </form>
                                <form action="{{ route('users.permanentDelete', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endif
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

/* Image styling */
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

/* Alert Styles */
.alert {
    border-radius: 5px;
    padding: 1rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.alert-success {
    background-color: #003300;
    color: #00FF85;
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