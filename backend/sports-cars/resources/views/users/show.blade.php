@extends('layout.app')

@section('title', 'Users')

@section('content')
<div class="container">
    <h2>All Exotic Cars</h2>
    <div class="row">
        @foreach($users as $user)
            @if(!$user['isDeleted'])
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('images/users/' . $user['image']) }}" class="card-img-top" alt="{{ $user['firstName'] }} {{ $user['lastName'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $user['firstName'] }} {{ $user['lastName'] }}</h5>
                            <p class="card-text">Phone: {{ $user['phone'] }}</p>
                            <p class="card-text">Address: {{ $user['address'] }}</p>
                            <p class="card-text">Email: {{ $user['email'] }}</p>
                            <a href="{{ route('users.show', $user['id']) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
