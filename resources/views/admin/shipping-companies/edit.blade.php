@extends('admin.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/formvalidation/formValidation.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/forms/validation.css') }}">
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title"><i class="site-menu-icon fa-university" aria-hidden="true"></i> Shipping Companies</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li><a href="{{ url('/admin/shipping-companies') }}">Shipping Agency</a></li>
            <li class="active"><a>Edit</a></li>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Panel Summary Mode -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add New</h3>
                    </div>
                    <div class="panel-body">
                        {{Form::open(array('url'=>'/admin/shipping-companies/'.$shipping_company->id, 'files'=>true, 'method' => 'PUT','id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal'))}}

                        <div class="form-group form-material <?php if($errors->first('username')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="username" value="{{\Illuminate\Support\Facades\Input::old('username',$shipping_company->user->username)}}"/>
                                <span class="validator_output <?php if($errors->first('username')!=null) echo "help-block"?>">{{ $errors->first('username') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if($errors->first('name')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Shipping Agency name <span>*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" value="{{\Illuminate\Support\Facades\Input::old('name',$shipping_company->user->name)}}"/>
                                <span class="validator_output <?php if($errors->first('name')!=null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if($errors->first('email')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Email <span>*</span></label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" value="{{\Illuminate\Support\Facades\Input::old('email',$shipping_company->user->email)}}"/>
                                <span class="validator_output <?php if($errors->first('email')!=null) echo "help-block"?>">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if($errors->first('phone')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Phone <span>*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="phone" value="{{\Illuminate\Support\Facades\Input::old('phone',$shipping_company->user->phone)}}"/>
                                <span class="validator_output <?php if($errors->first('phone')!=null) echo "help-block"?>">{{ $errors->first('phone') }}</span>
                            </div>
                        </div>


                        <div class="form-group form-material <?php if($errors->first('type_of_firm')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Type of Firm <span>*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="type_of_firm" value="{{\Illuminate\Support\Facades\Input::old('type_of_firm',$shipping_company->type_of_firm)}}"/>
                                <span class="validator_output <?php if($errors->first('type_of_firm')!=null) echo "help-block"?>">{{ $errors->first('type_of_firm') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if($errors->first('owner_name')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Owner Name <span>*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="owner_name" value="{{\Illuminate\Support\Facades\Input::old('owner_name',$shipping_company->owner_name)}}"/>
                                <span class="validator_output <?php if($errors->first('owner_name')!=null) echo "help-block"?>">{{ $errors->first('owner_name') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if($errors->first('gender')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Gender <span>*</span></label>
                            <div class="col-sm-9">
                                <select class="form-control" name="gender">
                                    <option value="male" @if(\Illuminate\Support\Facades\Input::old('gender',$shipping_company->gender)=="male") selected @endif>Male</option>
                                    <option value="female" @if(\Illuminate\Support\Facades\Input::old('gender',$shipping_company->gender)=="female") selected @endif>Female</option>
                                </select>
                                <span class="validator_output <?php if($errors->first('gender')!=null) echo "help-block"?>">{{ $errors->first('gender') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if($errors->first('registration_date')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Registration Date <span>*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="registration_date" value="{{\Illuminate\Support\Facades\Input::old('registration_date',$shipping_company->registration_date)}}"/>
                                <span class="validator_output <?php if($errors->first('registration_date')!=null) echo "help-block"?>">{{ $errors->first('registration_date') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if($errors->first('registration_uen')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Registration UEN <span>*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="registration_uen" value="{{\Illuminate\Support\Facades\Input::old('registration_uen',$shipping_company->registration_uen)}}"/>
                                <span class="validator_output <?php if($errors->first('registration_uen')!=null) echo "help-block"?>">{{ $errors->first('registration_uen') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if($errors->first('landline')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Landline</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="landline" value="{{\Illuminate\Support\Facades\Input::old('landline',$shipping_company->landline)}}"/>
                                <span class="validator_output <?php if($errors->first('landline')!=null) echo "help-block"?>">{{ $errors->first('landline') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if($errors->first('address')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Address <span>*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="address" value="{{\Illuminate\Support\Facades\Input::old('address',$shipping_company->user->address)}}"/>
                                <span class="validator_output <?php if($errors->first('address')!=null) echo "help-block"?>">{{ $errors->first('address') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if($errors->first('photo')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Image</label>
                            <img src="{{URL::asset($shipping_company->user->thumb_photo)}}" alt="..." class="col-sm-3" style="height: 5%;width: 10%">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="Browse.." readonly="" />
                                <input type="file" id="photo" name="photo" multiple=""/>
                                <span class="validator_output <?php if($errors->first('photo')!=null) echo "help-block"?>">{{ $errors->first('photo') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if($errors->first('about')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">About</label>
                            <div class="col-sm-9">
                                <textarea type="text" class="form-control" name="about" >{{\Illuminate\Support\Facades\Input::old('about',$shipping_company->about)}}</textarea>
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