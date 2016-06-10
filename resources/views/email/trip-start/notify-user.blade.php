@extends('email.layout.layout')


@section('content')
 
<p><strong>Hello {{$name}},</strong></p>
<div>
    <p>
        Your Trip#{{$trip_id}} Has Started.
    </p>
</div>
<p> Sincerely,<br />Boatlah Team</p>

@endsection