<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome LCC-OSAS</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon_io/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

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

        .navbar {
            background: rgba(0, 0, 0, 0.7);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .login-btn {
            border-radius: 20px;
            padding: 8px 20px;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .login-btn:hover {
            background-color: #0056b3;
            color: white;
        }

        .content-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 90vh;
            padding-top: 5rem;
            gap: 20px;
        }

        .carousel-container {
            flex: 1;
            max-width: 60%;
        }

        .carousel-inner img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .left-content {
            flex: 1;
            max-width: 40%;
            color: white;
            padding: 20px;
        }

        .carousel-indicators li {
            background-color: white;
            border-radius: 50%;
            width: 12px;
            height: 12px;
            margin: 0 4px;
        }

        .carousel-indicators .active {
            background-color: #007bff;
        }

        footer {
            text-align: center;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 0;
            color: white;
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <div class="ms-auto me-3">
            <a class="btn btn-primary login-btn" href="{{ route('login') }}">Login</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container content-wrapper">
        <!-- Left Content -->
        <div class="left-content">
            <h1>Welcome to LCC-OSAS</h1>
            <p>
                Empowering education and fostering growth within our community.
                Join us to explore innovative learning opportunities and be part of an inspiring journey.
            </p>
            <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
        </div>

        <!-- Right Carousel -->
        <div class="carousel-container">
            <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/lccMain.JPG') }}" alt="School" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/lccIntrams.jpg') }}" alt="Intrams" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/lccCriminology.jpg') }}" alt="BSCRIM" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/lccBstm.jpg') }}" alt="BSTM" class="d-block w-100">
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} LCC-OSAS. All Rights Reserved.
    </footer>

    <script src="{{ asset('user/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>