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

                                {{Form::open(array('url'=>'/coordinator/dashboard/post_book_boat', 'method'=>'POST', 'class'=>'filter-search-form form-horizontal advance-book-form'))}}
                                <input type="hidden" name="user_id" value="{{$user_id}}">
                                <input type="hidden" name="boat_id" value="{{$boat->id}}">
                                <input type="hidden" name="zone" value="{{$boat->operating_zone}}">

                                <div class="form-group">
                                    <label class="control-label col-sm-3">Boat Name</label>
                                    <div class="col-sm-6">
                                        <p>{{$boat->name}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Boat Type</label>
                                    <div class="col-sm-6">
                                        <p>{{$boat->manning_type}}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3">Zone</label>
                                    <div class="col-sm-6">
                                        <p>{{$boat->operating_zone}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Start Point</label>
                                    <div class="col-sm-6">
                                        <select class="form-control east-destination chosen"
                                                data-placeholder="Start Point" name="start_point">
                                            @foreach($anchorages as $anchorage)
                                                <option value="{{ $anchorage->id }}"
                                                        @if(\Illuminate\Support\Facades\Input::old('start_point')==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Destination Point </label>

                                    <div class="col-sm-6">
                                        <select class="form-control east-destination chosen"
                                                data-placeholder="Destination Point " name="end_point">
                                            @foreach($anchorages as $anchorage)
                                                <option value="{{ $anchorage->id }}"
                                                        @if(\Illuminate\Support\Facades\Input::old('end_point')==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group  <?php if ($errors->first('trip_type') != null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Trip Type</label>

                                    <div class="col-sm-9">
                                        <div class="row check-btn-group">
                                            <div class="col-sm-4">
                                                <div class="radio radio-block check-block">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="trip_type"
                                                               value="one way"/>
                                                        <span>One Way</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="radio radio-block check-block">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="trip_type"
                                                               value="returning"/>
                                                        <span>Returning</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="validator_output <?php if ($errors->first('trip_type') != null) echo "help-block"?>">{{ $errors->first('trip_type') }}</span>
                                    </div>
                                </div>

                                <div class="form-group  <?php if ($errors->first('payment_status') != null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Paid?</label>

                                    <div class="col-sm-9">
                                        <div class="row check-btn-group">
                                            <div class="col-sm-4">
                                                <div class="radio radio-block check-block">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="payment_status"
                                                               value="unpaid"/>
                                                        <span>unpaid</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="radio radio-block check-block">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="payment_status"
                                                               value="paid"/>
                                                        <span>paid</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="validator_output <?php if ($errors->first('payment_status') != null) echo "help-block"?>">{{ $errors->first('payment_status') }}</span>
                                    </div>
                                </div>
                                <div class="form-group  <?php if($errors->first('vessel_name')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Vessel Name</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="vessel_name" value="{{old('vessel_name')}}">
                                        <span class="validator_output <?php if($errors->first('vessel_name')!=null) echo "help-block"?>">{{ $errors->first('vessel_name') }}</span>
                                    </div>
                                </div>

                                <div class="form-group  <?php if($errors->first('accompanying_passenger')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Accompanying Passenger</label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="accompanying_passenger" value="{{old('accompanying_passenger')}}">
                                        <span class="validator_output <?php if($errors->first('accompanying_passenger')!=null) echo "help-block"?>">{{ $errors->first('accompanying_passenger') }}</span>
                                    </div>
                                </div>

                                <div class="form-group  <?php if($errors->first('remarks')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Remarks</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="remarks">{{old('remarks')}}</textarea>
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