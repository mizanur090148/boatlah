@extends('admin.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/formvalidation/formValidation.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/forms/validation.css') }}">
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title"><i class="site-menu-icon fa-link" aria-hidden="true"></i> User and Roles</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li><a href="{{ url('/admin/users-and-roles') }}">User and Roles</a></li>
            <li class="active"><a href="#">Create New Roles</a></li>
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
                    <div class="panel-heading">
                        <h3 class="panel-title">{{$user->name}}</h3>
                    </div>
                    <div class="panel-body">
                        {{Form::open(array('url'=>'/admin/users-and-roles', 'files'=>true,'id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal'))}}
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="form-group form-material <?php if($errors->first('name')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Role name</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="name">
                                    <option value="">Select One</option>
                                    @foreach($roles as $role)

                                        <option value="{{$role->id}}" @if(\Illuminate\Support\Facades\Input::old('name')==$role->id) selected @endif>{{$role->name}}</option>
                                    @endforeach
                                </select>
                                <span class="validator_output <?php if($errors->first('name')!=null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" id="validateButton3">Submit</button>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
                <!-- End Panel Summary Mode -->
            </div>
        </div>

    </div>


@stop