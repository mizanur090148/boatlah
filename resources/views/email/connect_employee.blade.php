@extends('email.layout.layout')

@section('content')

<p><strong>Hello {{$name}},</strong></p>
<div>
	<div style="float: left; padding-right: 10px;">Your employee was connected successfully. on </div><img src="{{URL::asset('/images/logo.png')}}" alt="Boatlah" style="float: left; width: 45px;"><div style="clear: both;"></div>
</div>
<p>	Sincerely,<br />Boatlah Team</p>

@endsection