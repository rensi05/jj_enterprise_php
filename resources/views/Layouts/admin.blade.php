<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>JJ Enterprise</title>
        <link rel="shortcut icon" href="" />
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{ asset('public/admin/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('public/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('public/admin/dist/css/adminlte.min.css') }}">
        <!-- Alertify -->
        <link rel="stylesheet" href="{{ asset('public/admin/css/alertify.min.css')}}">
        <link rel="stylesheet" href="{{ asset('public/admin/css/admin-style.css')}}">
        <!--Favicon icon-->
        <link rel="icon" href="{{ asset('public/admin/images/favicon.jpeg') }}" id="fav-icon" type="image/x-icon">
        <style>
            /* body {
                font-family: 'Open Sans', sans-serif;
            } */
        </style>
        <title>{{env('APP_NAME')}}</title>
    </head>

    <body class="hold-transition login-page login-bg">
        <!-- /.content-header -->
        @yield('content')
        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="{{ asset('public/admin/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ asset('public/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('public/admin/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('public/admin/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('public/admin/js/additional-methods.min.js') }}"></script>
        <!-- Alertify -->
        <script src="{{ asset('public/admin/js/alertify.min.js')}}"></script>

        @yield('javascript')

        @if(Session::get("error"))
        <script>
            jQuery(document).ready(function () {
                alertify.set('notifier', 'position', 'top-right');
                var notification = alertify.notify('{{Session::get("error")}}', 'error', 6);
            });
        </script>
        @endif
        @if(Session::get("success"))
        <script>
            jQuery(document).ready(function () {
                alertify.set('notifier', 'position', 'top-right');
                var notification = alertify.notify('{{Session::get("success")}}', 'success', 6);
            });
        </script>
        @endif
    </body>

</html>
