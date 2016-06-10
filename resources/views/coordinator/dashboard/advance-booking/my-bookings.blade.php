@extends('user.layout')

@section('title')
    Coordinator Dashboard
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
            @include('coordinator.dashboard.common.breadcrumb')
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('coordinator.dashboard.common.sidemenu')
                        </div><!-- widget -->
                    </div><!-- sidebar -->
                </div><!-- sidebar wrapper -->
                <div class="col-md-9 xol-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-bookmark"></i> My Advance Bookings</h4>
                            </div>
                            <div class="padel-box-body">

                                <div role="tabpanel">
                                    <ul class="nav nav-pills nav-justified nav-trip" role="tablist">
                                        <li class="active" role="presentation"><a href="#pending" aria-controls="pending" role="tab" data-toggle="tab">Pending</a></li>
                                        <li role="presentation"><a href="#approved" aria-controls="approved" role="tab" data-toggle="tab">Approved </a></li>
                                    </ul>
                                    <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="pending">
                                                <table class="display table dtable-default table-xpadd">
                                                        <thead>
                                                        <tr>
                                                            <th>Booking Id</th>
                                                            <th>Start Point</th>
                                                            <th>Destination Point</th>
                                                            <th>Date Time</th>
                                                            <th>Trip Type</th>
                                                            <th>Number Of Boats</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                    <tbody>
                                                    @if($pending_booking_lists!='[]')
                                                    @foreach($pending_booking_lists as $pending)
                                                        <tr>
                                                            <td>{{$pending->booking_id}}</td>
                                                            <td>{{$pending->start->title}}</td>
                                                            <td>{{$pending->destination->title}}</td>
                                                            <td>{{$pending->booking_date}} {{$pending->booking_time}}</td>
                                                            <td>{{$pending->trip_type}}</td>
                                                            <td>{{$pending->number_of_boats}}</td>
                                                            <td><a href="/coordinator/dashboard/approve/{{$pending->id}}" class="btn btn-primary">Approve</a></td>
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                </table>
                                            </div>
                                        <div role="tabpanel" class="tab-pane" id="approved">
                                            <table class="display table dtable-default table-xpadd">
                                                <thead>
                                                <tr>
                                                    <th>Booking Id</th>
                                                    <th>Start Point</th>
                                                    <th>Destination Point</th>
                                                    <th>Date time</th>
                                                    <th>Trip Type</th>
                                                    <th>Number Of Boats</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($approved_booking_lists!='[]')
                                                @foreach($approved_booking_lists as $approved)
                                                <tr>
                                                    <td>{{$approved->booking_id}}</td>
                                                    <td>{{$approved->start->title}}</td>
                                                    <td>{{$approved->destination->title}}</td>
                                                     <td>{{$approved->booking_date}} {{$approved->booking_time}}</td>
                                                    <td>{{$approved->trip_type}}</td>
                                                    <td>{{$approved->number_of_boats}}</td>
                                                    <td><a href="{{url('coordinator/dashboard/my-advance-bookings/book/'.$approved->id)}}">Book Now</a></td>
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