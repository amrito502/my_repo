<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title>@yield('title')</title>

    {{-- <link rel="icon" href="favicon.ico" type="image/x-icon"> --}}
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/morrisjs/morris.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/authentication.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
    </head>
<body>



        @yield('auth-content')



        <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}">
        <script src="{{ asset('assets/js/pages/index.js') }}"></script>
        <script src="{{ asset('assets/js/pages/charts/jquery-knob.min.js') }}"></script>

        <script>
            $('.showPass').on('click', function() {
                if ($('.password').attr('type') == 'password') {
                    $('.password').attr('type', 'text');
                    $('.showPass').html('<i class="fa fa-eye-slash"></i>');
                } else {
                    $('.password').attr('type', 'password');
                    $('.showPass').html('<i class="fa fa-eye"></i>');
                }
            });
        </script>

</body>
</html>
