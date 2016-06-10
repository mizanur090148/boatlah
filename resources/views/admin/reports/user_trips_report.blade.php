@extends('admin.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/datatables-fixedheader/dataTables.fixedHeader.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/datatables-responsive/dataTables.responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/tables/datatable.css') }}">
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title"><i class="site-menu-icon fa-user" aria-hidden="true"></i> Reports</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li class="active"><a href="#">Reports</a></li>
        </ol>
        <div class="page-header-actions">
            {{Form::open(array('url'=>'/admin/dashboard/user_reports/download_xlxs/'.$user_id))}}
            <input type="hidden" name="from" value="{{$from}}">
            <input type="hidden" name="to" value="{{$to}}">
            <button type="submit" class="btn btn-link">XLXS</button>
            {{Form::close()}}
        </div>
        <div class="col-lg-4 col-sm-6">
            <!-- Example Delay -->

            <!-- End Example Delay -->
        </div>
    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Panel Summary Mode -->
                <div class="panel">
                    <div class="padel-box-body">

                        {{Form::open(array('url'=>'/admin/dashboard/user_reports_post/'.$user_id, 'files'=>true,'class'=>'form-horizontal'))}}

                        <table class="table table-report-date">
                            <tbody>
                            <tr>
                                <td colspan="2"></td>
                                <td>
                                    <div class="input-group mb-20">
                                        <span class="input-group-addon" id="dtoday">Today's Date:</span>
                                        <div class="today-date">{{date('d/m/Y')}}</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group  <?php if($errors->first('from')!=null) echo "has-error"?>">
                                        <span class="input-group-addon" id="tfrom">From:</span>
                                        <input type="text" class="form-control datepicker" name="from" placeholder="01/01/2016" value="{{\Illuminate\Support\Facades\Input::old('from',$from)}}">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group <?php if($errors->first('to')!=null) echo "has-error"?>">
                                        <span class="input-group-addon" id="dto">To:</span>
                                        <input type="text" class="form-control datepicker" name="to" placeholder="01/01/2016" value="{{\Illuminate\Support\Facades\Input::old('to',$to)}}">
                                    </div>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-info btn-block">Show Report</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        {{Form::close()}}

                        @if($trips!='[]')
                            <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
                                <thead>
                                <tr>
                                    <th>Owner Name</th>
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
                                <?php $total = 0;?>
                                @foreach($trips as $trip)
                                    <tr>
                                        <td>{{$trip->owner->name}}</td>
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
                                        <?php $total += $trip->cost;?>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td colspan="4"></td>
                                    <td>{{sprintf('%0.2f', $total)}}</td>
                                </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                <!-- End Panel Summary Mode -->
            </div>
        </div>

    </div>

@stop

@section('footer')

    <script src="{{asset('admin/global/vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{asset('admin/global/vendor/datatables-fixedheader/dataTables.fixedHeader.js') }}"></script>
    <script src="{{asset('admin/global/vendor/datatables-bootstrap/dataTables.bootstrap.js') }}"></script>
    <script src="{{asset('admin/global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{asset('admin/global/vendor/datatables-tabletools/dataTables.tableTools.js') }}"></script>

    <script src="{{asset('admin/global/js/components/datatables.js') }}"></script>
    <script src="{{asset('admin/assets/examples/js/tables/datatable.js') }}"></script>
    <script>
        (function(document, window, $) {
            'use strict';
            var Site = window.Site;
            $(document).ready(function() {
                Site.run();
            });
        })(document, window, jQuery);
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myCompany').DataTable();

            $('.datatable').DataTable();
            $('.account-datatable').DataTable();

        });
    </script>
@endsection
