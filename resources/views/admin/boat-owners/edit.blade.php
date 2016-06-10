@extends('admin.layout')

@section('content')

    <div class="page-header">
      <h1 class="page-title"><i class="site-menu-icon fa-user" aria-hidden="true"></i> Boat Owners</h1>
      <ol class="breadcrumb">
        <li><a href="/admin/dashboard">Home</a></li>
        <li><a href="{{ url('/admin/boat-owners') }}">Boat Owners</a></li>
        <li class="active">Update</li>
      </ol>
    </div>
    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-md-12">
          <!-- Panel Summary Mode -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Update</h3>
            </div>
            <div class="panel-body">

               {{Form::open(array('url'=>'/admin/boat-owners/'.$boat_owner->id, 'method' => 'PUT','id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal','enctype'=>'multipart/form-data'))}}
               
                <input name="_token" type="hidden" value="{{csrf_token()}}">

                <div class="form-group form-material <?php if($errors->first('username')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="username" value="{{\Illuminate\Support\Facades\Input::old('username',$boat_owner->user->username)}}"/>
                        <span class="validator_output <?php if($errors->first('username')!=null) echo "help-block"?>">{{ $errors->first('username') }}</span>
                    </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('name')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Name <span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="name" value="{{\Illuminate\Support\Facades\Input::old('name',$boat_owner->user->name)}}" />
                    <span class="validator_output <?php if($errors->first('name')!=null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                  </div>
                </div>

                <div class="form-group form-material <?php if($errors->first('email')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Email <span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="email" value="{{\Illuminate\Support\Facades\Input::old('email',$boat_owner->user->email)}}" />
                    <span class="validator_output <?php if($errors->first('email')!=null) echo "help-block"?>">{{ $errors->first('email') }}</span>
                  </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('phone')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Phone No. <span>*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="phone" value="{{\Illuminate\Support\Facades\Input::old('phone',$boat_owner->user->phone)}}" />
                        <span class="validator_output <?php if($errors->first('phone')!=null) echo "help-block"?>">{{ $errors->first('phone') }}</span>
                    </div>
                </div>

                <div class="form-group form-material <?php if($errors->first('landline')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Landline</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="landline" value="{{\Illuminate\Support\Facades\Input::old('landline',$boat_owner->landline)}}"/>
                        <span class="validator_output <?php if($errors->first('landline')!=null) echo "help-block"?>">{{ $errors->first('landline') }}</span>
                    </div>
                </div>

                <div class="form-group form-material <?php if($errors->first('gender')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Gender <span>*</span></label>
                    <div class="col-sm-9">
                        <select name="gender" class="form-control">
                            <option value="">Select One</option>
                            <option value="male" @if(\Illuminate\Support\Facades\Input::old('gender',$boat_owner->gender)=='male') selected @endif>Male</option>
                            <option value="female" @if(\Illuminate\Support\Facades\Input::old('gender',$boat_owner->gender)=='female') selected @endif>Female</option>
                        </select>
                        <span class="validator_output <?php if($errors->first('gender')!=null) echo "help-block"?>">{{ $errors->first('gender') }}</span>
                    </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('address')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Address <span>*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="address" value="{{\Illuminate\Support\Facades\Input::old('address',$boat_owner->user->address)}}"/>
                        <span class="validator_output <?php if($errors->first('address')!=null) echo "help-block"?>">{{ $errors->first('address') }}</span>
                    </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('photo')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Owner Image </label>
                    <img src="{{URL::asset($boat_owner->user->thumb_photo)}}" class="col-sm-3" style="height: 5%;width: 10%">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" placeholder="Browse.." readonly="" />
                        <input type="file" id="photo" name="photo" multiple="" />
                        <span class="validator_output <?php if($errors->first('photo')!=null) echo "help-block"?>">{{ $errors->first('photo') }}</span>
                    </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('about')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">About</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="about" rows="5">{{\Illuminate\Support\Facades\Input::old('about',$boat_owner->about)}}</textarea>
                        <span class="validator_output <?php if($errors->first('about')!=null) echo "help-block"?>">{{ $errors->first('invoice_bank_details') }}</span>
                    </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('company_name')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Company name <span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="company_name" value="{{\Illuminate\Support\Facades\Input::old('company_name',$boat_owner->company_name)}}"/>
                    <span class="validator_output <?php if($errors->first('company_name')!=null) echo "help-block"?>">{{ $errors->first('company_name') }}</span>
                  </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('type_of_firm')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Type of Firm <span>*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="type_of_firm" value="{{\Illuminate\Support\Facades\Input::old('type_of_firm',$boat_owner->type_of_firm)}}"/>
                        <span class="validator_output <?php if($errors->first('type_of_firm')!=null) echo "help-block"?>">{{ $errors->first('type_of_firm') }}</span>
                    </div>
                </div>
                 <div class="form-group form-material <?php if($errors->first('uen_number')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Registration UEN No. <span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="uen_number" value="{{\Illuminate\Support\Facades\Input::old('uen_number',$boat_owner->uen_number)}}"/>
                    <span class="validator_output <?php if($errors->first('uen_number')!=null) echo "help-block"?>">{{ $errors->first('uen_number') }}</span>
                  </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('date_of_registration')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Date of Registration <span>*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="date_of_registration" value="{{\Illuminate\Support\Facades\Input::old('date_of_registration',$boat_owner->date_of_registration)}}"/>
                        <span class="validator_output <?php if($errors->first('date_of_registration')!=null) echo "help-block"?>">{{ $errors->first('date_of_registration') }}</span>
                    </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('gst_registration')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">GST Registration</label>
                  <div class="col-sm-9">                   
                     <input type="text" class="form-control" name="gst_registration" value="{{\Illuminate\Support\Facades\Input::old('gst_registration',$boat_owner->gst_registration)}}"/>
                     <span class="validator_output <?php if($errors->first('gst_registration')!=null) echo "help-block"?>">{{ $errors->first('gst_registration') }}</span>
                  </div>
                </div>
                <div class="form-group form-material">
                  <label class="col-sm-3 control-label">Header Image</label>
                    <img src="{{URL::asset($boat_owner->invoice_header_image)}}" class="col-sm-3" style="height: 5%;width: 10%">
                    <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Browse.." readonly="" />
                    <input type="file" id="invoice_header_image" name="invoice_header_image" multiple="" />
                    <span class="validator_output <?php if($errors->first('invoice_header_image')!=null) echo "help-block"?>">{{ $errors->first('invoice_header_image') }}</span>
                  </div>
                </div>
                <div class="form-group form-material">
                  <label class="col-sm-3 control-label">Footer Image </label>
                    <img src="{{URL::asset($boat_owner->invoice_footer_image)}}" class="col-sm-3" style="height: 5%;width: 10%">
                    <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Browse.." readonly="" />
                    <input type="file" id="invoice_footer_image" name="invoice_footer_image" multiple="" />
                    <span class="validator_output <?php if($errors->first('invoice_footer_image')!=null) echo "help-block"?>">{{ $errors->first('invoice_footer_image') }}</span>
                  </div>
                </div>
               <div class="form-group form-material <?php if($errors->first('invoice_bank_details')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Bank Details</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" name="invoice_bank_details" rows="5">{{\Illuminate\Support\Facades\Input::old('invoice_bank_details',$boat_owner->invoice_bank_details)}}</textarea>
                    <span class="validator_output <?php if($errors->first('invoice_bank_details')!=null) echo "help-block"?>">{{ $errors->first('invoice_bank_details') }}</span>
                  </div>
                </div>                 
                <div class="text-right">
                  <button type="submit" class="btn btn-primary" id="validateButton3">Submit</button>
                </div>
              </form>
            </div>
          </div>
          <!-- End Panel Summary Mode -->
        </div>
      </div>

    </div>


@stop