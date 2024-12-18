@extends('layout.app')

@section('title', 'Add New Sports Car')

@section('content')
<div class="dashboard-container">
    <div class="header-section">
        <h1 class="dashboard-title">Add New Sports Car</h1>
        <p class="dashboard-subtitle">Sports Car Dealership</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <form action="{{ route('sportsCars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Brand</label>
                    <input type="text" class="form-control brand-input" id="name" name="brand" required>
                </div>
                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" class="form-control model-input" id="model" name="model" required>
                </div>
                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="number" class="form-control year-input" id="year" name="year" required>
                </div>
                <div class="form-group">
                    <label for="speed">Speed</label>
                    <input type="text" class="form-control speed-input" id="speed" name="speed" required>
                </div>
                <div class="form-group">
                    <label for="drivetrain">Drivetrain</label>
                    <select class="form-control drivetrain-input" id="drivetrain" name="drivetrain" required>
                        <option value="">Select Drivetrain</option>
                        <option value="AWD">AWD (All-Wheel Drive)</option>
                        <option value="FWD">FWD (Front-Wheel Drive)</option>
                        <option value="4WD">4WD (Four-Wheel Drive)</option>
                        <option value="RWD">RWD (Rear-Wheel Drive)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control price-input" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control description-input" id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <div class="image-upload-container">
                        <input type="file" name="image" id="image" class="image-input" accept="image/*" required>
                        <label for="image" class="image-upload-label">
                            <div class="upload-content">
                                <svg xmlns="http://www.w3.org/2000/svg" class="upload-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="upload-text">Choose an image</span>
                                <span class="upload-hint">or drag and drop here</span>
                            </div>
                        </label>
                        <div id="image-preview" class="image-preview"></div>
                    </div>
                </div>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Add Sports Car</button>
                <a href="{{ route('sportsCars.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
.dashboard-container {
    min-height: 100vh;
    background-color: rgb(28, 28, 34);
    color: #ffffff;
    padding-bottom: 2rem;
    padding-right: 2rem;
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

.form-container {
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    padding: 4rem;
    max-width: 1200px;
    width: 92%;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2.5rem;
    margin-bottom: 2rem;
    margin-right: 1rem;
    padding: 1rem;
}

.form-group {
    margin-bottom: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group label {
    display: block;
    color: #00FF85;
    font-weight: 500;
    font-size: 1.1rem;
}

.form-control {
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    padding: 0.75rem;
    border-radius: 6px;
    width: 100%;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1em;
}

.form-control option {
    background-color: rgb(28, 28, 34);
    color: #ffffff;
    padding: 10px;
}

.form-control option:hover,
.form-control option:focus,
.form-control option:active,
.form-control option:checked {
    background-color: rgba(0, 255, 133, 0.1);
}

.form-control:focus {
    outline: none;
    border-color: #00FF85;
    box-shadow: 0 0 0 2px rgba(0, 255, 133, 0.2);
}

.form-control-file {
    padding: 0.75rem;
    margin-top: 0.5rem;
    background-color: transparent;
}

.brand-input, .model-input, .description-input {
    text-transform: capitalize;
}
.speed-input, .drivetrain-input {
    text-transform: uppercase;
}
.description-input {
    height: 100%;
    resize: none;
    padding-top: 0.75rem;
    line-height: 1.5;
    vertical-align: top;
}

.button-group {
    display: flex;
    gap: 1.5rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding: 0 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
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

.alert {
    border-radius: 6px;
    padding: 1rem;
    margin-bottom: 2rem;
}

.alert-error {
    background-color: rgba(239, 68, 68, 0.1);
    color: #EF4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }

    .dashboard-title {
        font-size: 2rem;
    }

    .form-container {
        padding: 1rem;
    }

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

.image-upload-container {
    position: relative;
    width: 100%;
    min-height: 130px;
    background-color: rgba(255, 255, 255, 0.05);
    border: 2px dashed rgba(0, 255, 133, 0.3);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.image-upload-container:hover {
    border-color: rgba(0, 255, 133, 0.5);
    background-color: rgba(0, 255, 133, 0.05);
}

.image-input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.image-upload-label {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #00FF85;
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
    font-size: 1.1rem;
    font-weight: 500;
}

.upload-hint {
    font-size: 0.9rem;
    color: #888;
}

.image-preview {
    display: none;
    width: 100%;
    height: 200px;
    border-radius: 8px;
    overflow: hidden;
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Add drag and drop states */
.image-upload-container.drag-over {
    border-color: #00FF85;
    background-color: rgba(0, 255, 133, 0.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.image-upload-container');
    const input = document.querySelector('.image-input');
    const preview = document.querySelector('.image-preview');

    // Handle drag and drop events
    container.addEventListener('dragover', (e) => {
        e.preventDefault();
        container.classList.add('drag-over');
    });

    container.addEventListener('dragleave', () => {
        container.classList.remove('drag-over');
    });

    container.addEventListener('drop', (e) => {
        e.preventDefault();
        container.classList.remove('drag-over');
        if (e.dataTransfer.files.length) {
            input.files = e.dataTransfer.files;
            showPreview(e.dataTransfer.files[0]);
        }
    });

    // Handle file input change
    input.addEventListener('change', (e) => {
        if (e.target.files.length) {
            showPreview(e.target.files[0]);
        }
    });

    function showPreview(file) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.style.display = 'block';
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                document.querySelector('.upload-content').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    }
});
</script>
@endsection
