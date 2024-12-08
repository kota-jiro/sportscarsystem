@extends('layout.app')

@section('title', 'Users')

@section('content')
<div class="container">
    <h2>User Profiles</h2>
    <div class="list-group">
        @foreach($users as $user)
            @if(!$user['isDeleted'])
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="{{ asset('images/users/' . $user['image']) }}" 
                                 class="rounded-circle img-fluid"
                                 alt="{{ $user['firstName'] }} {{ $user['lastName'] }}"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <h5 class="mb-1">{{ $user['firstName'] }} {{ $user['lastName'] }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><i class="fas fa-phone"></i> {{ $user['phone'] }}</p>
                                    <p class="mb-1"><i class="fas fa-map-marker-alt"></i> {{ $user['address'] }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><i class="fas fa-envelope"></i> {{ $user['email'] }}</p>
                                    <a href="{{ route('users.show', $user['id']) }}" class="btn btn-primary btn-sm">View Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
