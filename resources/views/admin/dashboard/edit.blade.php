@extends('admin.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/formvalidation/formValidation.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/forms/validation.css') }}">
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title"><i class="site-menu-icon fa-ship" aria-hidden="true"></i> Dashboard</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li class="active"><a href="#">Edit</a></li>
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
                        <h3 class="panel-title">Edit</h3>
                    </div>
                    <div class="panel-body">
                        {{Form::open(array('url'=>'/admin/dashboard/edit/'.$admin->id, 'files'=>true, 'id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal'))}}

                        <div class="form-group form-material <?php if($errors->first('name')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Boat name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" value="{{\Illuminate\Support\Facades\Input::old('name',$admin->user->name)}}"/>
                                <span class="validator_output <?php if($errors->first('name')!=null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if($errors->first('email')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" value="{{\Illuminate\Support\Facades\Input::old('email',$admin->user->email)}}"/>
                                <span class="validator_output <?php if($errors->first('email')!=null) echo "help-block"?>">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if($errors->first('phone')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Phone</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="phone" value="{{\Illuminate\Support\Facades\Input::old('phone',$admin->user->phone)}}"/>
                                <span class="validator_output <?php if($errors->first('phone')!=null) echo "help-block"?>">{{ $errors->first('phone') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if($errors->first('address')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="address" value="{{\Illuminate\Support\Facades\Input::old('address',$admin->user->address)}}"/>
                                <span class="validator_output <?php if($errors->first('address')!=null) echo "help-block"?>">{{ $errors->first('address') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if($errors->first('photo')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Image</label>
                            <img src="{{URL::asset($admin->user->thumb_photo)}}" alt="..." class="col-sm-3" style="height: 5%;width: 10%">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="Browse.." readonly="" />
                                <input type="file" id="photo" name="photo" multiple=""/>
                                <span class="validator_output <?php if($errors->first('photo')!=null) echo "help-block"?>">{{ $errors->first('photo') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if($errors->first('about')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">About</label>
                            <div class="col-sm-9">
                                <textarea type="text" class="form-control" name="about" >{{\Illuminate\Support\Facades\Input::old('about',$admin->about)}}</textarea>
                                <span class="validator_output <?php if($errors->first('about')!=null) echo "help-block"?>">{{ $errors->first('about') }}</span>
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