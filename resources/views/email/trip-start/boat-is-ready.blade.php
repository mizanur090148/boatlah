@extends('email.layout.layout')




@section('content')

<p><strong>Hello {{$name}},</strong></p>
<div>
    <p>
        Your requested Boat for Trip#{{$trip_id}} is waiting at pickup point.
    </p>
</div>
<p> Sincerely,<br />Boatlah Team</p>
 

@endsection