@extends('user.layout')

@section('title')
    user Dashboard
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
            @include('user.dashboard.common.breadcrumb')
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('user.dashboard.common.sidemenu')
                        </div><!-- widget -->
                    </div><!-- sidebar -->
                </div><!-- sidebar wrapper -->
                <div class="col-md-9 xol-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-bookmark"></i> My Advance Bookings
                                </h4>
                            </div>
                            <div class="padel-box-body">
                                    <div class="table-holder">
                                        <table id="myCompany" class="display table dtable-default table-xpadd">
                                            <thead class="hide">
                                            <tr>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($booking_lists as $booking_list)
                                                <tr>
                                                    <td>
                                                        <div class="company-binfo booklist-info">

                                                            {{--<div class="com-thumb">--}}
                                                                {{--<img class="img-responsive" src="{{$booking_list->photo}}" alt="img">--}}
                                                            {{--</div>--}}
                                                            <div class="com-note relative">
                                                                <span class="label label-warning booklist-status">{{$booking_list->status}}</span>
                                                                <h5 class="text-uppercase title">Booking Id : <a href="">{{$booking_list->booking_id}}</a></h5>

                                                                <ul class="list-unstyled bookings-ilist">
                                                                    <li>
                                                                        <span>Zone</span> 
                                                                        <span>:</span> 
                                                                        <span>{{$booking_list->start->type}}</span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Trip Type</span> 
                                                                        <span>:</span> 
                                                                        <span>{{$booking_list->trip_type}}</span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Boat Type</span> 
                                                                        <span>:</span> 
                                                                        <span>{{$booking_list->boat_type}}</span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Number Of Boats</span> 
                                                                        <span>:</span> 
                                                                        <span>{{$booking_list->number_of_boats}}</span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Start Point</span> 
                                                                        <span>:</span> 
                                                                        <span>{{$booking_list->start->title}}</span>
                                                                    </li>
                                                                    <li>
                                                                        <span>Destination Point</span> 
                                                                        <span>:</span> 
                                                                        <span>{{$booking_list->destination->title}}</span>
                                                                    </li>
                                                                </ul>

                                                                @if($booking_list->status=='pending')
                                                                 <div>
                                                                    <span class="btn btn-warning hide">{{$booking_list->status}}</span>
                                                                     <a class="btn btn-info btn-rsend" href="{{url('/user/dashboard/advance-booking/resent/'.$booking_list->id)}}">Re-Send <i class="fa fa-angle-right"></i></a>
                                                                 </div>
                                                                    @else
                                                                    <p>
                                                                        Status : {{$booking_list->status}}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
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