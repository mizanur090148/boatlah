@extends('email.layout.layout')

@section('content')

<p><strong>Hello {{$name}},</strong></p>
<div>
	<div style="float: left; padding-right: 10px;">Thank you for request for registering @if(isset($company_name)) Your {{$company_name}} @endif on</div><img src="{{URL::asset('/images/logo.png')}}" alt="Boatlah" style="float: left; width: 45px;"><div style="clear: both;"></div>
</div>
<p>Kindly <a href="{{url('/register/verify/?code='.$confirmation_code.'&login='.$id)}}">click here,</a> to verify your mail Id and complete your registration.</p>
<p>	Sincerely,<br />Boatlah Team</p>

@endsection