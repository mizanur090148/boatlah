@extends('email.layout.layout')

@section('content')

<p><strong>Hello {{$name}},</strong></p>

<p> Congratulations! </p>

<div>
	<div style="float: left; padding-right: 10px;"> Your account was successfully approved by Admin on </div><img src="{{URL::asset('/images/logo.png')}}" alt="Boatlah" style="float: left; width: 45px;"><div style="clear: both;"></div>
</div>
<p>
	<a href="{{url('/login')}}"><b>Click here</b></a> to start using. 
</p>

<p>	Sincerely,<br />Boatlah Team</p>

@endsection