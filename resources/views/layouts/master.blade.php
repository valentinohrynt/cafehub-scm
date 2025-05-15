<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cafe System')</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    @include('base.header')

    <!-- Main Content -->
    <main class="flex-fill py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    @include('base.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
</body>
</html>
