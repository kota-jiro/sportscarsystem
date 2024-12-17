@extends('layout.app')

@section('title', 'Admin Profile')

@section('content')
<div class="dashboard-container">
    <div class="header-section">
        <h1 class="dashboard-title">Admin Profile</h1>
        <p class="dashboard-subtitle">Manage Your Account</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-image-container">
                @if($user->image)
                    <img src="{{ asset('images/users/' . $user->image) }}" alt="Profile Picture" class="profile-image">
                @else
                    <div class="profile-image-placeholder">
                        {{ strtoupper(substr($user->firstName, 0, 1)) }}{{ strtoupper(substr($user->lastName, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="profile-name">
                <h2>{{ $user->firstName }} {{ $user->lastName }}</h2>
                <p class="profile-role">Administrator</p>
            </div>
        </div>
        <div class="profile-details">
            <div class="detail-group">
                <label>Phone</label>
                <p class="detail-value">{{ $user->phone }}</p>
            </div>
            <div class="detail-group">
                <label>Address</label>
                <p class="detail-value">{{ $user->address }}</p>
            </div>
        </div>
        <div class="button-group">
            <a href="{{ route('admin.editprofile', $user->userId) }}" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>
</div>

<style>
.dashboard-container {
    min-height: 100vh;
    background-color: rgb(28, 28, 34);
    color: #ffffff;
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
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

.profile-container {
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    padding: 2rem;
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.profile-image-container {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid rgba(0, 255, 133, 0.2);
}

.profile-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-image-placeholder {
    width: 100%;
    height: 100%;
    background-color: rgba(0, 255, 133, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: bold;
    color: #00FF85;
}

.profile-name {
    flex: 1;
}

.profile-name h2 {
    font-size: 2rem;
    font-weight: bold;
    color: #ffffff;
    margin-bottom: 0.5rem;
}

.profile-role {
    color: #00FF85;
    font-size: 1.1rem;
}

.profile-details {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
}

.detail-group {
    margin-bottom: 1.5rem;
}

.detail-group label {
    display: block;
    color: #00FF85;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.detail-value {
    padding: 0.75rem;
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    color: #ffffff;
}

.button-group {
    display: flex;
    justify-content: flex-end;
    margin-top: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-primary {
    background-color: rgba(0, 255, 133, 0.1);
    color: #00FF85;
    border: 1px solid rgba(0, 255, 133, 0.2);
}

.btn:hover {
    transform: translateY(-2px);
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 2rem;
}

.alert-success {
    background-color: rgba(0, 255, 133, 0.1);
    border: 1px solid rgba(0, 255, 133, 0.2);
    color: #00FF85;
}

.alert-error {
    background-color: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: #EF4444;
}

@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .profile-details {
        grid-template-columns: 1fr;
    }
    
    .button-group {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
@endsection
