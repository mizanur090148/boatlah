@extends('admin.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/formvalidation/formValidation.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/forms/validation.css') }}">
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title"><i class="site-menu-icon fa-user" aria-hidden="true"></i> Reports</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li class="active"><a href="#">Reports</a></li>
        </ol>
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
                    <div class="panel-body">
                        {{Form::open(array('url'=>'/admin/reports/owner_reports_post', 'files'=>true,'id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal'))}}

                        <div class="form-group form-material <?php if($errors->first('name')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Owner Name</label>
                            <div class="col-sm-7">
                               <select class="form-control" name="name">
                                    <option value="">Select Owner</option>
                                    @foreach($owners as $owner)
                                        <option value="{{$owner->user_id}}">{{$owner->user->name}} ({{$owner->user->email}})</option>
                                     @endforeach
                                </select>
                                <span class="validator_output <?php if($errors->first('name')!=null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary" id="validateButton3">Go To Owner Report</button>
                           </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
                <!-- End Panel Summary Mode -->
            </div>
        </div>

    </div>

@stop
