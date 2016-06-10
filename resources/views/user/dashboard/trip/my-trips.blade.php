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
                <!-- sidebar wrapper -->
                                <div class="col-md-9 xol-sm-8">
                                    <div class="block-wrapper">
                                        <div class="block account-block padel-box padel-trip" style="background:#fff;">
                                            <div class="header-bar padel-box-header">
                                                <h4 class="clearfix padel-title"><i class="fa fa-ship"></i>My Trips </h4>
                                            </div>
                                            <div class="padel-box-body">

                                                <div role="tabpanel">
                                                    <ul class="nav nav-pills nav-justified nav-trip" role="tablist">
                                                        <li class="active" role="presentation"><a href="#upcoming" aria-controls="upcoming" role="tab" data-toggle="tab">Upcoming</a></li>
                                                        <li role="presentation"><a href="#ongoing" aria-controls="ongoing" role="tab" data-toggle="tab">Ongoing </a></li>
                                                        <li role="presentation"><a href="#complete" aria-controls="complete" role="tab" data-toggle="tab">Completed</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="upcoming">
                                                            <table class="display table dtable-default table-xpadd">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Trip ID</th>
                                                                        <th>Boat</th>
                                                                        <th>Captain</th>
                                                                        <th>Start Point</th>
                                                                        <th>Destination</th>
                                                                        <th>Cost</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($trips as $trip)
                                                                @if($trip->status=='upcoming')
                                                                    <tr>
                                                                        <td>{{$trip->trip_id}}</td>
                                                                        <td>{{$trip->boat->name}}</td>
                                                                        <td>{{$trip->captain->name}}</td>
                                                                        <td>{{$trip->start->title}}</td>
                                                                        <td>{{$trip->destination->title}}</td>
                                                                        <td>{{$trip->cost}} SGD</td>
                                                                    </tr>
                                                                    @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div role="tabpanel" class="tab-pane" id="ongoing">
                                                            <table class="display table dtable-default table-xpadd">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Trip ID</th>
                                                                        <th>Boat</th>
                                                                        <th>Captain</th>
                                                                        <th>Start Point</th>
                                                                        <th>Destination</th>
                                                                        <th>Cost</th>
                                                                        <th>Started At</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($trips as $trip)
                                                                @if($trip->status=='ongoing')
                                                                    <tr>
                                                                        <td>{{$trip->trip_id}}</td>
                                                                        <td>{{$trip->boat->name}}</td>
                                                                        <td>{{$trip->captain->name}}</td>
                                                                        <td>{{$trip->start->title}}</td>
                                                                        <td>{{$trip->destination->title}}</td>
                                                                        <td>{{$trip->cost}} SGD</td>
                                                                        <td>{{ date('Y-m-d H:i:s', $trip->started_at) }}</td>
                                                                    </tr>
                                                                    @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div role="tabpanel" class="tab-pane" id="complete">
                                                            <table class="display table dtable-default table-xpadd">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Trip ID</th>
                                                                        <th>Boat</th>
                                                                        <th>Captain</th>
                                                                        <th>Start Point</th>
                                                                        <th>Destination</th>
                                                                        <th>Cost</th>
                                                                        <th>Payment</th>
                                                                        <th>Collected By</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($trips as $trip)
                                                                @if($trip->status=='completed')
                                                                    <tr>
                                                                        <td>{{$trip->trip_id}}</td>
                                                                        <td>{{$trip->boat->name}}</td>
                                                                        <td>{{$trip->captain->name}}</td>
                                                                        <td>{{$trip->start->title}}</td>
                                                                        <td>{{$trip->destination->title}}</td>
                                                                        <td>{{$trip->cost}} SGD</td>
                                                                        <?php $invoice = null;
                                                                        $invoice = \App\Invoice::where('trip_id','=',$trip->id)->first();?>
                                                                        @if($invoice!=null)
                                                                            <td><a href="{{url('/trip_invoice/download/'.$trip->id)}}">Invoice</a></td>
                                                                        @else
                                                                            <td>Cash</td>
                                                                        @endif
                                                                        <td>{{$trip->collected_user_type}}</td>
                                                                    </tr>
                                                                @endif
                                                                @endforeach
                                                                </tbody>
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
                                </div>
                                <!-- boat-list wrapper -->
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