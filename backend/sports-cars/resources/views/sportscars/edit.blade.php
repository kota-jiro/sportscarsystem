@extends('layout.app')

@section('content')
<div class="dashboard-container">
    <div class="header-section">
        <h1 class="dashboard-title">Edit Sports Car</h1>
        <p class="dashboard-subtitle">Sports Car Dealership</p>
    </div>

    <div class="form-container">
        <form action="{{ route('sportsCars.update', $sportsCar->sportsCarId) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" name="brand" class="form-control brand-input" value="{{ $sportsCar->brand }}" required>
                </div>
                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" name="model" class="form-control model-input" value="{{ $sportsCar->model }}" required>
                </div>
                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="text" name="year" class="form-control year-input" value="{{ $sportsCar->year }}" required>
                </div>
                <div class="form-group">
                    <label for="speed">Speed</label>
                    <input type="text" name="speed" class="form-control speed-input" value="{{ $sportsCar->speed }}" required>
                </div>
                <div class="form-group">
                    <label for="drivetrain">Drivetrain</label>
                    <input type="text" name="drivetrain" class="form-control drivetrain-input" value="{{ $sportsCar->drivetrain }}" required>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" class="form-control price-input" value="{{ $sportsCar->price }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control description-input" name="description" required>{{ $sportsCar->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Current Image</label>
                    <div class="current-image">
                        <img src="{{ asset('images/' . $sportsCar->image) }}" alt="{{ $sportsCar->brand }} {{ $sportsCar->model }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Update Image</label>
                    <div class="image-upload-container">
                        <input type="file" name="image" id="image" class="image-input" accept="image/*">
                        <div class="upload-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="upload-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="upload-text">Choose a new image</span>
                            <span class="upload-hint">or drag and drop here</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Update Sports Car</button>
                <a href="{{ route('sportsCars.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding-bottom: 1rem;
    padding-right: 1rem;
}

.header-section {
    margin-bottom: 2rem;
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
}

.form-container {
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    padding: 2rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    color: #00FF85;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    color: #ffffff;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #00FF85;
    box-shadow: 0 0 0 2px rgba(0, 255, 133, 0.2);
}

.brand-input, .model-input, .description-input {
    text-transform: capitalize;
}
.speed-input, .drivetrain-input {
    text-transform: uppercase;
}

.description-input {
    height: 120px;
    resize: none;
}

.current-image {
    width: 100%;
    height: 200px;
    margin-bottom: 1rem;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid rgba(0, 255, 133, 0.2);
}

.current-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-upload-container {
    position: relative;
    width: 90%;
    min-height: 150px;
    background-color: rgba(255, 255, 255, 0.05);
    border: 2px dashed rgba(0, 255, 133, 0.3);
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
    cursor: pointer;
}

.upload-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.upload-icon {
    width: 48px;
    height: 48px;
    color: #00FF85;
}

.upload-text {
    color: #00FF85;
    font-weight: 500;
}

.upload-hint {
    color: #888;
    font-size: 0.9rem;
}

.button-group {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: rgba(0, 255, 133, 0.1);
    color: #00FF85;
    border: 1px solid rgba(0, 255, 133, 0.2);
}

.btn-secondary {
    background-color: rgba(156, 163, 175, 0.1);
    color: #9CA3AF;
    border: 1px solid rgba(156, 163, 175, 0.2);
}

.btn:hover {
    transform: translateY(-2px);
}

@media (max-width: 1024px) {
    .form-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .form-grid {
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
