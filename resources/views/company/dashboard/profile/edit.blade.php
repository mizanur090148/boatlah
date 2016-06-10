@extends('user.layout')

@section('title')
    Owner Dashboard
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            @include('company.dashboard.common.breadcrumb')
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('company.dashboard.common.sidemenu')
                        </div><!-- widget -->
                    </div><!-- sidebar -->
                </div><!-- sidebar wrapper -->
                <div class="col-md-9 xol-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-user"></i> Profile </h4>
                            </div>
                            <div class="padel-box-body">
                                <div class="row">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        {{Form::open(array('url'=>'/company/dashboard/profile/update','method' => 'POST','id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal','enctype'=>'multipart/form-data'))}}

                                        <div class="form-group form-material <?php if($errors->first('username')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Username: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="username" value="{{ \Illuminate\Support\Facades\Input::old('username',$user_info->user->username)}}">
                                                <span class="validator_output <?php if($errors->first('username')!=null) echo "help-block"?>">{{ $errors->first('username') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group form-material <?php if($errors->first('name')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Company Name: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="name" value="{{ \Illuminate\Support\Facades\Input::old('name',$user_info->user->name)}}">
                                                <span class="validator_output <?php if($errors->first('name')!=null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group form-material <?php if($errors->first('email')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Email: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="email" value="{{ \Illuminate\Support\Facades\Input::old('email',$user_info->user->email)}}">
                                                <span class="validator_output <?php if($errors->first('email')!=null) echo "help-block"?>">{{ $errors->first('email') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group form-material <?php if($errors->first('phone')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Phone No.: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="phone" value="{{ \Illuminate\Support\Facades\Input::old('phone',$user_info->user->phone)}}">
                                                <span class="validator_output <?php if($errors->first('phone')!=null) echo "help-block"?>">{{ $errors->first('phone') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group form-material <?php if($errors->first('gender')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Gender: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="gender">
                                                    <option value="male" @if(\Illuminate\Support\Facades\Input::old('gender',$user_info->gender)=='male') selected @endif>Male</option>
                                                    <option value="female" @if(\Illuminate\Support\Facades\Input::old('gender',$user_info->gender)=='female') selected @endif>Female</option>
                                                </select>
                                                <span class="validator_output <?php if($errors->first('gender')!=null) echo "help-block"?>">{{ $errors->first('gender') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group form-material <?php if($errors->first('address')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Address : <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="address" value="{{ \Illuminate\Support\Facades\Input::old('address',$user_info->user->address)}}">
                                                <span class="validator_output <?php if($errors->first('address')!=null) echo "help-block"?>">{{ $errors->first('address') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group form-material <?php if($errors->first('photo')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Image </label>
                                            <img src="{{URL::asset($user_info->user->thumb_photo)}}" class="col-sm-3" style="height: 25%;width: 25%">
                                            <div class="col-sm-6">
                                                <input type="file" id="photo"  class="form-control"  name="photo" multiple="" />
                                                <span class="validator_output <?php if($errors->first('photo')!=null) echo "help-block"?>">{{ $errors->first('photo') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">About</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="about" rows="5">{{ \Illuminate\Support\Facades\Input::old('about',$user_info->about)}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group form-material <?php if($errors->first('owner_name')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Owner Name: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="owner_name" value="{{ \Illuminate\Support\Facades\Input::old('owner_name',$user_info->owner_name)}}">
                                                <span class="validator_output <?php if($errors->first('owner_name')!=null) echo "help-block"?>">{{ $errors->first('owner_name') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group form-material <?php if($errors->first('type_of_firm')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Type of Firm: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="type_of_firm" value="{{ \Illuminate\Support\Facades\Input::old('type_of_firm',$user_info->type_of_firm)}}">
                                                <span class="validator_output <?php if($errors->first('type_of_firm')!=null) echo "help-block"?>">{{ $errors->first('type_of_firm') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group form-material <?php if($errors->first('registration_uen')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Uen Number: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="registration_uen" value="{{ \Illuminate\Support\Facades\Input::old('registration_uen',$user_info->registration_uen)}}">
                                                <span class="validator_output <?php if($errors->first('registration_uen')!=null) echo "help-block"?>">{{ $errors->first('registration_uen') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group form-material <?php if($errors->first('registration_date')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Date of Registration: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="registration_date" value="{{ \Illuminate\Support\Facades\Input::old('registration_date',$user_info->registration_date)}}">
                                                <span class="validator_output <?php if($errors->first('registration_date')!=null) echo "help-block"?>">{{ $errors->first('registration_date') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                        {{Form::close()}}
                                    </div>
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