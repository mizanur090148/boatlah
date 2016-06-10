@extends('user.layout')

@section('title')
    Owner Dashboard
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.1.0/css/select.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css">
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            @include('owner.dashboard.common.breadcrumb')
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('owner.dashboard.common.sidemenu')
                        </div><!-- widget -->
                    </div><!-- sidebar -->
                </div><!-- sidebar wrapper -->
                <div class="col-md-9 xol-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-ship"></i> My Bookings</h4>
                            </div>
                            <div class="padel-box-body">

                                <div role="tabpanel">
                                    <ul class="nav nav-pills nav-justified nav-trip" role="tablist">
                                        <li class="active" role="presentation"><a href="#pending" aria-controls="pending" role="tab" data-toggle="tab">Upcoming</a></li>
                                        <li role="presentation"><a href="#approved" aria-controls="approved" role="tab" data-toggle="tab">Ongoing </a></li>
                                    </ul>
                                    <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="pending">
                                                <table class="display table dtable-default table-xpadd">
                                                        <thead>
                                                        <tr>
                                                            <th>Trip Id</th>
                                                            <th>Start Point</th>
                                                            <th>Destination Point</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                        </thead>
                                                    <tbody>
                                                    @if($upcoming_booking_lists!='[]')
                                                    @foreach($upcoming_booking_lists as $upcoming_booking_list)
                                                        <tr>
                                                            <td>{{$upcoming_booking_list->trip_id}}</td>
                                                            <td>{{$upcoming_booking_list->start->title}}</td>
                                                            <td>{{$upcoming_booking_list->destination->title}}</td>
                                                            <td>{{$upcoming_booking_list->cost}}</td>
                                                      </tr>
                                                    @endforeach
                                                    @endif
                                                </table>
                                            </div>
                                        <div role="tabpanel" class="tab-pane" id="approved">
                                            <table class="display table dtable-default table-xpadd">
                                                <thead>
                                                <tr>
                                                    <th>Trip Id</th>
                                                    <th>Start Point</th>
                                                    <th>Destination Point</th>
                                                    <th>Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($ongoing_booking_lists!='[]')
                                                @foreach($ongoing_booking_lists as $ongoing_booking_list)
                                                <tr>
                                                    <td>{{$ongoing_booking_list->trip_id}}</td>
                                                    <td>{{$ongoing_booking_list->start->title}}</td>
                                                    <td>{{$ongoing_booking_list->destination->title}}</td>
                                                    <td>{{$ongoing_booking_list->cost}}</td>
                                             </tr>
                                                @endforeach
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- block about-block -->
                    </div>
                    <!-- block-wrapper -->
                    <div class="clearfix"></div>
                </div><!-- boat-list wrapper -->
            </div><!-- row -->
        </div><!-- container -->
    </section>
@stop

@section('footer_scripts')
    <script type="text/javascript" charset="utf8" src="/plugins/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myCompany').DataTable();

            $('.datatable').DataTable();
            $('.account-datatable').DataTable();

        });
    </script>
@stop