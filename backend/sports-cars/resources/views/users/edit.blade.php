@extends('layout.app')

@section('title', 'Edit User')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('users.update', $user->userId) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="fname">First Name</label>
            <input type="text" name="firstName" class="form-control" value="{{ $user->firstName }}" required>
        </div>
        <div class="form-group">
            <label for="lname">Last Name</label>
            <input type="text" name="lastName" class="form-control" value="{{ $user->lastName }}" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" disabled>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" value="{{ $user->address }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" value="{{ $user->email }}" disabled>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" name="password" class="form-control" value="{{ $user->password }}" required>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="number" name="confirmPassword" class="form-control" value="{{ $user->confirmPassword }}" required>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" class="form-control-file">
            <p>Current Image: <img src="{{ asset('images/users/' . $user->image) }}" alt="{{ $user->firstName }} {{ $user->lastName }} " style="width: 150px;"></p>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
