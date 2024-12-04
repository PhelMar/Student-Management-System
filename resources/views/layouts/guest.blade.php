<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LCC-OSAS') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon_io/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}">
    <script src="{{asset('admin/js/jquery-3.6.0.min.js')}}"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            color: white;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("{{ asset('images/lccAnex.jpg') }}");
            background-size: cover;
            background-position: center;
            filter: brightness(0.6);
            z-index: -1;
        }
    </style>
</head>

<body class="bg-light text-dark">
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100">
        <!-- Application Logo -->
        <div class="mb-4">
            <a href="/">
                <x-application-logo class="rounded mt-2" style="width: 100px; height: 100px;" />
            </a>
        </div>

        <!-- Slot Content -->
        <div class="card shadow-lg" style="width: 30rem; max-width: 100%;">

            <div class="card-body p-2">
                {{ $slot }}
            </div>
        </div>
    </div>

    <script src="{{ asset('user/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>