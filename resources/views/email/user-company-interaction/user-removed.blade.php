@extends('email.layout.layout')

@section('content')

<p><strong>Hello {{$user_name}},</strong></p>

<div>
	<div style="float: left; padding-right: 10px;">Company {{$company_name}} removed you from their company on </div><img src="{{URL::asset('/images/logo.png')}}" alt="Boatlah" style="float: left; width: 45px;"><div style="clear: both;"></div>
</div>

<p>
	<a href="{{url('/user/dashboard/company')}}"><b>Click here</b></a> to browse.
</p>

<p> Sincerely,<br />Boatlah Team</p>

@endsection
