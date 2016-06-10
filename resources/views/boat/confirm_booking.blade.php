@extends('user.layout')

@section('title')
    Boook Boat
@stop

@section('content')
<section class="section-reg-details">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="confirmation-info">
                    <h4>Confirm details</h4>
                    <div class="media">
                        <img src="{{ asset($boat->thumb_photo) }}" alt="" />
                    </div>
                    {{Form::open(array('url'=>'/boats/book'))}}
                    <dl class="dl-horizontal">
                        <dt>Boat ID:</dt>
                        <dd>{{ $boat->unique_id }}</dd>
                        <dt>Operating Zone</dt>
                        <dd>
                        {{$boat->operating_zone}}
                        </dd>
                        <dt>Start Pont:</dt>
                        <dd>{{ \App\BaseAnchorage::find($booking_info['start_point'])->title }}</dd>
                        <dt>Destination Pont:</dt>
                        <dd>{{ \App\BaseAnchorage::find($booking_info['destination_point'])->title }}</dd>
                        <dt>Boat type:</dt>
                        <dd>{{ $boat->manning_type }}</dd>
                        <dt>Trip Type:</dt>
                        <dd>{{ $booking_info['trip_type'] }}</dd>
                        <dt>Vessel Name:</dt>
                        <dd>{{ $booking_info['vessel_name'] }}</dd>
                        <dt>Accompanying Passenger:</dt>
                        <dd>{{ $booking_info['accompanying_passenger'] }}</dd>
                        <dt>Remarks:</dt>
                        <dd>{{ $booking_info['remarks'] }}</dd>
                        @if( $booking_info['for_who']==2)
                        <dt>Passenger Name:</dt>
                        <dd>{{ $booking_info['other_passenger_name'] }}</dd>
                        <dt>Email:</dt>
                        <dd>{{ $booking_info['other_email'] }}</dd>
                        <dt>Phone:</dt>
                        <dd>{{ $booking_info['other_phone'] }}</dd>
                        @endif
                        <dt>Payment Method:</dt>
                        <dd>{{$payment_method}}</dd>
                        <dt>Cost:</dt>
                        <dd>{{$cost}} SGD</dd>
                    </dl>
                    
                    <input type="hidden" name="boat_id" value="{{$boat->id}}">
                    <input type="hidden" name="passenger_user_id" value="{{$passenger['user_id']}}">
                    <input type="hidden" name="trip_type" value="{{ $booking_info['trip_type'] }}">
                    <input type="hidden" name="start_point" value="{{ $booking_info['start_point'] }}">
                    <input type="hidden" name="destination_point" value="{{ $booking_info['destination_point'] }}">
                    <input type="hidden" name="operating_zone" value="{{ $boat->operating_zone}}">
                    <input type="hidden" name="vessel_name" value="{{ $booking_info['vessel_name'] }}">
                    <input type="hidden" name="accompanying_passenger" value="{{ $booking_info['accompanying_passenger'] }}">
                    <input type="hidden" name="remarks" value="{{ $booking_info['remarks'] }}">
                    <input type="hidden" name="for_who" value="{{ $booking_info['for_who'] }}">
                   
                    @if( $booking_info['for_who']==2)
                    <input type="hidden" name="other_passenger_name" value="{{ $booking_info['other_passenger_name'] }}">
                    <input type="hidden" name="other_email" value="{{ $booking_info['other_email'] }}">
                    <input type="hidden" name="other_phone" value="{{ $booking_info['other_phone'] }}">
                    @endif
                    
                    <button type="submit" class="btn btn-info">Submit</button>
                    {{Form::close()}}
                </div><!-- confirmation-info -->
            </div>
        </div><!-- row -->
    </div>
</section><!-- section-filter-page -->
@stop