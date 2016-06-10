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
                            <h4 class="clearfix padel-title"><i class="fa fa-user"></i> Profile </h4>
                        </div>
                        <div class="padel-box-body">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">                                   
                                    {{Form::open(array('url'=>'/owner/dashboard/profile/edit/','method' => 'POST','id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal','enctype'=>'multipart/form-data'))}}

                                    <div class="form-group form-material <?php if($errors->first('username')!=null) echo "has-error"?>">
                                        <label class="control-label col-sm-3">Username: <span>*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="username" value="{{ \Illuminate\Support\Facades\Input::old('username',$user_info->user->username)}}">
                                            <span class="validator_output <?php if($errors->first('username')!=null) echo "help-block"?>">{{ $errors->first('username') }}</span>
                                        </div>
                                    </div>
                                        <div class="form-group form-material <?php if($errors->first('name')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Owner Name: <span>*</span></label>
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
                                        <label class="control-label col-sm-3">Address: <span>*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="address" value="{{ \Illuminate\Support\Facades\Input::old('address',$user_info->user->address)}}">
                                            <span class="validator_output <?php if($errors->first('address')!=null) echo "help-block"?>">{{ $errors->first('address') }}</span>
                                        </div>
                                    </div>
                                        <div class="form-group form-material <?php if($errors->first('photo')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Owner Image </label>
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
                                        <div class="form-group form-material <?php if($errors->first('company_name')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Company Name: <span>*</span></label>
                                            <div class="col-sm-9">                                             
                                                 <input type="text" class="form-control" name="company_name" value="{{ \Illuminate\Support\Facades\Input::old('company_name',$user_info->company_name)}}">
                                                 <span class="validator_output <?php if($errors->first('company_name')!=null) echo "help-block"?>">{{ $errors->first('company_name') }}</span>
                                            </div>
                                        </div>
                                    <div class="form-group form-material <?php if($errors->first('type_of_firm')!=null) echo "has-error"?>">
                                        <label class="control-label col-sm-3">Type of Firm: <span>*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="type_of_firm" value="{{ \Illuminate\Support\Facades\Input::old('type_of_firm',$user_info->type_of_firm)}}">
                                            <span class="validator_output <?php if($errors->first('type_of_firm')!=null) echo "help-block"?>">{{ $errors->first('type_of_firm') }}</span>
                                        </div>
                                    </div>
                                        <div class="form-group form-material <?php if($errors->first('uen_number')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Uen Number: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="uen_number" value="{{ \Illuminate\Support\Facades\Input::old('uen_number',$user_info->uen_number)}}">
                                               <span class="validator_output <?php if($errors->first('uen_number')!=null) echo "help-block"?>">{{ $errors->first('uen_number') }}</span>
                                            </div>
                                        </div>
                                    <div class="form-group form-material <?php if($errors->first('date_of_registration')!=null) echo "has-error"?>">
                                        <label class="control-label col-sm-3">Date of Registration: <span>*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="date_of_registration" value="{{ \Illuminate\Support\Facades\Input::old('date_of_registration',$user_info->date_of_registration)}}">
                                            <span class="validator_output <?php if($errors->first('date_of_registration')!=null) echo "help-block"?>">{{ $errors->first('date_of_registration') }}</span>
                                        </div>
                                    </div>
                                         <div class="form-group form-material <?php if($errors->first('gst_registration')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Gst Registration:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="gst_registration" value="{{ \Illuminate\Support\Facades\Input::old('gst_registration',$user_info->gst_registration)}}">
                                                 <span class="validator_output <?php if($errors->first('gst_registration')!=null) echo "help-block"?>">{{ $errors->first('gst_registration') }}</span>
                                            </div>
                                        </div>    
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Invoice Bank Details:</label>
                                            <div class="col-sm-9">                                                
                                                <textarea class="form-control" name="invoice_bank_details" rows="5">{{ \Illuminate\Support\Facades\Input::old('invoice_bank_details',$user_info->invoice_bank_details)}}</textarea>
                                            </div>
                                        </div>  
                                        <div class="form-group form-material <?php if($errors->first('invoice_header_image')!=null) echo "has-error"?>">
                                          <label class="col-sm-3 control-label">Header Image</label>
                                            <img src="{{URL::asset($user_info->invoice_header_image)}}" class="col-sm-3" style="height: 25%;width: 25%">
                                            <div class="col-sm-6">
                                              <input type="file" id="invoice_header_image" class="form-control" name="invoice_header_image" multiple="" />
                                                <span class="validator_output <?php if($errors->first('invoice_header_image')!=null) echo "help-block"?>">{{ $errors->first('invoice_header_image') }}</span>
                                          </div>
                                        </div>
                                        <div class="form-group form-material <?php if($errors->first('invoice_footer_image')!=null) echo "has-error"?>">
                                          <label class="col-sm-3 control-label">Footer Image </label>
                                            <img src="{{URL::asset($user_info->invoice_footer_image)}}" class="col-sm-3" style="height: 25%;width: 25%">
                                            <div class="col-sm-6">
                                              <input type="file" id="invoice_footer_image" class="form-control" name="invoice_footer_image" multiple="" />
                                                <span class="validator_output <?php if($errors->first('invoice_footer_image')!=null) echo "help-block"?>">{{ $errors->first('invoice_footer_image') }}</span>
                                          </div>
                                        </div>                                     
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