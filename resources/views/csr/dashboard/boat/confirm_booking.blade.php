@extends('user.layout')

@section('title')
    Book Boat
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
                    {{Form::open(array('url'=>'/csr/dashboard/post_book'))}}
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
                        <dd>{{ \App\BaseAnchorage::find($booking_info['end_point'])->title }}</dd>
                        <dt>Boat type:</dt>
                        <dd>{{ $boat->manning_type }}</dd>
                        <dt>Trip Type:</dt>
                        <dd>{{ $booking_info['trip_type'] }}</dd>
                        <dt>Cost:</dt>
                        <dd>{{$cost}} SGD</dd>
                    </dl>
                    <input type="hidden" name="boat_id" value="{{$boat->id}}">
                    <input type="hidden" name="user_id" value="{{$passenger['user_id']}}">
                    <input type="hidden" name="trip_type" value="{{ $booking_info['trip_type'] }}">
                    <input type="hidden" name="start_point" value="{{ $booking_info['start_point'] }}">
                    <input type="hidden" name="end_point" value="{{ $booking_info['end_point'] }}">
                    <input type="hidden" name="payment_status" value="{{ $booking_info['payment_status'] }}">
                    <button type="submit" class="btn btn-info">Submit</button>
                    {{Form::close()}}
                </div><!-- confirmation-info -->
            </div>
        </div><!-- row -->
    </div>
</section><!-- section-filter-page -->
@stop