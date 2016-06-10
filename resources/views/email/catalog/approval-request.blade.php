@extends('email.layout.layout')

@section('content')

<p><strong>Hello {{$name}},</strong></p>

<p>
You have a new catalog approval request. Please follow the link below to approve your catalog
<br /><a href="{{url('/company/dashboard/catalogs')}}">Activate Catalog</a>
</p>

<p> Sincerely,<br />Boatlah Team</p>

@endsection