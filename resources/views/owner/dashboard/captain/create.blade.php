@extends('user.layout')

@section('title')
    Owner Dashboard
@stop

@section('content')
<section class="section-boat-list">
    <div class="container">
        @include('owner.dashboard.common.breadcrumb')        
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="sidebar">
                    <div class="widget widget-side-menu">
                        <div class="header-bar">
                            <h4><i class="fa fa-gear"></i>Manage account</h4>
                        </div>
                    @include('owner.dashboard.common.sidemenu')       
                    </div><!-- widget -->
                </div><!-- sidebar -->
            </div><!-- sidebar wrapper -->
            <div class="col-md-9 xol-sm-8">
                <div class="block-wrapper">
                    <div class="block account-block padel-box" style="background:#fff;">
                        <div class="header-bar padel-box-header">
                            <h4 class="clearfix padel-title"><i class="fa fa-street-view"></i> My Captains
                                @if($checkCaptain==null)
                                <a href="/owner/dashboard/captains/promote" class="pull-right rb-edit"><i class="fa fa-plus"></i>Promote Self as Captain</a>
                            @endif
                            </h4>
                        </div>
                        <div class="padel-box-body">

                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <form class="form-horizontal form-edit-profile" method="POST" enctype='multipart/form-data'>
                                        <input name="_token" type="hidden" value="{{csrf_token()}}">
                                        <div class="form-group <?php if($errors->first('username')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Username <span>*</span></label>
                                            <div class="col-sm-9">
                                            <input type="text" class="form-control" id="userName" name="username" value="{{\Illuminate\Support\Facades\Input::old('username')}}" placeholder=""/>
                                                <span class="validator_output <?php if($errors->first('username')!=null) echo "help-block"?>">{{ $errors->first('username') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group <?php if($errors->first('name')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Name: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="name" placeholder="" value="{{\Illuminate\Support\Facades\Input::old('name')}}">
                                                <span class="validator_output <?php if($errors->first('name')!=null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group <?php if($errors->first('email')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Email: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="email" value="{{\Illuminate\Support\Facades\Input::old('email')}}" placeholder="">
                                                <span class="validator_output <?php if($errors->first('email')!=null) echo "help-block"?>">{{ $errors->first('email') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group <?php if($errors->first('phone')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Phone: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="phone" value="{{\Illuminate\Support\Facades\Input::old('phone')}}" placeholder="">
                                                <span class="validator_output <?php if($errors->first('phone')!=null) echo "help-block"?>">{{ $errors->first('phone') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group <?php if($errors->first('password')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Password: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" name="password" placeholder="">
                                                <span class="validator_output <?php if($errors->first('password')!=null) echo "help-block"?>">{{ $errors->first('password') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group  <?php if($errors->first('gender')!=null) echo "has-error"?>">
                                            <label class="col-sm-3 control-label">Gender <span>*</span></label>
                                            <div class="col-sm-9">
                                                <select name="gender" class="form-control">
                                                    <option value="">Select One</option>
                                                    <option value="male" @if(\Illuminate\Support\Facades\Input::old('gender')=='male') selected @endif>Male</option>
                                                    <option value="female" @if(\Illuminate\Support\Facades\Input::old('gender')=='female') selected @endif>Female</option>
                                                </select>
                                                <span class="validator_output <?php if($errors->first('gender')!=null) echo "help-block"?>">{{ $errors->first('gender') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group  <?php if($errors->first('address')!=null) echo "has-error"?>">
                                            <label class="col-sm-3 control-label">Address</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="address" value="{{\Illuminate\Support\Facades\Input::old('address')}}"/>
                                                <span class="validator_output <?php if($errors->first('address')!=null) echo "help-block"?>">{{ $errors->first('address') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group <?php if($errors->first('about')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">About:</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="about" placeholder="">{{\Illuminate\Support\Facades\Input::old('about')}}</textarea>
                                            </div>
                                        </div>                                        
                                        <div class="form-group <?php if($errors->first('nric')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">NRIC:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="nric" value="{{\Illuminate\Support\Facades\Input::old('nric')}}" placeholder="">
                                                <span class="validator_output <?php if($errors->first('nric')!=null) echo "help-block"?>">{{ $errors->first('nric') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group <?php if($errors->first('years_of_boating')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Years Of Boating:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="years_of_boating" value="{{\Illuminate\Support\Facades\Input::old('years_of_boating')}}" placeholder="">
                                                <span class="validator_output <?php if($errors->first('years_of_boating')!=null) echo "help-block"?>">{{ $errors->first('years_of_boating') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group <?php if($errors->first('photo')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Picture:</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" name="photo" placeholder="">
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
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