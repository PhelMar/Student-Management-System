<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon_io/favicon.ico') }}">
    <link href="{{asset('admin/css/data-table-style.min.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/css/styles.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('admin/css/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/dataTables.bootstrap5.min.css')}}">
    <script src="{{asset('admin/js/all.js')}}" crossorigin="anonymous"></script>
    <script src="{{asset('admin/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('admin/js/dataTables.min.js')}}"></script>
    <script src="{{asset('admin/js/sweetalert2.min.js')}}"></script>
</head>

<body class="sb-nav-fixed">
    @include('layouts.guard-partials.navbar')

    <div id="layoutSidenav">

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>

            @include('layouts.guard-partials.footer')
        </div>
    </div>

    <script src="{{asset('admin/js/Chart.min.js')}}"></script>
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin/js/scripts.js')}}"></script>

</body>

</html>