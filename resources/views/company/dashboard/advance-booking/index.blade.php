@extends('user.layout')

@section('title')
    Company Dashboard
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            @include('company.dashboard.common.breadcrumb')
                    <!-- breadcrumbs -->
            <div class="row">
                <!-- sidebar wrapper -->
                <div class="col-sm-12">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-bookmark"></i> Advance Booking
                                    <a href="/company/dashboard/" class="pull-right rb-edit go-my-book">Go Back <i class="fa fa-angle-right"></i></a>
                                </h4>
                            </div>
                            <div class="padel-box-body">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="nav-books">
                                            <li class="active"><a href="">New Advance booking</a></li>
                                            <li><a href="/company/dashboard/my-advance-bookings">My Advance booking</a></li>
                                        </ul>
                                    </div>
                                </div>


                                {{Form::open(array('url'=>'/company/dashboard/advance-booking', 'method'=>'POST', 'class'=>'filter-search-form form-horizontal advance-book-form'))}}

                                <div class="form-group  <?php if($errors->first('user_id')!=null) echo "has-error"?>" id="myEmployee" style="display: none;">
                                    <label class="control-label col-sm-3">Employee Name</label>
                                    <div class="col-sm-6">
                                        <select class="form-control east-destination chosen" data-placeholder="Employee Name" name="user_id">
                                            @foreach($boat_users as $boat_user)
                                                <option value="{{ $boat_user->user_id }}" @if(\Illuminate\Support\Facades\Input::old('user_id')==$boat_user->user_id) selected @endif>{{ $boat_user->user->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="validator_output <?php if($errors->first('user_id')!=null) echo "help-block"?>">{{ $errors->first('user_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group  <?php if($errors->first('owner_user_id')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Boat Owner</label>
                                    <div class="col-sm-9">
                                        <select class="form-control east-destination chosen" data-placeholder="Boat Owner Name" name="owner_user_id">
                                            @foreach($contracted_owners as $owner)
                                                <option value="{{ $owner->owner_id }}" @if(\Illuminate\Support\Facades\Input::old('owner_user_id')==$owner->owner_id) selected @endif>{{ $owner->owner->user->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="validator_output <?php if($errors->first('owner_user_id')!=null) echo "help-block"?>">{{ $errors->first('owner_user_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group  <?php if($errors->first('booking_date')!=null||$errors->first('booking_time')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Journey Date</label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input class="form-control datepicker" id="booking_date" name="booking_date" placeholder="Date" type="text" value="{{\Illuminate\Support\Facades\Input::old('booking_date')}}" required>
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
                                <div class="form-group  <?php if($errors->first('boat_type')!=null) echo "has-error"?>">
                                    <label class="control-label col-sm-3">Boat Type</label>
                                    <div class="col-sm-9">
                                        <div class="row check-btn-group">
                                            <div class="col-sm-6">
                                                <div class="radio radio-block check-block @if(\Illuminate\Support\Facades\Input::old('boat_type')=='two manned') selected @endif">
                                                    <label>
                                                        <input class="check-btn" type="radio" name="additional_boatman" value="yes" @if(\Illuminate\Support\Facades\Input::old('boat_type')=='two manned') checked @endif/>
                                                        <span><i class="fa fa-user-plus"></i>Additional Boatman</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="validator_output <?php if($errors->first('boat_type')!=null) echo "help-block"?>">{{ $errors->first('boat_type') }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3 pt-0">Location type</label>
                                    <div class="col-sm-9">
                                        <div class="me-radio-inline">
                                            <label class="radio-inline">
                                                <input type="radio" name="locationType" id="singleLocRadio" value="" checked="checked"> Single Location
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="locationType" id="multiLocRadio" value="option3"> Multiple Location
                                            </label>                                           
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-sm-offset-3 mt-20">
                                        <div class="table-responsive me-loc-table-hold">
                                            <table class="table me-location-table">
                                                <thead>
                                                    <tr>
                                                        <th>Origin</th>
                                                        <th>Destination</th>
                                                        <th>Vessel Name</th>
                                                        <th>Accompanying Passenger Name</th>
                                                        <th>Remarks</th>
                                                        <th>Principal</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select class="form-control select-styled" id="origin1" name="">
                                                                <option>Select one</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control select-styled" id="destination1" name="">
                                                                <option>Select one</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" class="form-control" id="vessel1"></td>
                                                        <td><input type="text" class="form-control" id="passenger1"></td>
                                                        <td><input type="text" class="form-control" id="remarks1"></td>
                                                        <td>
                                                            <select class="form-control select-styled" id="principal1">
                                                                <option>Principal one</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <a href="javascript: ;" class="me-addrow" id="remove1"><i class="fa fa-plus"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3 pt-0">Booking for</label>
                                    <div class="col-sm-9">
                                        <div class="me-radio-inline">
                                            <label class="radio-inline">
                                                <input type="radio" checked="checked" name="tab__bookings" data-target="#tab__self" value="Self"> Self
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="tab__bookings" data-target="#tab__employee" value="Employee"> Employee
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="tab__bookings" data-target="#tab__guest" value="Guest"> Guest
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-sm-offset-3 pt-20">
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="tab__self">

                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tab__employee">
                                                <select class="form-control chosen" data-placeholder="Boat User" name="">
                                                    <option value="Admin" selected="selected">Admin</option>
                                                </select>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tab__guest">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" placeholder="Passenger Name">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="email" class="form-control" placeholder="Email">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" placeholder="Phone">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3 col-sm-offset-9">
                                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
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


@section('footer_scripts')
    <script>
        function user(value) {
            if (value == 0) {
                document.getElementById('myEmployee').style.display = 'none';
            }
            else if (value == 1) {
                document.getElementById('myEmployee').style.display = 'block';
            }
        }


        $(function(){
        $('input[name="tab__bookings"]').click(function () {
            $(this).tab('show');
        });
      })

      $(function(){
          $(".me-location-table").on('click', '.me-addrow', function() {
            var $tr = $(this).closest('tr');
            var allTrs = $tr.closest('table').find('tr');
            var lastTr = allTrs[allTrs.length-1];
            var $clone = $(lastTr).clone();
            $clone.find('td').each(function(){
                var el = $(this).find(':first-child');
                var id = el.attr('id') || null;
                if(id) {
                    var i = id.substr(id.length-1);
                    var prefix = id.substr(0, (id.length-1));
                    el.attr('id', prefix+(+i+1));
                    el.attr('name', prefix+(+i+1));
                }
            });
            $clone.addClass('appended');
            $tr.closest('.me-location-table').append($clone);
        });
      });

      $(function(){
        $(".me-addrow").hide();
        $("label input").change(function(){
            if($("#multiLocRadio").is(":checked")){
                $(".me-addrow").show();
                $("tr.appended").show();
            }else {
                $(".me-addrow").hide();
                $("tr.appended").hide();
            }
        });
      });

    </script>
@endsection