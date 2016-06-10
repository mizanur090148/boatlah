@extends('admin.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/formvalidation/formValidation.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/forms/validation.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/global/vendor/select2/select2.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/forms/advanced.css')}}">
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title"><i class="site-menu-icon fa-ship" aria-hidden="true"></i> Boats</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li><a href="{{ url('/admin/boats') }}">Boats</a></li>
            <li class="active"><a>Create New</a></li>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Panel Summary Mode -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add New</h3>
                    </div>
                    <div class="panel-body">
                        {{Form::open(array('url'=>'/admin/boats', 'files'=>true,'id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal'))}}

                        <div class="form-group form-material <?php if ($errors->first('name') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Boat name <span>*</span></label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name"
                                       value="{{\Illuminate\Support\Facades\Input::old('name')}}"/>
                                <span class="validator_output <?php if ($errors->first('name') != null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if ($errors->first('company_name') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Company name <span>*</span></label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="company_name"
                                       value="{{\Illuminate\Support\Facades\Input::old('company_name')}}"/>
                                <span class="validator_output <?php if ($errors->first('company_name') != null) echo "help-block"?>">{{ $errors->first('company_name') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if ($errors->first('registration_no') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Harbourcraft License No: <span>*</span></label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="registration_no" data-plugin="datepicker"
                                       value="{{\Illuminate\Support\Facades\Input::old('registration_no')}}"/>
                                <span class="validator_output <?php if ($errors->first('registration_no') != null) echo "help-block"?>">{{ $errors->first('registration_no') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if ($errors->first('date_of_registration') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Registration Date <span>*</span></label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="date_of_registration"
                                       data-plugin="datepicker"
                                       value="{{\Illuminate\Support\Facades\Input::old('date_of_registration')}}"/>
                                <span class="validator_output <?php if ($errors->first('date_of_registration') != null) echo "help-block"?>">{{ $errors->first('date_of_registration') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if ($errors->first('about') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">About</label>

                            <div class="col-sm-9">
                                <textarea class="form-control" name="about" rows="5"></textarea>
                                <span class="validator_output <?php if ($errors->first('about') != null) echo "help-block"?>">{{ $errors->first('invoice_bank_details') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if ($errors->first('habourcraft_number') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Habourcraft Number</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="habourcraft_number"
                                       value="{{\Illuminate\Support\Facades\Input::old('habourcraft_number')}}"/>
                                <span class="validator_output <?php if ($errors->first('habourcraft_number') != null) echo "help-block"?>">{{ $errors->first('habourcraft_number') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if ($errors->first('license') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">License</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="license"
                                       value="{{\Illuminate\Support\Facades\Input::old('license')}}"/>
                                <span class="validator_output <?php if ($errors->first('license') != null) echo "help-block"?>">{{ $errors->first('license') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if ($errors->first('license_date') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">License Date</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="license_date"
                                       value="{{\Illuminate\Support\Facades\Input::old('license_date')}}"/>
                                <span class="validator_output <?php if ($errors->first('license_date') != null) echo "help-block"?>">{{ $errors->first('license_date') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if ($errors->first('manning_type') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Manning Type <span>*</span></label>

                            <div class="col-sm-9">
                                <select name="manning_type" class="form-control">
                                    <option value="">Please Select One</option>
                                    <option value="one manned"
                                            @if(\Illuminate\Support\Facades\Input::old('manning_type')=="one manned") selected @endif>
                                        One Manned
                                    </option>
                                    <option value="two manned"
                                            @if(\Illuminate\Support\Facades\Input::old('manning_type')=="two manned") selected @endif>
                                        Two Manned
                                    </option>
                                </select>

                                <span class="validator_output <?php if ($errors->first('manning_type') != null) echo "help-block"?>">{{ $errors->first('manning_type') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if ($errors->first('average_speed') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Average Speed (Knots)</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="average_speed"
                                       value="{{\Illuminate\Support\Facades\Input::old('average_speed')}}"/>
                                <span class="validator_output <?php if ($errors->first('average_speed') != null) echo "help-block"?>">{{ $errors->first('average_speed') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if ($errors->first('capacity') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Capacity</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="capacity"
                                       value="{{\Illuminate\Support\Facades\Input::old('capacity')}}"/>
                                <span class="validator_output <?php if ($errors->first('capacity') != null) echo "help-block"?>">{{ $errors->first('capacity') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if ($errors->first('photo') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Image</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Browse.." readonly=""/>
                                <input type="file" id="photo" name="photo" multiple=""/>
                                <span class="validator_output <?php if ($errors->first('photo') != null) echo "help-block"?>">{{ $errors->first('photo') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if ($errors->first('status') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Status</label>

                            <div class="col-sm-9">
                                <select name="status" class="form-control">
                                    <option value="">Please Select One</option>
                                    <option value="available"
                                            @if(\Illuminate\Support\Facades\Input::old('status')=="available") selected @endif>
                                        Available
                                    </option>
                                    <option value="off-duty"
                                            @if(\Illuminate\Support\Facades\Input::old('status')=="off-duty") selected @endif>
                                        Off-duty
                                    </option>
                                    <option value="busy"
                                            @if(\Illuminate\Support\Facades\Input::old('status')=="busy") selected @endif>
                                        Busy
                                    </option>
                                    <option value="booked"
                                            @if(\Illuminate\Support\Facades\Input::old('status')=="booked") selected @endif>
                                        Booked
                                    </option>
                                </select>
                                <span class="validator_output <?php if ($errors->first('status') != null) echo "help-block"?>">{{ $errors->first('status') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if ($errors->first('operating_zone') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Operating Zone <span>*</span></label>

                            <div class="col-sm-9">
                                <select name="operating_zone" class="form-control" id="zone">
                                    <option value="">Please Select One</option>
                                    <option value="Eastern"
                                            @if(\Illuminate\Support\Facades\Input::old('operating_zone')=="Eastern") selected @endif>
                                        Western
                                    </option>
                                    <option value="Western"
                                            @if(\Illuminate\Support\Facades\Input::old('operating_zone')=="Western") selected @endif>
                                        Eastern
                                    </option>
                                </select>
                                <span class="validator_output <?php if ($errors->first('operating_zone') != null) echo "help-block"?>">{{ $errors->first('status') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if ($errors->first('anchorage_id') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Anchorage <span>*</span></label>

                            <div class="col-sm-9">
                                <select type="text" name="anchorage_id" id="anchorage" class="form-control">
                                    @if(Illuminate\Support\Facades\Input::old('anchorage_id'))
                                        <?php $point = \App\BaseAnchorage::find(Illuminate\Support\Facades\Input::old('anchorage_id'));?>
                                        <option value="{{$point->id}}">{{$point->title}}</option>
                                    @else
                                        <option value=""> Choose Anchorage</option>
                                    @endif
                                </select>
                                <span class="validator_output <?php if ($errors->first('anchorage_id') != null) echo "help-block"?>">{{ $errors->first('anchorage_id') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if ($errors->first('boat_owner_id') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Boat Owner</label>

                            <div class="col-sm-9">
                                <select type="text" name="boat_owner_id" class="form-control">
                                    <option value=""> Choose One Owner <span>*</span></option>
                                    @foreach($boat_owner_profiles as $boat_owner_profile)

                                        <option value="{{$boat_owner_profile->user_id}}"
                                                @if(Illuminate\Support\Facades\Input::old('boat_owner_id')==$boat_owner_profile->user_id) selected @endif>{{$boat_owner_profile->user->name}}
                                            ( {{$boat_owner_profile->user->email}}, phone
                                            : {{$boat_owner_profile->user->phone}} )
                                        </option>
                                    @endforeach
                                </select>
                                <span class="validator_output <?php if ($errors->first('boat_owner_id') != null) echo "help-block"?>">{{ $errors->first('boat_owner_id') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if ($errors->first('boat_captain_id') != null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Boat Captain</label>

                            <div class="col-sm-9">
                                <select type="text" name="boat_captain_id[]" class="form-control" multiple
                                        data-plugin="select2">
                                    @foreach($captains as $captain)
                                        <option value="{{$captain->user_id}}"
                                                @if(Illuminate\Support\Facades\Input::old('boat_captain_id')==$captain->user_id) selected @endif>{{$captain->user->name}}</option>
                                    @endforeach
                                </select>
                                <span class="validator_output <?php if ($errors->first('boat_captain_id') != null) echo "help-block"?>">{{ $errors->first('boat_captain_id') }}</span>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" id="validateButton3">Submit</button>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
                <!-- End Panel Summary Mode -->
            </div>
        </div>

    </div>


@stop

@section('footer')

    <script src="{{ asset('admin/global/vendor/select2/select2.full.min.js')}}"></script>
    <script src="{{ asset('admin/global/js/components/select2.js')}}"></script>
    <script src="{{ asset('admin/assets/examples/js/forms/advanced.js')}}"></script>
    <script>
        $("#zone").on('change', function (e) {
            console.log(e);
//document.write('hello');
            var zone = e.target.value;
            $.get('/ajax_anchorage?zone=' + zone, function (data) {
                $('#anchorage').empty();
                $.each(data, function (index, subcatObj) {
                    $('#anchorage').append('<option value="' + subcatObj.id + '">' + subcatObj.title + '</option>');
                })

            });
        });
    </script>
@endsection