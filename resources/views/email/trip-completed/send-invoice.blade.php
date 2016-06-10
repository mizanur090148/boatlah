@extends('email.layout.layout')


@section('content')

<p><strong>Hello {{$name}},</strong></p>
<div>
    <p>
        Thanks for taking that journey with us!
    </p>
    <p>
        Trip#{{$trip_id}}
    </p>
    <p> 
        Trip Invoice.  <a href="{{url('/trip_invoice/download/'.$trip_id)}}">Click to download</a>
    </p>
</div>

@endsection