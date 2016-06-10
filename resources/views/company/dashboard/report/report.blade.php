@extends('user.layout')

@section('title')
    Company Dashboard
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
            @include('company.dashboard.common.breadcrumb')
            <!-- breadcrumbs -->
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('company.dashboard.common.sidemenu')
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
                                                {{Form::open(array('url'=>'/company/dashboard/report/download_xlxs'))}}
                                                <input type="hidden" name="type" value="{{$type}}">
                                                <input type="hidden" name="id" value="{{$id}}">
                                                <button type="submit" class="btn btn-link">XLXS</button>
                                                {{Form::close()}}
                                            </li>
                                        </ul>
                                    </div>
                                </h4>
                            </div>
                            <div class="padel-box-body">

                                {{Form::open(array('url'=>'/company/dashboard/report_post', 'files'=>true,'class'=>'form-horizontal'))}}

                                <div class="form-group">
                                    <label class="control-label col-sm-3">Type</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="btn-group filter-srcbtn-group" data-toggle="buttons">
                                                    <a href="#east-zone" data-toggle="tab" class="btn btn-info @if(\Illuminate\Support\Facades\Input::old('options',$type)!='2') active @endif">
                                                        <input type="radio" name="options" id="option1" autocomplete="off" value="1" @if(\Illuminate\Support\Facades\Input::old('options',$type)!='2') checked @endif> By Trips
                                                    </a>
                                                    <a href="#west-zone" data-toggle="tab" class="btn btn-info @if(\Illuminate\Support\Facades\Input::old('options',$type)=='2') active @endif">
                                                        <input type="radio" name="options" id="option2" autocomplete="off" value="2" @if(\Illuminate\Support\Facades\Input::old('options',$type)=='2') checked @endif> By Employee
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
                                                <select class="form-control east-destination chosen" data-placeholder="" name="anchorage_id">
                                                    <?php if($type=='1') $anchorage_id = $id; else $anchorage_id=null;?>
                                                    @foreach($anchorages as $anchorage)
                                                    <option value="{{$anchorage->id}}" @if(\Illuminate\Support\Facades\Input::old('anchorage_id',$anchorage_id)==$anchorage->id) selected @endif>{{$anchorage->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- tab-pane -->
                                    <div class="tab-pane fade @if(\Illuminate\Support\Facades\Input::old('options',$type)=='2') in active @endif" id="west-zone">
                                        <div class="form-group">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <select class="form-control east-destination chosen" data-placeholder="By Customer" name="employee_id">
                                                    <?php if($type=='2') $employee_id = $id; else $employee_id=null;?>
                                                    @foreach($employees as $employee)
                                                        <option value="{{$employee->user_id}}"  @if(\Illuminate\Support\Facades\Input::old('employee_id',$employee_id)==$employee->user_id) selected @endif>{{$employee->user->name}}</option>
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
                                    <table class="table table-bordered">
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