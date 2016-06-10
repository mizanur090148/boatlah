@extends('email.layout.layout')


@section('content')

<p><strong>Hello {{$name}},</strong></p>

<div>
    <div style="float: left; padding-right: 10px;"> Thanks for booking a boat with </div><img src="{{URL::asset('/images/logo.png')}}" alt="Boatlah" style="float: left; width: 45px;"><div style="clear: both;"></div>
</div>

<p>
    Trip Id : {{$trip_id}} 
</p>

<p>
    You will get notifications soon when the boat arrives.
</p>

<p> Sincerely,<br />Boatlah Team</p>

@endsection