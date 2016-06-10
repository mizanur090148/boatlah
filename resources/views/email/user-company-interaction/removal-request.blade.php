@extends('email.layout.layout')

@section('content')

<p><strong>Hello {{$company_name}},</strong></p>

<div>
	<div style="float: left; padding-right: 10px;">User {{$user_name}} wants to be removed from your company on </div><img src="{{URL::asset('/images/logo.png')}}" alt="Boatlah" style="float: left; width: 45px;"><div style="clear: both;"></div>
</div>

<p>
	<a href="{{url('/company/dashboard/remove_list')}}"><b>Click here</b></a> to remove.
</p>

<p> Sincerely,<br />Boatlah Team</p>

@endsection
