<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Inventory Management System | @yield('title')</title>
        <!-- Custom fonts for this template-->
        <link href="{{asset('/assets/dashboard/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/ss?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="{{asset('/assets/dashboard/css/sb-admin-2.min.css')}}" rel="stylesheet">
        @yield('page-css-link')
        @yield('page-css')
    </head>
    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            @include('dashboard.includes.sidebar')
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    @include('dashboard.includes.header')
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        @yield('main-content')
                    </div>
                </div>
                @include('dashboard.includes.footer')
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="{{asset('/assets/dashboard/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('/assets/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- Core plugin JavaScript-->
        <script src="{{asset('/assets/dashboard/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{asset('/assets/dashboard/js/sb-admin-2.min.js')}}"></script>
        <!-- Page level plugins -->
        <script src="{{asset('/assets/dashboard/vendor/chart.js/Chart.min.js')}}"></script>
        <!-- Page level custom scripts -->
        <script src="{{asset('/assets/dashboard/js/demo/chart-area-demo.js')}}"></script>
        <script src="{{asset('/assets/dashboard/js/demo/chart-pie-demo.js')}}"></script>
        @yield('page-js-link')
        @yield('page-js')
    </body>
</html>