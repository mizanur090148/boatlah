@extends('email.layout.layout')

@section('content')

	<p><strong>Hello {{$name}},</strong></p>
	
    <p>
        Your advanced booking has been confirmed.
    </p>

    <p>
        Thank you,<br/>BoatLah.com Team
    </p>

@endsection