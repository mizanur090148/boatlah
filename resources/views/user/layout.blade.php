<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BoatLah - @yield('title')</title>

    <!-- Style -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href="/plugins/slick/slick.css" rel="stylesheet">
    <link href="/plugins/slick/slick-theme.css" rel="stylesheet">
    <link href="/css/chosen.css" rel="stylesheet">
    <link href="/plugins/date-time/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="/plugins/alertify/alertify.core.css" rel="stylesheet">
    <link href="/plugins/alertify/alertify.default.css" rel="stylesheet">

    @yield('header_styles')

    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/js/vendor/jquery-1.11.2.min.js"></script>

    <script src="/js/modernizr.custom.js"></script>
</head>
<body class="page-home" data-spy="scroll" data-target="#bs-example-navbar-collapse-1" data-offset="100">
	<!-- Header section -->
	@include('user.common_header')
	<div class="layout-wrapper">
		<div class="main-container">
			
            @if(!isset($fullpage))
			<div class="page-content-wrapper">
				<div class="bg-layer"></div>
                @yield('content')
			</div><!-- page-content-wrapper -->
            @else
                @yield('content')
            @endif
			
			<!-- Footer section -->
			@include('user.common_footer')
			
		</div><!-- main-container -->
	</div><!-- layout-wrapper -->
	
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<script src="/js/vendor/bootstrap.min.js"></script>
<script type="text/javascript" src="/plugins/slick/slick.min.js"></script>

<script type="text/javascript" src="/js/chosen.jquery.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script type="text/javascript" src="/plugins/date-time/bootstrap-datetimepicker.min.js"></script>
<script src="/js/classie.js"></script>

<script src="/plugins/alertify/alertify.min.js"></script>

@if(Session::has('success'))
    <script>
        $(document).ready(function() {
            alertify.success('<?=Session::get("success")?>');
        });
    </script>
@endif

@if(Session::has('error'))
    <script>
        $(document).ready(function() {
            alertify.error('<?=Session::get("error")?>');
        })
    </script>
@endif

@yield('footer_scripts')

<script src="/js/script.js"></script>

</body>
</html>