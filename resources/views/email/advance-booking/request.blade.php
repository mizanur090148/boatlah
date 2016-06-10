@extends('email.layout.layout')

@section('content')
    
    
    <p><strong>Hello {{$name}},</strong></p>

    <h2>You have a new advanced booking request.</h2>

    <h4>Booking Id : <a href="">{{$booking_id}}</a></h4>

    <p>
        Trip Type : {{$trip_type}}
    </p>
    <p>
        Boat Type : {{$boat_type}}
    </p>
    <p>
        Number Of Boats : {{$number_of_boats}}
    </p>
    <p>
        Start Point : {{$start_point_id}}
    </p>
    <p>
        Destination Point : {{$destination_point_id}}
    </p>

    <a href="{{url('/owner/dashboard/my-advance-bookings')}}">Click here</a> to approve the Booking.

    <p>
        Thank you,<br/>BoatLah.com Team
    </p>
    
@endsection