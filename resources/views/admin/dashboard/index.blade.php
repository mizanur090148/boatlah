@extends('admin.layout')


@section('header')
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/flag-icon-css/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/chartist-js/chartist.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet"
          href="{{ asset('admin/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('admin/global/fonts/weather-icons/weather-icons.css') }}">
@endsection
@section('content')

    <div class="page-content padding-30 container-fluid">
        <div class="row" data-plugin="matchHeight" data-by-row="true">
            <div class="col-xlg-3 col-md-6">

                <div class="widget widget-shadow" id="widgetTable">
                    <div class="widget-body padding-30">
                        <h3 class="widget-title">
                            <span class="text-truncate">Boatlah User Statistics</span>
                        </h3>
                        <form class="margin-top-25" action="#" role="search">
                            <div class="input-search input-search-dark">
                                <i class="input-search-icon wb-search" aria-hidden="true"></i>
                                <input type="text" class="form-control" placeholder="Search.."/>
                            </div>
                        </form>
                    </div>
                    <table class="table margin-bottom-0">
                        <tbody>
                        <tr>
                            <td>Total User</td>
                            <td>{{$userCount}}</td>
                        </tr>
                        <tr>
                            <td>Admin</td>
                            <td>{{$adminCount}}</td>
                        </tr>
                        <tr>
                            <td>Boat Owner</td>
                            <td>{{$ownerCount}}</td>
                        </tr>
                        <tr>
                            <td>Boat Captain</td>
                            <td>{{$captainCount}}</td>
                        </tr>
                        <tr>
                            <td>Boat Coordinator</td>
                            <td>{{$coordinatorCount}}</td>
                        </tr>
                        <tr>
                            <td>Call Center Representative</td>
                            <td>{{$csrCount}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="col-xlg-3 col-md-6">
                <div class="widget widget-shadow" id="widgetLinepointDate">
                    <div class="widget-body padding-30">
                        <h3 class="widget-title">BoatLah User Analysis</h3>
                        <div class="row text-center margin-vertical-25">
                            <div class="col-xs-4">
                                <div class="counter">
                                    <div class="counter-label">TOTAL</div>
                                    <div class="counter-number red-600">20,1</div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="counter">
                                    <div class="counter-label">TODAY</div>
                                    <div class="counter-number red-600">3</div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="counter">
                                    <div class="counter-label">WEEK</div>
                                    <div class="counter-number red-600">261</div>
                                </div>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer
                            nec odio. Praesent libero.</p>
                    </div>
                    <div class="ct-chart height-150"></div>
                </div>

            </div>
            <div class="col-xlg-7 col-md-7">
                <div class="widget widget-shadow widget-responsive" id="widgetLineareaColor">
                    <div class="widget-content">
                        <div class="padding-top-30 padding-30" style="height:calc(100% - 250px);">
                            <div class="row">
                                <div class="col-xs-7">
                                    <p class="font-size-20 blue-grey-700">Energy Predictions</p>

                                    <p>Quisque volutpat condimentum velit. Class aptent taciti</p>

                                    <div class="counter counter-md text-left">
                                        <div class="counter-number-group">
                                            <span class="counter-icon red-600"><i class="icon wb-triangle-up"
                                                                                  aria-hidden="true"></i></span>
                                            <span class="counter-number red-600">2,250</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="pull-right clearfix">
                                        <ul class="list-unstyled">
                                            <li class="margin-bottom-5 text-truncate">
                                                <i class="icon wb-medium-point red-600 margin-right-5"
                                                   aria-hidden="true"></i> Diretary intake
                                            </li>
                                            <li class="margin-bottom-5 text-truncate">
                                                <i class="icon wb-medium-point orange-600 margin-right-5"
                                                   aria-hidden="true"></i> Motion
                                            </li>
                                            <li class="margin-bottom-5 text-truncate">
                                                <i class="icon wb-medium-point green-600 margin-right-5"
                                                   aria-hidden="true"></i> Other
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ct-chart height-250"></div>
                    </div>
                </div>
            </div>
            <div class="col-xlg-5 col-md-5">
                <div class="widget widget-shadow" id="widgetStackedBar">
                    <div class="widget-content">
                        <div class="padding-30 height-150">
                            <p>MARKET DOW</p>

                            <div class="red-600">
                                <i class="wb-triangle-up font-size-20 margin-right-5"></i>
                                <span class="font-size-30">26,580.62</span>
                            </div>
                        </div>
                        <div class="counters padding-bottom-20 padding-horizontal-30"
                             style="height:calc(100% - 350px);">
                            <div class="row no-space">
                                <div class="col-xs-4">
                                    <div class="counter counter-sm">
                                        <div class="counter-label text-uppercase">APPL</div>
                                        <div class="counter-number-group text-truncate">
                                            <span class="counter-number-related green-600">+</span>
                                            <span class="counter-number green-600">82.24</span>
                                            <span class="counter-number-related green-600">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="counter counter-sm">
                                        <div class="counter-label text-uppercase">FB</div>
                                        <div class="counter-number-group text-truncate">
                                            <span class="counter-number-related red-600">-</span>
                                            <span class="counter-number red-600">12.06</span>
                                            <span class="counter-number-related red-600">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="counter counter-sm">
                                        <div class="counter-label text-uppercase">GOOG</div>
                                        <div class="counter-number-group text-truncate">
                                            <span class="counter-number-related green-600">+</span>
                                            <span class="counter-number green-600">24.86</span>
                                            <span class="counter-number-related green-600">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ct-chart height-200"></div>
                    </div>
                </div>
            </div>
            <div class="col-xlg-8 col-md-12">
                <div class="widget widget-shadow" id="widgetStatistic">
                    <div class="widget-content">
                        <div class="row no-space height-full" data-plugin="matchHeight">
                            <div class="col-sm-8 col-xs-12">
                                <div id="widgetJvmap" class="height-full"></div>
                            </div>
                            <div class="col-sm-4 col-xs-12 padding-30">
                                <div class="form-group">
                                    <div class="input-search input-search-dark">
                                        <i class="input-search-icon wb-search" aria-hidden="true"></i>
                                        <input type="text" class="form-control" name="" placeholder="Search...">
                                    </div>
                                </div>
                                <p class="font-size-20 blue-grey-700">Statistic</p>

                                <p class="blue-grey-400">Status: live</p>

                                <p>
                                    <i class="icon wb-map blue-grey-400 margin-right-10" aria-hidden="true"></i>
                                    <span>258 Countries, 4835 Cities</span>
                                </p>
                                <ul class="list-unstyled margin-top-20">
                                    <li>
                                        <p>VISITS</p>

                                        <div class="progress progress-xs margin-bottom-25">
                                            <div class="progress-bar progress-bar-info bg-blue-600" style="width: 70.3%"
                                                 aria-valuemax="100"
                                                 aria-valuemin="0" aria-valuenow="70.3" role="progressbar">
                                                <span class="sr-only">70.3%</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <p>TODAY</p>

                                        <div class="progress progress-xs margin-bottom-25">
                                            <div class="progress-bar progress-bar-info bg-green-600"
                                                 style="width: 70.3%" aria-valuemax="100"
                                                 aria-valuemin="0" aria-valuenow="70.3" role="progressbar">
                                                <span class="sr-only">70.3%</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <p>WEEK</p>

                                        <div class="progress progress-xs margin-bottom-0">
                                            <div class="progress-bar progress-bar-info bg-purple-600"
                                                 style="width: 70.3%"
                                                 aria-valuemax="100" aria-valuemin="0" aria-valuenow="70.3"
                                                 role="progressbar">
                                                <span class="sr-only">70.3%</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xlg-4 col-md-12">
                <div class="row height-full">
                    <div class="col-xlg-12 col-md-6" style="height:50%;">

                        <div class="widget widget-shadow bg-blue-600 white" id="widgetLinepoint">
                            <div class="widget-content">
                                <div class="padding-top-25 padding-horizontal-30">
                                    <div class="row no-space">
                                        <div class="col-xs-6">
                                            <p>Today Sale's</p>

                                            <p class="blue-200">Last Sale 23.45 USD</p>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <p class="font-size-30 text-nowrap">450 USD</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="ct-chart height-120"></div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xlg-12 col-md-6" style="height:50%;">

                        <div class="widget widget-shadow bg-purple-600 white" id="widgetSaleBar">
                            <div class="widget-content">
                                <div class="padding-top-25 padding-horizontal-30">
                                    <div class="row no-space">
                                        <div class="col-xs-6">
                                            <p>Month Sale's</p>

                                            <p class="purple-200">2% higher than last month</p>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <p class="font-size-30 text-nowrap">$ 14,500</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="ct-chart height-120"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xlg-6 col-md-12">

                <div class="widget widget-shadow widget-responsive" id="widgetOverallViews">
                    <div class="widget-content padding-30">
                        <div class="row padding-bottom-30" style="height:calc(100% - 250px);">
                            <div class="col-xs-4">
                                <div class="counter counter-md text-left">
                                    <div class="counter-label">OVERALL VIEWS</div>
                                    <div class="counter-number-group text-truncate">
                                        <span class="counter-number-related red-600">$</span>
                                        <span class="counter-number red-600">432,852</span>
                                    </div>
                                    <div class="counter-label">2% higher than last month</div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="counter counter-sm text-left inline-block">
                                    <div class="counter-label">MY BALANCE</div>
                                    <div class="counter-number-group">
                                        <span class="counter-number-related">$</span>
                                        <span class="counter-number">12,346</span>
                                    </div>
                                </div>
                                <div class="ct-chart inline-block small-bar-one"></div>
                            </div>
                            <div class="col-xs-4">
                                <div class="counter counter-sm text-left inline-block">
                                    <div class="counter-label">NEW ORDERS</div>
                                    <div class="counter-number-group">
                                        <span class="counter-number-related">$</span>
                                        <span class="counter-number">17,555</span>
                                    </div>
                                </div>
                                <div class="ct-chart inline-block small-bar-two"></div>
                            </div>
                        </div>
                        <div class="ct-chart line-chart height-250"></div>
                    </div>
                </div>

            </div>
            <div class="col-xlg-6 col-md-12">

                <div class="widget widget-shadow widget-responsive" id="widgetTimeline">
                    <div class="widget-content">
                        <div class="padding-30" style="height:120px;">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="counter text-left">
                                        <div class="counter-label blue-grey-700">Total usage</div>
                                        <div class="counter-number-group">
                                            <span class="counter-number red-600">21,451</span>
                                            <span class="counter-number-related red-600">MB</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="counter text-left">
                                        <div class="counter-label">Currently</div>
                                        <div class="counter-number-group">
                                            <span class="counter-number">227.34</span>
                                            <span class="counter-number-related">KB</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="counter text-left">
                                        <div class="counter-label">Average</div>
                                        <div class="counter-number-group">
                                            <span class="counter-number">117.65</span>
                                            <span class="counter-number-related">MB</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="list-unstyled padding-bottom-50" style="height:calc(100% - 270px);">
                            <li class="padding-horizontal-30 padding-vertical-15 container-fluid">
                                <div class="row">
                                    <div class="col-xs-3">Mail App</div>
                                    <div class="col-xs-6">210,685 users are using</div>
                                    <div class="col-xs-3 green-600">227.34KB</div>
                                </div>
                            </li>
                            <li class="padding-horizontal-30 padding-vertical-15 container-fluid">
                                <div class="row">
                                    <div class="col-xs-3">Calendar</div>
                                    <div class="col-xs-6">10,685 users are using</div>
                                    <div class="col-xs-3 green-600">128.62KB</div>
                                </div>
                            </li>
                        </ul>
                        <div class="ct-chart height-150"></div>
                    </div>
                </div>

            </div>
            <div class="col-xlg-6 col-md-12">

                <div class="widget widget-shadow" id="widgetWeather">
                    <div class="widget-content">
                        <div class="row no-space height-full">
                            <div class="col-sm-7 height-full">
                                <div class="padding-35 text-center">
                                    <h4>California, Usa</h4>

                                    <p class="blue-grey-400 margin-bottom-35">MONDAY MAY 11, 2015</p>
                                    <canvas id="widgetSunny" height="60" width="60"></canvas>
                                    <div class="font-size-40 red-600">
                                        26°
                                        <span class="font-size-30">C</span>
                                    </div>
                                    <div>Sunday</div>
                                </div>
                                <div class="weather-times padding-30">
                                    <div class="row no-space text-center">
                                        <div class="col-xs-3">
                                            <div class="weather-day vertical-align">
                                                <div class="vertical-align-middle">
                                                    <div class="margin-bottom-5">12:00</div>
                                                    <i class="wi-day-cloudy font-size-24 margin-bottom-5"></i>

                                                    <div class="red-600">24°
                                                        <span class="font-size-12">C</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="weather-day vertical-align">
                                                <div class="vertical-align-middle">
                                                    <div class="margin-bottom-5">12:30</div>
                                                    <i class="wi-day-sunny font-size-24 margin-bottom-5"></i>

                                                    <div class="red-600">26°
                                                        <span class="font-size-12">C</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="weather-day vertical-align">
                                                <div class="vertical-align-middle">
                                                    <div class="margin-bottom-5">13:00</div>
                                                    <i class="wi-day-sunny font-size-24 margin-bottom-5"></i>

                                                    <div class="red-600">28°
                                                        <span class="font-size-12">C</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="weather-day vertical-align">
                                                <div class="vertical-align-middle">
                                                    <div class="margin-bottom-5">13:30</div>
                                                    <i class="wi-day-sunny font-size-24 margin-bottom-5"></i>

                                                    <div class="red-600">30°
                                                        <span class="font-size-12">C</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 bg-blue-grey-100 height-full">
                                <div class="weather-list">
                                    <ul class="list-unstyled margin-0">
                                        <li class="container-fluid">
                                            <div class="row no-space">
                                                <div class="col-xs-4">
                                                    SUN
                                                </div>
                                                <div class="col-xs-4">
                                                    <i class="wi-day-cloudy font-size-24"></i>
                                                </div>
                                                <div class="col-xs-4">
                                                    24 - 26
                                                </div>
                                            </div>
                                        </li>
                                        <li class="container-fluid">
                                            <div class="row no-space">
                                                <div class="col-xs-4">
                                                    SUN
                                                </div>
                                                <div class="col-xs-4">
                                                    <i class="wi-day-cloudy font-size-24"></i>
                                                </div>
                                                <div class="col-xs-4">
                                                    24 - 26
                                                </div>
                                            </div>
                                        </li>
                                        <li class="container-fluid">
                                            <div class="row no-space">
                                                <div class="col-xs-4">
                                                    SUN
                                                </div>
                                                <div class="col-xs-4">
                                                    <i class="wi-day-cloudy font-size-24"></i>
                                                </div>
                                                <div class="col-xs-4">
                                                    24 - 26
                                                </div>
                                            </div>
                                        </li>
                                        <li class="container-fluid">
                                            <div class="row no-space">
                                                <div class="col-xs-4">
                                                    SUN
                                                </div>
                                                <div class="col-xs-4">
                                                    <i class="wi-day-cloudy font-size-24"></i>
                                                </div>
                                                <div class="col-xs-4">
                                                    24 - 26
                                                </div>
                                            </div>
                                        </li>
                                        <li class="container-fluid">
                                            <div class="row no-space">
                                                <div class="col-xs-4">
                                                    SUN
                                                </div>
                                                <div class="col-xs-4">
                                                    <i class="wi-day-cloudy font-size-24"></i>
                                                </div>
                                                <div class="col-xs-4">
                                                    24 - 26
                                                </div>
                                            </div>
                                        </li>
                                        <li class="container-fluid">
                                            <div class="row no-space">
                                                <div class="col-xs-4">
                                                    SUN
                                                </div>
                                                <div class="col-xs-4">
                                                    <i class="wi-day-cloudy font-size-24"></i>
                                                </div>
                                                <div class="col-xs-4">
                                                    24 - 26
                                                </div>
                                            </div>
                                        </li>
                                        <li class="container-fluid">
                                            <div class="row no-space">
                                                <div class="col-xs-4">
                                                    SUN
                                                </div>
                                                <div class="col-xs-4">
                                                    <i class="wi-day-cloudy font-size-24"></i>
                                                </div>
                                                <div class="col-xs-4">
                                                    24 - 26
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop

@section('footer')

    <script src="{{asset('admin/global/vendor/chartist-js/chartist.min.js') }}"></script>
    <script src="{{asset('admin/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{asset('admin/global/vendor/as    pieprogress/jquery-asPieProgress.min.js') }}"></script>
@endsection