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
            {{Form::open(array('url'=>'/admin/dashboard/owner_reports/download_xlxs/'.$owner_id))}}
            <input type="hidden" name="report_type" value="{{$report_type}}">
            <input type="hidden" name="from" value="{{$from}}">
            <input type="hidden" name="to" value="{{$to}}">
            <input type="hidden" name="type" value="{{$type}}">
            <input type="hidden" name="id" value="{{$id}}">
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

                        {{Form::open(array('url'=>'/admin/dashboard/owner_reports_post/'.$owner_id, 'files'=>true,'class'=>'form-horizontal'))}}
                        <div class="form-group">
                            <label class="control-label col-sm-3">Show Reports</label>
                            <div class="col-sm-6">
                                <select id="sReports" class="form-control select-styled" name="report_type">
                                    <option value="daily" @if(\Illuminate\Support\Facades\Input::old('report_type',$report_type)=='daily') selected @endif >Today</option>
                                    <option value="yesterday" @if(\Illuminate\Support\Facades\Input::old('report_type',$report_type)=='yesterday') selected @endif >Yesterday</option>
                                    <option value="weekly" @if(\Illuminate\Support\Facades\Input::old('report_type',$report_type)=='weekly') selected @endif >This Week</option>
                                    <option value="monthly" @if(\Illuminate\Support\Facades\Input::old('report_type',$report_type)=='monthly') selected @endif >Month-to-date</option>
                                    <option value="last_month" @if(\Illuminate\Support\Facades\Input::old('report_type',$report_type)=='last_month') selected @endif >Last Month</option>
                                    <option value="yearly" @if(\Illuminate\Support\Facades\Input::old('report_type',$report_type)=='yearly') selected @endif >Year-to-date</option>
                                    <option value="custom" @if(\Illuminate\Support\Facades\Input::old('report_type',$report_type)=='custom') selected @endif >Custom</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group sr-type <?php if($errors->first('from')!=null||$errors->first('to')!=null) echo "has-error"?>">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input class="form-control cDate" id="" name="from" placeholder="From" type="text" value="{{ \Illuminate\Support\Facades\Input::old('from',$from)}}">
                                        <span class="validator_output <?php if($errors->first('from')!=null) echo "help-block"?>">{{ $errors->first('from') }}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control cDate" id="" name="to" placeholder="To" type="text"  value="{{ \Illuminate\Support\Facades\Input::old('to',$to)}}">
                                        <span class="validator_output <?php if($errors->first('to')!=null) echo "help-block"?>">{{ $errors->first('to') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Type</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="btn-group filter-srcbtn-group" data-toggle="buttons">
                                            <a href="#east-zone" data-toggle="tab" class="btn btn-info @if(\Illuminate\Support\Facades\Input::old('options',$type)!='2') active @endif">
                                                <input type="radio" name="options" id="option1" autocomplete="off" value="1" @if(\Illuminate\Support\Facades\Input::old('options',$type)!='2') checked @endif> By boat
                                            </a>
                                            <a href="#west-zone" data-toggle="tab" class="btn btn-info @if(\Illuminate\Support\Facades\Input::old('options',$type)=='2') active @endif">
                                                <input type="radio" name="options" id="option2" autocomplete="off" value="2" @if(\Illuminate\Support\Facades\Input::old('options',$type)=='2') checked @endif> By Customer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade  @if(\Illuminate\Support\Facades\Input::old('options',$type)!='2') in active @endif" id="east-zone">
                                <div class="form-group">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <select class="form-control east-destination chosen" data-placeholder="By baot" name="boat_id">
                                            <?php if($type=='1') $boat_id = $id; else $boat_id=null;?>
                                            <option value="0" @if(\Illuminate\Support\Facades\Input::old('boat_id',$boat_id)==0) selected @endif>All</option>
                                            @foreach($boats as $boat)
                                                <option value="{{$boat->id}}" @if(\Illuminate\Support\Facades\Input::old('boat_id',$boat_id)==$boat->id) selected @endif>{{$boat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- tab-pane -->
                            <div class="tab-pane fade @if(\Illuminate\Support\Facades\Input::old('options',$type)=='2') in active @endif" id="west-zone">
                                <div class="form-group">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <select class="form-control east-destination chosen" data-placeholder="By Customer" name="customer_id">
                                            <?php if($type=='2') $customer_id = $id; else $customer_id=null;?>
                                            <option value="0" @if(\Illuminate\Support\Facades\Input::old('customer_id',$customer_id)==0) selected @endif>All</option>
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->user_id}}"  @if(\Illuminate\Support\Facades\Input::old('customer_id',$customer_id)==$customer->user_id) selected @endif>{{$customer->user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- tab-pane -->
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        {{Form::close()}}

                        @if($trips!='[]')
                            <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
                                <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Trip ID</th>
                                    <th>PickUp Point</th>
                                    <th>Drop-off Point</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $total = 0;?>
                                @foreach($trips as $trip)
                                    <tr>
                                        <td>{{$trip->user->name}}</td>
                                        <td>{{$trip->trip_id}}</td>
                                        <td>{{$trip->start->title}}</td>
                                        <td>{{$trip->destination->title}}</td>
                                        <td>{{$trip->cost}}</td>
                                        <?php $total += $trip->cost;?>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td colspan="2"></td>
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('.cDate').datetimepicker({
                format: "DD/MM/YYYY"
            });
            $('.datatable').DataTable();
            $('.account-datatable').DataTable();

            (function(){
                sReportValue = document.getElementById('sReports').value;
                if(sReportValue!='custom')
                    $(".sr-type").hide();
                $('#sReports').on('change', function() {
                    if ( this.value == 'custom')
                    {
                        $(".sr-type").show();
                    }
                    else
                    {
                        $(".sr-type").hide();
                    }
                });
            })();


        });
    </script>
@endsection
