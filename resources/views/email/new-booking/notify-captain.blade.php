@extends('email.layout.layout')

@section('content')

<p><strong>Hello {{$name}},</strong></p>

<p>
    You have a new Trip
</p>

<p>
    Trip Id : {{$trip_id}} 
</p>

<p> Sincerely,<br />Boatlah Team</p>

@endsection