@extends('user.layout')

@section('title')
    CSR Dashboard
@stop

@section('content')
    <section class="section-reg-details">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="confirmation-info">
                        <h4>Booking details</h4>
                        @if($trip!=null)
                        <dl class="dl-horizontal">
                            <dt>Trip ID:</dt>
                            <dd>{{ $trip->trip_id }}</dd>
                            <dt>Boat Name:</dt>
                            <dd>{{$trip->boat->name}}</dd>
                            <dt>Start Point:</dt>
                            <dd>{{$trip->start->title}}</dd>
                            <dt>Destination Point:</dt>
                            <dd>{{$trip->destination->title}}</dd>
                            <dt>Boat type:</dt>
                            <dd>{{ $trip->boat->manning_type }}</dd>
                            <dt>Cost:</dt>
                            <dd>{{$trip->cost}} SGD</dd>
                        </dl>
                        @endif
                        <a href="/csr/dashboard/users" class="btn btn-info">OK</a>
                    </div><!-- confirmation-info -->
                </div>
            </div><!-- row -->
        </div>
    </section><!-- section-filter-page -->
@stop