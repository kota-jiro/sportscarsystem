<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exotic Cars</title>
    <link rel="stylesheet" href="{{ asset('views/design/global.css') }}">
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
</head>

<body>
    @include('components.navbar')
    <div class="container mt-4">
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>

</html>

<style>
body {
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background-color: rgba(28, 28, 34, 1);
    color: rgba(255, 255, 255, 1);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    flex: 1;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}
</style>