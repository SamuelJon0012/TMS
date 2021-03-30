<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon-sp.png') }}">
    <title>{{__('app.mail.appname')}}</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets_2/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets_2/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets_2/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets_2/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    @yield('styles')
    <!-- Core JS files -->
    <script src="{{ asset('global_assets/js/main/jquery.min.js')}}"></script>
    <script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <script src="{{ asset('global_assets/js/plugins/ui/ripple.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

    <script src="{{ asset('assets_2/js/app.js')}}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/login.js')}}"></script>
    <!-- /theme JS files -->
    @if(isset(Auth()->user()->locale) && Auth()->user()->locale!='en')
        <link href="{{ asset('assets_2/css/rtl.css') }}" rel="stylesheet" type="text/css">
    @endif
    @yield('scripts')
</head>

<body class="bg-slate-800">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content d-flex justify-content-center align-items-center">

                <!-- Login card -->
                @yield('content')
                <!-- /login card -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</body>

</html>