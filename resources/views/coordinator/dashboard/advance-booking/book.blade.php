@extends('user.layout')

@section('title')
    Coordinator Dashboard
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            @include('coordinator.dashboard.common.breadcrumb')
                    <!-- breadcrumbs -->
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('coordinator.dashboard.common.sidemenu')
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
                                <h4 class="clearfix padel-title"><i class="fa fa-bookmark"></i> Book Boat
                                </h4>
                            </div>
                            <div class="padel-box-body">

                                {{Form::open(array('url'=>'/coordinator/dashboard/my-advance-bookings/postBook', 'method'=>'POST', 'class'=>'filter-search-form form-horizontal advance-book-form'))}}
                               <input type="hidden" name="user_id" value="{{$booking->user_id}}">
                               <input type="hidden" name="owner_id" value="{{$booking->owner_user_id}}">

                                <div class="form-group  <?php if($errors->first('boat_id')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Boat Name</label>
                                    <div class="col-sm-6">
                                        <select class="form-control east-destination chosen" data-placeholder="Boat Name" name="boat_id[]"  multiple
                                                data-plugin="select2">
                                            @if($boats!='[]')
                                                @foreach($boats as $boat)
                                                    <option value="{{ $boat->id }}" >{{ $boat->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span class="validator_output <?php if($errors->first('boat_id')!=null) echo "help-block"?>">{{ $errors->first('boat_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group  <?php if($errors->first('boat_type')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Boat Type</label>
                                    <div class="col-sm-9">
                                        <div class="row check-btn-group">
                                            <div class="col-sm-4">
                                                <div class="radio radio-block check-block @if(\Illuminate\Support\Facades\Input::old('boat_type',$booking->boat_type)=='one manned') selected @endif">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="boat_type" value="one manned" @if(\Illuminate\Support\Facades\Input::old('boat_type',$booking->boat_type)=='one manned') checked @endif/>
                                                        <span><i class="fa fa-user"></i>One manned</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="radio radio-block check-block @if(\Illuminate\Support\Facades\Input::old('boat_type',$booking->boat_type)=='two manned') selected @endif">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="boat_type" value="two manned" @if(\Illuminate\Support\Facades\Input::old('boat_type',$booking->boat_type)=='two manned') checked @endif/>
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
                                                    <a href="#east-zone" data-toggle="tab" class="btn btn-info @if(!\Illuminate\Support\Facades\Input::old('zone')) active @else @if(\Illuminate\Support\Facades\Input::old('zone',$booking->start->type)=='Eastern') active @endif @endif ">
                                                        <input type="radio" name="zone" id="zone1" autocomplete="off" value="Eastern" checked> Eastern
                                                    </a>
                                                    <a href="#west-zone" data-toggle="tab" class="btn btn-info @if(\Illuminate\Support\Facades\Input::old('zone',$booking->start->type)=='Western') active @endif">
                                                        <input type="radio" name="zone" id="zone2" value="Western" autocomplete="off"> Western
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade @if(!\Illuminate\Support\Facades\Input::old('zone')) in  active @endif @if(\Illuminate\Support\Facades\Input::old('zone',$booking->start->type)=='Eastern')in  active @endif" id="east-zone">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Start Point</label>
                                            <div class="col-sm-6">
                                                <select class="form-control east-destination chosen" data-placeholder="Start Point" name="Eastern_start_point">
                                                    @foreach($Eastern_anchorages as $anchorage)
                                                        <option value="{{ $anchorage->id }}" @if(\Illuminate\Support\Facades\Input::old('Eastern_start_point',$booking->start_point_id)==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Destination Point </label>
                                            <div class="col-sm-6">
                                                <select class="form-control east-destination chosen" data-placeholder="Destination Point " name="Eastern_end_point">
                                                    @foreach($Eastern_anchorages as $anchorage)
                                                        <option value="{{ $anchorage->id }}"  @if(\Illuminate\Support\Facades\Input::old('Eastern_end_point',$booking->destination_point_id)==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- tab-pane -->
                                    <div class="tab-pane fade @if(\Illuminate\Support\Facades\Input::old('zone',$booking->start->type)=='Western')in  active @endif" id="west-zone">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Start Point</label>
                                            <div class="col-sm-6">
                                                <select class="form-control east-destination chosen" data-placeholder="Start Point" name="Western_start_point">
                                                    @foreach($Western_anchorages as $anchorage)
                                                        <option value="{{ $anchorage->id }}" @if(\Illuminate\Support\Facades\Input::old('Western_start_point',$booking->start_point_id)==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Destination Point </label>
                                            <div class="col-sm-6">
                                                <select class="form-control east-destination chosen" data-placeholder="Destination Point " name="Western_end_point">
                                                    @foreach($Western_anchorages as $anchorage)
                                                        <option value="{{ $anchorage->id }}" @if(\Illuminate\Support\Facades\Input::old('Western_end_point',$booking->destination_point_id)==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
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
                                                <div class="radio radio-block check-block @if(\Illuminate\Support\Facades\Input::old('trip_type',$booking->trip_type)=='one way') selected @endif">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="trip_type" value="one way" @if(\Illuminate\Support\Facades\Input::old('trip_type',$booking->trip_type)=='one way') checked @endif/>
                                                        <span>One Way</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="radio radio-block check-block @if(\Illuminate\Support\Facades\Input::old('trip_type',$booking->trip_type)=='returning') selected @endif">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="trip_type" value="returning" @if(\Illuminate\Support\Facades\Input::old('trip_type',$booking->trip_type)=='returning') checked @endif/>
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
                                        <input class="form-control" name="vessel_name" value="{{old('vessel_name',$booking->vessel_name)}}">
                                        <span class="validator_output <?php if($errors->first('vessel_name')!=null) echo "help-block"?>">{{ $errors->first('vessel_name') }}</span>
                                    </div>
                                </div>

                                <div class="form-group  <?php if($errors->first('accompanying_passenger')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Accompanying Passenger</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="accompanying_passenger" value="{{old('accompanying_passenger',$booking->accompanying_passenger)}}">
                                        <span class="validator_output <?php if($errors->first('accompanying_passenger')!=null) echo "help-block"?>">{{ $errors->first('accompanying_passenger') }}</span>
                                    </div>
                                </div>

                                <div class="form-group  <?php if($errors->first('remarks')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Remarks</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="remarks">{{old('remarks',$booking->remarks)}}</textarea>
                                        <span class="validator_output <?php if($errors->first('remarks')!=null) echo "help-block"?>">{{ $errors->first('remarks') }}</span>
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