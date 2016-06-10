@extends('user.layout')

@section('title')
    Company Dashboard
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            @include('user.dashboard.common.breadcrumb')
                    <!-- breadcrumbs -->
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('user.dashboard.common.sidemenu')
                                    <!-- side-menu -->
                        </div>
                        <!-- widget -->
                    </div>
                    <!-- sidebar -->
                </div>
                <!-- sidebar wrapper -->
                <div class="col-md-9 xol-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-bookmark"></i> Advance Booking
                                    <a href="/user/dashboard/my-advance-bookings" class="pull-right rb-edit go-my-book"> My Bookings <i class="fa fa-angle-right"></i></a>
                                </h4>
                            </div>
                            <div class="padel-box-body">

                                {{Form::open(array('url'=>'/user/dashboard/advance-booking', 'method'=>'POST', 'class'=>'filter-search-form form-horizontal advance-book-form'))}}
                                <div class="form-group  <?php if($errors->first('owner_user_id')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Boat Owner</label>
                                    <div class="col-sm-6">
                                        <select class="form-control east-destination chosen" data-placeholder="Boat Owner Name" name="owner_user_id">
                                            @if($contracted_owners!='[]')
                                            @foreach($contracted_owners as $owner)
                                                <option value="{{ $owner->user_id }}" @if(\Illuminate\Support\Facades\Input::old('owner_user_id')==$owner->user_id) selected @endif>{{ $owner->user->name }}</option>
                                            @endforeach
                                                @endif
                                        </select>
                                        <span class="validator_output <?php if($errors->first('owner_user_id')!=null) echo "help-block"?>">{{ $errors->first('owner_user_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group  <?php if($errors->first('booking_date')!=null||$errors->first('booking_time')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Journey Date</label>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input class="form-control datepicker" id="booking_date" name="booking_date" placeholder="Date" type="text" value="{{\Illuminate\Support\Facades\Input::old('booking_date')}}">
                                                <span class="validator_output <?php if($errors->first('booking_date')!=null) echo "help-block"?>">{{ $errors->first('booking_date') }}</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-control timepicker" id="booking_time" name="booking_time" placeholder="Time" type="text" value="{{\Illuminate\Support\Facades\Input::old('booking_time')}}">
                                                <span class="validator_output <?php if($errors->first('booking_time')!=null) echo "help-block"?>">{{ $errors->first('booking_time') }}</span>
                                                <small style="color: #FEB005;">Singapore Time <sup>*</sup></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group  <?php if($errors->first('number_of_boats')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Number Of Boats</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" id="number_of_boats" name="number_of_boats" placeholder="Total Number of boats" type="text" value="{{\Illuminate\Support\Facades\Input::old('number_of_boats')}}">
                                        <span class="validator_output <?php if($errors->first('number_of_boats')!=null) echo "help-block"?>">{{ $errors->first('number_of_boats') }}</span>
                                    </div>
                                </div>
                                <div class="form-group  <?php if($errors->first('boat_type')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Boat Type</label>
                                    <div class="col-sm-9">
                                        <div class="row check-btn-group">
                                            <div class="col-sm-4">
                                                <div class="radio radio-block check-block @if(\Illuminate\Support\Facades\Input::old('boat_type')=='one manned') selected @endif">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="boat_type" value="one manned" @if(\Illuminate\Support\Facades\Input::old('boat_type')=='one manned') checked @endif/>
                                                        <span><i class="fa fa-user"></i>One manned</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="radio radio-block check-block @if(\Illuminate\Support\Facades\Input::old('boat_type')=='two manned') selected @endif">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="boat_type" value="two manned" @if(\Illuminate\Support\Facades\Input::old('boat_type')=='two manned') checked @endif/>
                                                        <span><i class="fa fa-user-plus"></i>Two manned</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="validator_output <?php if($errors->first('boat_type')!=null) echo "help-block"?>">{{ $errors->first('boat_type') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Zone</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="btn-group filter-srcbtn-group" data-toggle="buttons">
                                                    <a href="#east-zone" data-toggle="tab" class="btn btn-info @if(!\Illuminate\Support\Facades\Input::old('zone')) active @else @if(\Illuminate\Support\Facades\Input::old('zone')=='Eastern') active @endif @endif ">
                                                        <input type="radio" name="zone" id="zone1" autocomplete="off" value="Eastern" checked> Eastern
                                                    </a>
                                                    <a href="#west-zone" data-toggle="tab" class="btn btn-info @if(\Illuminate\Support\Facades\Input::old('zone')=='Western') active @endif">
                                                        <input type="radio" name="zone" id="zone2" value="Western" autocomplete="off"> Western
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade @if(!\Illuminate\Support\Facades\Input::old('zone')) in  active @endif @if(\Illuminate\Support\Facades\Input::old('zone')=='Eastern')in  active @endif" id="east-zone">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Start Point</label>
                                            <div class="col-sm-6">
                                                <select class="form-control east-destination chosen" data-placeholder="Start Point" name="Eastern_start_point">
                                                    @foreach($Eastern_anchorages as $anchorage)
                                                        <option value="{{ $anchorage->id }}" @if(\Illuminate\Support\Facades\Input::old('Eastern_start_point')==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Destination Point </label>
                                            <div class="col-sm-6">
                                                <select class="form-control east-destination chosen" data-placeholder="Destination Point " name="Eastern_end_point">
                                                    @foreach($Eastern_anchorages as $anchorage)
                                                        <option value="{{ $anchorage->id }}"  @if(\Illuminate\Support\Facades\Input::old('Eastern_end_point')==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- tab-pane -->
                                    <div class="tab-pane fade @if(\Illuminate\Support\Facades\Input::old('zone')=='Western')in  active @endif" id="west-zone">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Start Point</label>
                                            <div class="col-sm-6">
                                                <select class="form-control east-destination chosen" data-placeholder="Start Point" name="Western_start_point">
                                                    @foreach($Western_anchorages as $anchorage)
                                                        <option value="{{ $anchorage->id }}" @if(\Illuminate\Support\Facades\Input::old('Western_start_point')==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Destination Point </label>
                                            <div class="col-sm-6">
                                                <select class="form-control east-destination chosen" data-placeholder="Destination Point " name="Western_end_point">
                                                    @foreach($Western_anchorages as $anchorage)
                                                        <option value="{{ $anchorage->id }}" @if(\Illuminate\Support\Facades\Input::old('Western_end_point')==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- tab-pane -->
                                </div>

                                <div class="form-group  <?php if($errors->first('trip_type')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Trip Type</label>
                                    <div class="col-sm-9">
                                        <div class="row check-btn-group">
                                            <div class="col-sm-4">
                                                <div class="radio radio-block check-block @if(\Illuminate\Support\Facades\Input::old('trip_type')=='one way') selected @endif">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="trip_type" value="one way" @if(\Illuminate\Support\Facades\Input::old('trip_type')=='one way') checked @endif/>
                                                        <span>One Way</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="radio radio-block check-block @if(\Illuminate\Support\Facades\Input::old('trip_type')=='returning') selected @endif">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="trip_type" value="returning" @if(\Illuminate\Support\Facades\Input::old('trip_type')=='returning') checked @endif/>
                                                        <span>Returning</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="validator_output <?php if($errors->first('trip_type')!=null) echo "help-block"?>">{{ $errors->first('trip_type') }}</span>
                                    </div>
                                </div>
                                <div class="form-group  <?php if($errors->first('vessel_name')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Vessel Name</label>
                                    <div class="col-sm-6">
                                        <input class="form-control " data-placeholder="Vessel Name" name="vessel_name">
                                        <span class="validator_output <?php if($errors->first('vessel_name')!=null) echo "help-block"?>">{{ $errors->first('vessel_name') }}</span>
                                    </div>
                                </div>
                                <div class="form-group  <?php if($errors->first('accompanying_passenger')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Accompanying Passenger</label>
                                    <div class="col-sm-6">
                                        <input class="form-control " data-placeholder="Accompanying Passenger" name="accompanying_passenger">
                                        <span class="validator_output <?php if($errors->first('accompanying_passenger')!=null) echo "help-block"?>">{{ $errors->first('accompanying_passenger') }}</span>
                                    </div>
                                </div>
                                <div class="form-group  <?php if($errors->first('remarks')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Remarks</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="remarks"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- block about-block -->
                    </div>
                    <!-- block-wrapper -->
                    <div class="clearfix"></div>
                </div>
                <!-- boat-list wrapper -->
            </div>
        </div><!-- container -->
    </section>
@stop