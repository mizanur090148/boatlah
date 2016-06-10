@extends('email.layout.layout')

@section('content')

<p><strong>Hello {{$name}},</strong></p>
<div>
	<div style="float: left; padding-right: 10px;">A request has recently been made to change your password on</div><img src="{{URL::asset('/images/logo.png')}}" alt="Boatlah" style="float: left; width: 45px;"><div style="clear: both;"></div>
</div>
<p>Kindly <a href="{{url('/user/reset_password/'.$id.'/'.$code)}}">click here</a> to reset your password.</p>
<p>	Sincerely,<br />Boatlah Team</p>

@endsection