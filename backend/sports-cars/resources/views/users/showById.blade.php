@extends('layout.app')

@section('title', 'User Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2 class="mb-0">User Profile</h2>
                </div>
                <div class="text-center mt-4">
                    <img src="{{ asset('images/users/' . $user->image) }}" 
                         class="rounded-circle img-fluid mx-auto"
                         style="width: 200px; height: 200px; object-fit: cover;"
                         alt="{{ $user->firstName }} {{ $user->lastName }}">
                </div>
                <div class="card-body">
                    <h3 class="text-center mb-4">{{ $user->firstName }} {{ $user->lastName }}</h3>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="info-group mb-3">
                                <i class="fas fa-phone me-2"></i>
                                <span class="fw-bold">Phone:</span>
                                <span>{{ $user->phone }}</span>
                            </div>
                            <div class="info-group mb-3">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <span class="fw-bold">Address:</span>
                                <span>{{ $user->address }}</span>
                            </div>
                            <div class="info-group mb-4">
                                <i class="fas fa-envelope me-2"></i>
                                <span class="fw-bold">Email:</span>
                                <span>{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection