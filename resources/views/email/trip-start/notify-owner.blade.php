@extends('email.layout.layout')


@section('content')

<p><strong>Hello {{$name}},</strong></p>
<div>
    <p>
        Your Boat for Trip#{{$trip_id}} has started it's trip.
    </p>
</div>
<p> Sincerely,<br />Boatlah Team</p>

@endsection