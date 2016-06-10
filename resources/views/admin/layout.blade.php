<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">
    <title>Dashboard | Boatlah</title>
    <link rel="apple-touch-icon" href="{{ asset('admin/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.ico') }}">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('admin/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/css/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/site.min.css') }}">
    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/animsition/animsition.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/switchery/switchery.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/intro-js/introjs.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/slidepanel/slidePanel.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/fonts/material-design/material-design.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/fonts/font-awesome/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/dashboard/v1.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/custom/td-button.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/fonts/web-icons/web-icons.min.css') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

    <!--[if lt IE 9]>
    <script src="../../global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
    <!--[if lt IE 10]>
    <script src="../../global/vendor/media-match/media.match.min.js"></script>
    <script src="../../global/vendor/respond/respond.min.js"></script>
    <![endif]-->
    <!-- Scripts -->
    <script src="{{ asset('admin/global/vendor/modernizr/modernizr.js') }}"></script>
    <script src="{{ asset('admin/global/vendor/breakpoints/breakpoints.js') }}"></script>
    <script>
        Breakpoints();
    </script>
    @yield('header')
</head>

<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="dashboard">
<!-- BEGIN HEADER -->
@include('admin.top_nav')
        <!-- BEGIN SIDEBAR -->
@include('admin.sidebar')
        <!-- END SIDEBAR -->
<div class="page animsition">
@if(Session::has('success'))

        <div class="summary-errors alert alert-success alert-dismissible" style="display: block;">
            <button data-dismiss="alert" aria-label="Close" class="close" type="button">
                <span aria-hidden="true">×</span>
            </button><p>{{Session::get('success')}}</p>
        </div>


        @endif

    @if(Session::has('error'))

        <div class="summary-errors alert alert-danger alert-dismissible" style="display: block;">
            <button data-dismiss="alert" aria-label="Close" class="close" type="button">
                <span aria-hidden="true">×</span>
            </button><p>{{Session::get('error')}}</p>
        </div>


        @endif

<!-- BEGIN CONTENT -->
@yield('content')

</div>
        <!-- END CONTENT -->

<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
@include('admin.footer')
@include('admin.master_footer')
@yield('footer')

</body>
<!-- END BODY -->
</html>
