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
    <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/morrisjs/morris.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link
        href="{{ asset('') }}assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

    <link href="{{ asset('') }}assets/plugins/waitme/waitMe.css" rel="stylesheet" />

    <link href="{{ asset('') }}assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />


</head>

<body>



    <div class="theme-orange">
        @include('layouts.include.page_loader')

        @include('layouts.include.header')
        @include('layouts.include.left_sidebar')
        @include('layouts.include.right_sidebar')

        <section class="content home">
            <div class="block-header">
                <div class="row">
                    {{-- <div class="col-lg-7 col-md-6 col-sm-12">
                        <h2>@yield('title')
                            <small class="text-muted">@yield('description')</small>
                        </h2>
                    </div> --}}
                    {{-- <div class="col-lg-5 col-md-6 col-sm-12">
                        <ul class="breadcrumb float-md-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i>
                                    @yield('breadcrumb01')</a>
                            </li>
                            <li class="breadcrumb-item active">@yield('breadcrumb02')</li>
                        </ul>
                    </div> --}}
                </div>
            </div>
            <div class="container-fluid">
                @yield('app-content')
            </div>
        </section>


    </div>
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}"></script>
    <script src="{{ asset('assets/js/pages/charts/jquery-knob.min.js') }}"></script>



    <script src="{{ asset('') }}assets/plugins/autosize/autosize.js"></script>
    <script src="{{ asset('') }}assets/plugins/momentjs/moment.js"></script>

    <script
        src="{{ asset('') }}assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js">
    </script>

    <script src="{{ asset('') }}assets/js/pages/forms/basic-form-elements.js"></script>


</body>

</html>
