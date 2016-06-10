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
                            <h4 class="clearfix padel-title"><i class="fa fa-ship"></i> My Boats </h4>
                        </div>
                        <div class="padel-box-body">

                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                  {{Form::open(array('url'=>'/owner/dashboard/boats/'.$boat->id,'files'=>true,'id'=>'boat-registration-form','autocomplete'=>'off','class'=>'boat-registration-form form-horizontal'))}}
                                       <input name="_token" type="hidden" value="{{csrf_token()}}">
                                    <div class="form-group <?php if($errors->first('name')!=null) echo "has-error"?>">
                                        <label class="control-label col-sm-3">Boat Name: <span>*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="name" id="name"  value="{{\Illuminate\Support\Facades\Input::old('name',$boat->name)}}" placeholder="Boat Name"/>
                                            <span class="validator_output <?php if($errors->first('name')!=null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                                        </div>
                                    </div>

                                    <div class="form-group <?php if($errors->first('habourcraft_number')!=null) echo "has-error"?>">
                                        <label class="control-label col-sm-3">Harbourcraft license number: <span>*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="habourcraft_number"  value="{{\Illuminate\Support\Facades\Input::old('habourcraft_number',$boat->habourcraft_number)}}" id="habourcraft-number" placeholder="Habourcraft Number"/>
                                            <span class="validator_output <?php if($errors->first('habourcraft_number')!=null) echo "help-block"?>">{{ $errors->first('habourcraft_number') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if($errors->first('license_date')!=null) echo "has-error"?>">
                                        <label class="control-label col-sm-3">License Issue Date: <span>*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control datepicker" name="license_date"  value="{{\Illuminate\Support\Facades\Input::old('license_date',$boat->license_date)}}" id="license_date" placeholder="License Date"/>
                                            <span class="validator_output <?php if($errors->first('license_date')!=null) echo "help-block"?>">{{ $errors->first('license_date') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if($errors->first('manning_type')!=null) echo "has-error"?>">
                                        <label class="control-label col-sm-3">Manning type: <span>*</span></label>
                                        <div class="col-sm-9">
                                            <div class="col-md-12">
                                                <div class="check-btn-group">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="radio radio-block check-block @if(\Illuminate\Support\Facades\Input::old('manning_type',$boat->manning_type)=='one manned') selected @endif ">
                                                                <label>
                                                                    <input class="check-btn" type="radio" name="manning_type" value="one manned" @if(\Illuminate\Support\Facades\Input::old('manning_type',$boat->manning_type)=='one manned') checked @endif />
                                                                    <span><i class="fa fa-user"></i>One manned:</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div><!-- col-md-6 -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="radio radio-block check-block @if(\Illuminate\Support\Facades\Input::old('manning_type',$boat->manning_type)=='two manned') selected @endif">
                                                                <label>
                                                                    <input class="check-btn" type="radio" name="manning_type" value="two manned" @if(\Illuminate\Support\Facades\Input::old('manning_type',$boat->manning_type)=='two manned') checked @endif/>
                                                                    <span><i class="fa fa-user-plus"></i>Two manned:</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div><!-- col-md-6 -->
                                                </div><!-- radio-btn-group -->
                                                <span class="validator_output <?php if($errors->first('manning_type')!=null) echo "help-block"?>">{{ $errors->first('manning_type') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if($errors->first('average_speed')!=null) echo "has-error"?>">
                                        <label class="col-sm-3 control-label">Average Speed (Knots): </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="average_speed" id="average_speed" value="{{\Illuminate\Support\Facades\Input::old('average_speed',$boat->average_speed)}}"/>
                                            <span class="validator_output <?php if($errors->first('average_speed')!=null) echo "help-block"?>">{{ $errors->first('average_speed') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if($errors->first('capacity')!=null) echo "has-error"?>">
                                        <label class="control-label col-sm-3">capacity:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="capacity" id="capacity" value="{{\Illuminate\Support\Facades\Input::old('capacity',$boat->capacity)}}"/>
                                            <span class="validator_output <?php if($errors->first('capacity')!=null) echo "help-block"?>">{{ $errors->first('capacity') }}</span>
                                        </div>
                                    </div>

                                    <div class="form-group <?php if($errors->first('operating_zone')!=null) echo "has-error"?>">
                                        <label class="control-label col-sm-3">Operating zone <span>*</span></label>
                                        <div class="col-sm-9">
                                            <select name="operating_zone" id="zone" class="form-control">
                                                <option value="" @if(\Illuminate\Support\Facades\Input::old('operating_zone',$boat->operating_zone)==null)  selected @endif>Please Select One</option>
                                                <option value="Eastern" @if(\Illuminate\Support\Facades\Input::old('operating_zone',$boat->operating_zone)=="Eastern")  selected @endif>Eastern</option>
                                                <option value="Western" @if(\Illuminate\Support\Facades\Input::old('operating_zone',$boat->operating_zone)=="Western")  selected @endif>Western</option>
                                            </select>
                                            <span class="validator_output <?php if($errors->first('operating_zone')!=null) echo "help-block"?>">{{ $errors->first('operating_zone') }}</span>
                                        </div>
                                    </div><!-- form-group -->

                                    <div class="form-group <?php if($errors->first('boat_captain_id')!=null) echo "has-error"?>">
                                        <label class="control-label col-sm-3">Authorized Captains:</label>
                                        <div class="col-sm-9">
                                            <select type="text" name="boat_captain_id[]" class="form-control chosen-select" multiple>
                                                @if($rel_boat_captains!='[]')
                                                    @foreach($rel_boat_captains as $rel_boat_captain)
                                                        @foreach($captains as $captain)
                                                            @if(Illuminate\Support\Facades\Input::old('boat_captain_id',$rel_boat_captain->captain_id)==$captain->user_id)
                                                                <option value="{{$rel_boat_captain->captain_id}}"
                                                                        selected>{{$rel_boat_captain->user->name}}</option>
                                                            @else
                                                                <option value="{{$captain->user_id}}"
                                                                        @if(Illuminate\Support\Facades\Input::old('boat_captain_id')==$captain->user_id) selected @endif>{{$captain->user->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @else
                                                    @foreach($captains as $captain)
                                                        <option value="{{$captain->user_id}}" @if(Illuminate\Support\Facades\Input::old('boat_captain_id')==$captain->user_id) selected @endif>{{$captain->user->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Current Captain: <span>*</span></label>
                                        <div class="col-sm-9">
                                            @if($boat->captain_id!=null)
                                                <a href="/captains/profile/{{ $boat->captain_id }}">{{ $boat->captain->user->name }}</a>
                                            @else
                                                <span class="no-capt">No Captain.</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group <?php if($errors->first('status')!=null) echo "has-error"?>">
                                        <label class="control-label col-sm-3">Status</label>
                                        <div class="col-sm-9">
                                            <select name="status" id="status" class="form-control">
                                                <option value="" @if(\Illuminate\Support\Facades\Input::old('status',$boat->status)==null) selected @endif>Please Select One</option>
                                                <option value="available" @if(\Illuminate\Support\Facades\Input::old('status',$boat->status)=="available") selected @endif>Available</option>
                                                <option value="off-duty" @if(\Illuminate\Support\Facades\Input::old('status',$boat->status)=="off-duty") selected @endif>Off-duty</option>
                                                <option value="busy" @if(\Illuminate\Support\Facades\Input::old('status',$boat->status)=="busy") selected @endif>Busy</option>
                                                <option value="booked" @if(\Illuminate\Support\Facades\Input::old('status',$boat->status)=="booked")  selected @endif>Booked</option>
                                            </select>
                                        </div>
                                        <span class="validator_output <?php if($errors->first('status')!=null) echo "help-block"?>">{{ $errors->first('status') }}</span>
                                    </div><!-- form-group -->

                                    <div class="form-group <?php if($errors->first('photo')!=null) echo "has-error"?>">
                                        <label class="control-label col-sm-3">Image:</label>
                                        <img src="{{$boat->thumb_photo}}" class="col-sm-3" style="height: 5%;width: 10%">
                                        <div class="col-sm-6">
                                            <input type="file" id="photo" class="form-control" name="photo" multiple="" />
                                            <span class="validator_output <?php if($errors->first('photo')!=null) echo "help-block"?>">{{ $errors->first('photo') }}</span>
                                        </div>
                                    </div>

                                    <div class="form-group form-material <?php if($errors->first('about')!=null) echo "has-error"?>">
                                        <label class="col-sm-3 control-label">About</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="about" rows="5">{{\Illuminate\Support\Facades\Input::old('about',$boat->about)}}</textarea>
                                            <span class="validator_output <?php if($errors->first('about')!=null) echo "help-block"?>">{{ $errors->first('about') }}</span>
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

@section('footer_scripts')
    <script type="text/javascript">
        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
            '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    </script>
@stop