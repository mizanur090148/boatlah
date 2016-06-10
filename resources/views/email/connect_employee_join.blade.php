@extends('email.layout.layout')

@section('content')

<p><strong>Hello {{$name}},</strong></p>
<div>
	<div style="float: left; padding-right: 10px;">You are requested to join with your company on </div><img src="{{URL::asset('/images/logo.png')}}" alt="Boatlah" style="float: left; width: 45px;"><div style="clear: both;"></div>
</div>
<p>Kindly <a href="{{url('/user/register')}}">click here</a> to join.</p>
<p>	Sincerely,<br />Boatlah Team</p>

@endsection