@extends('user.layout')

@section('title')
    User Dashboard
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
            <!-- breadcrumbs -->
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('user.dashboard.common.sidemenu')
                            <!-- side-menu -->
                        </div>
                        <!-- widget -->
                    </div>
                    <!-- sidebar -->
                </div>
                <!-- sidebar wrapper -->
                <div class="col-md-9 xol-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-file-excel-o"></i> Reports 
                                    <div class="dropdown pull-right ">
                                      <a id="dwonloadReport" data-target="#" href="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        Download Report
                                        <span class="caret"></span>
                                      </a>
                                      <ul class="dropdown-menu" aria-labelledby="dwonloadReport">
                                          <li>
                                              {{Form::open(array('url'=>'/user/dashboard/report/download_xlxs'))}}
                                              <input type="hidden" name="from" value="{{$from}}">
                                              <input type="hidden" name="to" value="{{$to}}">
                                              <button type="submit" class="btn btn-link">XLXS</button>
                                              {{Form::close()}}
                                          </li>
                                      </ul>
                                    </div>
                                </h4>
                            </div>
                            <div class="padel-box-body">

                            {{Form::open(array('url'=>'/user/dashboard/report_post', 'files'=>true,'class'=>'form-horizontal'))}}
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
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Owner Name</th>
                                            <th>Trip ID</th>
                                            <th>PickUp Point</th>
                                            <th>Drop-off Point</th>
                                            <th>Invoice No.</th>
                                            <th>Date of Invoice</th>
                                            <th>Collected User Type</th>
                                            <th>Payment Method</th>
                                            <th>Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $total = 0;?>
                                        @foreach($trips as $trip)
                                            <tr>
                                                <td>{{$trip->owner->name}}</td>
                                                <td>{{$trip->trip_id}}</td>
                                                <td>{{$trip->start->title}}</td>
                                                <td>{{$trip->destination->title}}</td>
                                                <td>{{$trip->invoice->invoice_code}}</td>
                                                <td>{{$trip->invoice->created_at}}</td>
                                                <td>{{$trip->collected_user_type}}</td>
                                                <td>{{$trip->payment_method}}</td>
                                                <td>{{$trip->cost}}</td>
                                                <?php $total += $trip->cost;?>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td colspan="2">Total</td>
                                            <td colspan="5"></td>
                                            <td>{{sprintf('%0.2f', $total)}}</td>
                                        </tr>
                                        </tbody>
                                </table> 
                            @endif                                               
                            </div>
                        </div>
                        <!-- block about-block -->
                    </div>
                    <!-- block-wrapper -->
                    <div class="clearfix"></div>
                </div>
                <!-- boat-list wrapper -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
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