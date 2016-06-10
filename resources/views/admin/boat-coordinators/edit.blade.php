@extends('admin.layout')

@section('content')

    <div class="page-header">
      <h1 class="page-title"> <i class="site-menu-icon fa-group" aria-hidden="true"></i> Boat Coordinators</h1>
      <ol class="breadcrumb">
        <li><a href="/admin/dashboard">Home</a></li>
        <li class="active"><a href="/admin/boat-coordinators">Boat Coordinators</a></li>
        <li class="active"><a>Edit</a></li>
      </ol>
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
      
	   @if(isset($boat_coordinator))
			
          {{Form::open(array('url'=>'/admin/boat-coordinators/'.$boat_coordinator->id, 'method' => 'PUT','id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal','enctype'=>'multipart/form-data'))}}               
              <input name="_token" type="hidden" value="{{csrf_token()}}">

                <div class="form-group form-material <?php if($errors->first('username')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Username</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="username" value="{{\Illuminate\Support\Facades\Input::old('username',$boat_coordinator->user->username)}}"/>
                    <span class="validator_output <?php if($errors->first('username')!=null) echo "help-block"?>">{{ $errors->first('username') }}</span>
                  </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('name')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Coordinator name <span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="name" value="{{\Illuminate\Support\Facades\Input::old('name',$boat_coordinator->user->name)}}" />
                    <span class="validator_output <?php if($errors->first('name')!=null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                  </div>
                </div>              
                <div class="form-group form-material <?php if($errors->first('email')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">E-mail <span>*</span></label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" name="email"  value="{{\Illuminate\Support\Facades\Input::old('email',$boat_coordinator->user->email)}}"/>
                    <span class="validator_output <?php if($errors->first('email')!=null) echo "help-block"?>">{{ $errors->first('email') }}</span>
                  </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('phone')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Phone No. <span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="phone" value="{{\Illuminate\Support\Facades\Input::old('phone',$boat_coordinator->user->phone)}}"/>
                    <span class="validator_output <?php if($errors->first('phone')!=null) echo "help-block"?>">{{ $errors->first('phone') }}</span>
                  </div>
                </div>

                <div class="form-group form-material <?php if($errors->first('gender')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Gender <span>*</span></label>
                  <div class="col-sm-9">
                    <select name="gender" class="form-control">
                      <option value="">Select One</option>
                      <option value="male" @if(\Illuminate\Support\Facades\Input::old('gender',$boat_coordinator->gender)=='male') selected @endif>Male</option>
                      <option value="female" @if(\Illuminate\Support\Facades\Input::old('gender',$boat_coordinator->gender)=='female') selected @endif>Female</option>
                    </select>
                    <span class="validator_output <?php if($errors->first('gender')!=null) echo "help-block"?>">{{ $errors->first('gender') }}</span>
                  </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('location')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Location <span>*</span></label>
                  <div class="col-sm-9">
                    <select name="location" class="form-control">
                      <option value="">Select One</option>
                      <option value="Western" @if(\Illuminate\Support\Facades\Input::old('location',$boat_coordinator->location)=='Western') selected @endif>Marina South Pier</option>
                      <option value="Eastern" @if(\Illuminate\Support\Facades\Input::old('location',$boat_coordinator->location)=='Eastern') selected @endif>West Cost Pair</option>
                    </select>
                    <span class="validator_output <?php if($errors->first('location')!=null) echo "help-block"?>">{{ $errors->first('location') }}</span>
                  </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('address')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Address</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="address" value="{{\Illuminate\Support\Facades\Input::old('address',$boat_coordinator->user->address)}}"/>
                    <span class="validator_output <?php if($errors->first('address')!=null) echo "help-block"?>">{{ $errors->first('address') }}</span>
                  </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('about')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">About</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" name="about" rows="5">{{\Illuminate\Support\Facades\Input::old('about',$boat_coordinator->about)}}</textarea>
                    <span class="validator_output <?php if($errors->first('about')!=null) echo "help-block"?>">{{ $errors->first('about') }}</span>
                  </div>
                </div>
                <div class="form-group form-material">
                  <label class="col-sm-3 control-label">Image</label>
                  <img src="{{URL::asset($boat_coordinator->user->thumb_photo)}}" alt="..." class="col-sm-3" style="height: 5%;width: 10%">
                  <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Browse.." readonly="" />
                    <input type="file" id="photo_original" name="photo" multiple="" />
                  </div>
                </div>

                <div class="form-group form-material <?php if($errors->first('boat_owner_id')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Boat Owner <span>*</span></label>
                  <div class="col-sm-9">
                    <select type="text" name="boat_owner_id" class="form-control">
                      <option value=""> Choose One Owner</option>
                      @foreach($boat_owner_profiles as $boat_owner_profile)

                        <option value="{{$boat_owner_profile->user_id}}" @if(\Illuminate\Support\Facades\Input::old('boat_owner_id',$boat_coordinator->boat_owner)==$boat_owner_profile->user_id) selected @endif>{{$boat_owner_profile->user->name}}</option>
                      @endforeach
                    </select>
                    <span class="validator_output <?php if($errors->first('boat_owner_id')!=null) echo "help-block"?>">{{ $errors->first('boat_owner_id') }}</span>
                  </div>
                </div>
                            
                <div class="text-right">
                  <button type="submit" class="btn btn-primary" id="validateButton3">Submit</button>
                </div>
              </form>
	    @endif		  
			  
            </div>
          </div>
          <!-- End Panel Summary Mode -->
        </div>
      </div>

    </div>


@stop