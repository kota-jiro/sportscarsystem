@extends('layout.app')

@section('title', 'User Details')

@section('content')
<div class="container">
    <h2>{{ $user->firstName }} {{ $user->lastName }}</h2>
    <div class="card mb-4">
        <img src="{{ asset('images/users/' . $user->image) }}" class="card-img-top" alt="{{ $user->firstName }} {{ $user->lastName }}">
        <div class="card-body">
            <p class="card-text">Phone: {{ $user->phone }}</p>
            <p class="card-text">Address: {{ $user->address }}</p>
            <p class="card-text">Email: {{ $user->email }}</p>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection 