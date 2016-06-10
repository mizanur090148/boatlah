@extends('admin.layout')

@section('content')

    <div class="page-header">
      <h1 class="page-title"> <i class="site-menu-icon fa-street-view" aria-hidden="true"></i> Boat Captains</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li class="active"><a href="{{ url('/admin/boat-captains') }}">Boat Captains</a></li>
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

          {{Form::open(array('url'=>'/admin/boat-captains/'.$boat_captain->id, 'method' => 'PUT','id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal','enctype'=>'multipart/form-data'))}}
              <input name="_token" type="hidden" value="{{csrf_token()}}">

                <div class="form-group form-material <?php if($errors->first('username')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="username" value="{{\Illuminate\Support\Facades\Input::old('username',$boat_captain->user->username)}}"/>
                        <span class="validator_output <?php if($errors->first('username')!=null) echo "help-block"?>">{{ $errors->first('username') }}</span>
                    </div>
                </div>
              <div class="form-group form-material <?php if($errors->first('name')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Captain name <span>*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="name" value="{{\Illuminate\Support\Facades\Input::old('name',$boat_captain->user->name)}}" />
                    <span class="validator_output <?php if($errors->first('name')!=null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                  </div>
                </div>

                <div class="form-group form-material <?php if($errors->first('email')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Email <span>*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="email" value="{{\Illuminate\Support\Facades\Input::old('email',$boat_captain->user->email)}}"/>
                        <span class="validator_output <?php if($errors->first('email')!=null) echo "help-block"?>">{{ $errors->first('email') }}</span>
                    </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('phone')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Phone No. <span>*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="phone" value="{{\Illuminate\Support\Facades\Input::old('phone',$boat_captain->user->phone)}}"/>
                        <span class="validator_output <?php if($errors->first('phone')!=null) echo "help-block"?>">{{ $errors->first('phone') }}</span>
                    </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('gender')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Gender <span>*</span></label>
                    <div class="col-sm-9">
                        <select name="gender" class="form-control">
                            <option value="">Select One</option>
                            <option value="male" @if(\Illuminate\Support\Facades\Input::old('gender',$boat_captain->gender)=='male') selected @endif>Male</option>
                            <option value="female" @if(\Illuminate\Support\Facades\Input::old('gender',$boat_captain->gender)=='female') selected @endif>Female</option>
                        </select>
                        <span class="validator_output <?php if($errors->first('gender')!=null) echo "help-block"?>">{{ $errors->first('gender') }}</span>
                    </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('address')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Address</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="address" value="{{\Illuminate\Support\Facades\Input::old('address',$boat_captain->user->address)}}"/>
                        <span class="validator_output <?php if($errors->first('address')!=null) echo "help-block"?>">{{ $errors->first('address') }}</span>
                    </div>
                </div>
                 <div class="form-group form-material <?php if($errors->first('nric')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">NRIC</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="nric" value="{{\Illuminate\Support\Facades\Input::old('nric',$boat_captain->nric)}}"/>
                    <span class="validator_output <?php if($errors->first('nric')!=null) echo "help-block"?>">{{ $errors->first('nric') }}</span>
                  </div>
                </div>
                <div class="form-group form-material <?php if($errors->first('years_of_boating')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">Years Of Boating</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="years_of_boating"  value="{{\Illuminate\Support\Facades\Input::old('years_of_boating',$boat_captain->years_of_boating)}}"/>
                    <span class="validator_output <?php if($errors->first('years_of_boating')!=null) echo "help-block"?>">{{ $errors->first('years_of_boating') }}</span>
                  </div>
                </div>                
                <div class="form-group form-material <?php if($errors->first('about')!=null) echo "has-error"?>">
                  <label class="col-sm-3 control-label">About</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" name="about" rows="5">{{\Illuminate\Support\Facades\Input::old('about',$boat_captain->about)}}</textarea>
                    <span class="validator_output <?php if($errors->first('about')!=null) echo "help-block"?>">{{ $errors->first('about') }}</span>
                  </div>
                </div> 
                <div class="form-group form-material">
                  <label class="col-sm-3 control-label">Image</label>
                    <img src="{{URL::asset($boat_captain->user->thumb_photo)}}" alt="..." class="col-sm-3" style="height: 5%;width: 10%">
                    <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Browse.." readonly="" />
                    <input type="file" id="photo" name="photo" multiple="" />
                  </div>
                </div>

                <div class="form-group form-material <?php if($errors->first('boat_owner_id')!=null) echo "has-error"?>">
                    <label class="col-sm-3 control-label">Boat Owner <span>*</span></label>
                    <div class="col-sm-9">
                        <select type="text" name="boat_owner_id" class="form-control">
                            <option value=""> Choose One Owner</option>
                            @foreach($boat_owner_profiles as $boat_owner_profile)

                                <option value="{{$boat_owner_profile->user_id}}" @if(\Illuminate\Support\Facades\Input::old('boat_owner_id',$boat_captain->boat_owner)==$boat_owner_profile->user_id) selected @endif>{{$boat_owner_profile->user->name}}</option>
                            @endforeach
                        </select>
                        <span class="validator_output <?php if($errors->first('boat_owner_id')!=null) echo "help-block"?>">{{ $errors->first('boat_owner_id') }}</span>
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