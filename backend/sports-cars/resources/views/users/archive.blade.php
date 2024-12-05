@extends('layout.app')

@section('title', 'Archived Users')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-gray-800 text-center mb-4">Archived Users</h1>

    @if(session('restore'))
        <div class="alert alert-success">
            {{ session('restore') }}
            <a href="{{ route('users.index') }}" class="btn btn-secondary">View Users</a>
        </div>
    @endif

    <form method="GET" action="{{ route('users.archive') }}" class="mb-3">
        <p>Total Archived Emails: {{ $totalEmails }}</p>
        <div class="form-group">
            <label for="email">Select Email:</label>
            <select name="email" id="email" class="form-control" onchange="this.form.submit()">
                <option value="">All Emails</option>
                @foreach($emails as $email)
                    <option value="{{ $email }}" {{ $emailFilter == $email ? 'selected' : '' }}>{{ $email }}</option>
                @endforeach
            </select>
        </div>
        <p>Total Archived Users: {{ $totalArchived }}</p>
    </form>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table border="1" width="100%" class="min-w-full divide-y divide-gray-200">
            <thead class="">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id</th>
                    <th class="">UserId</th>
                    <th class="">Image</th>
                    <th class="">First Name</th>
                    <th class="">Last Name</th>
                    <th class="">Phone</th>
                    <th class="">Address</th>
                    <th class="">Email</th>
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('images/users/' . $user->image) }}" alt="User Image"
                                    class="h-10 w-10 rounded-full object-cover">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->firstName }}</td>
                            <td class="">{{ $user->lastName }}</td>
                            <td class="">{{ $user->phone }}</td>
                            <td class="">{{ $user->address }}</td>
                            <td class="">{{ $user->email }}</td>
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
@endsection