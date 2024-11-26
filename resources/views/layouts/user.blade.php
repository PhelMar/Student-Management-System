<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon_io/favicon.ico') }}">
    <link href="{{asset('user/css/data-table-style.min.css')}}" rel="stylesheet" />
    <link href="{{asset('user/css/styles.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('user/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/dataTables.bootstrap5.min.css')}}">
    <script src="{{asset('user/js/all.js')}}" crossorigin="anonymous"></script>
    <script src="{{asset('user/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('user/js/dataTables.min.js')}}"></script>
    <script src="{{asset('user/js/sweetalert2.min.js')}}"></script>
</head>
<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
</style>


<body class="sb-nav-fixed">
    @include('layouts.user-partials.navbar')

    <div id="layoutSidenav">

        <div id="layoutSidenav_nav">
            @include('layouts.user-partials.sidebar')
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>

            @include('layouts.user-partials.footer')
        </div>
    </div>

    <script src="{{asset('user/js/Chart.min.js')}}"></script>
    <script src="{{asset('user/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('user/js/scripts.js')}}"></script>
    <script src="{{asset('user/js/simple-datatables.min.js')}}"></script>
    <script src="{{asset('user/js/datatables-simple-demo.js')}}"></script>

</body>

</html>