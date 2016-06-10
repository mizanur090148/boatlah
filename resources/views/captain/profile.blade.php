@extends('user.layout')

@section('title')
    Captain Profile
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget owner">
                            
                            <div class="media">
                                @if($captain->photo_thumb!=null)
                                    <img src="{{URL::asset($captain->photo_thumb)}}" alt="...">
                                @else
                                    <img src="{{URL::asset('/images/preview.png')}}" alt="...">
                                @endif
                            </div>
                            <div class="content details">
                                <h3>{{ $captain->user->name }}</h3>
                                
                            </div>
                        </div><!-- widget -->
                        
                        
                        <div class="widget widget-verification">
                            <div class="header-bar">
                                <h4><i class="fa fa-check"></i>Info</h4>
                            </div>
                            
                            <div class="content">
                                <div class="bar dtable verified">
                                    <div class="icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="bar-content">
                                        <h4>Phone</h4>
                                        <h5>{{ $captain->user->phone }}</h5>
                                    </div>
                                </div><!-- bar -->
                                <div class="bar dtable verified">
                                    <div class="icon">
                                        <i class="fa fa-gear"></i>
                                    </div>
                                    <div class="bar-content">
                                        <h4>Years boating</h4>
                                        <h5>{{ $captain->years_of_boating }}</h5>
                                    </div>
                                </div><!-- bar -->
                                <div class="bar dtable verified">
                                    <div class="icon">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                    <div class="bar-content">
                                        <h4>NRIC ID</h4>
                                        <h5>{{ $captain->nric }}</h5>
                                    </div>
                                </div><!-- bar -->
                            </div>
                        </div><!-- widget -->
                    </div><!-- sidebar -->
                </div><!-- sidebar wrapper -->
                <div class="col-md-9 xol-sm-8">
                    
                    <div class="block-wrapper">
                        <div class="block about-block">
                            <div class="header-bar">
                                <h4><i class="fa fa-user"></i>About {{ $captain->user->name }}</h4>
                            </div><!-- list-bar -->
                            
                            <div class="content">
                                <p>{{ $captain->about }}</p>
                            </div>
                        </div><!-- block about-block -->
                        
                        
                        
                        <div class="block">
                            <div class="header-bar">
                                <h4><i class="fa fa-ship"></i>Trip History of {{ $captain->user->name }}</h4>
                            
                                
                            </div><!-- list-bar -->
                            
                            <div class="trip-history table-responsive">
                                <table class="table table-striped table-bordered datatable">
                                    <thead>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Trip ID</th>
                                            <th>PickUp Point</th>
                                            <th>Drop-off Point</th>
                                            <th>Trip Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($trips as $trip)
                                        <tr>
                                            <td>{{$trip->user->name}}</td>
                                            <td>{{$trip->trip_id}}</td>
                                            <td>{{$trip->start->title}}</td>
                                            <td>{{$trip->destination->title}}</td>
                                            <td>{{$trip->trip_date}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- block -->
                        
                    </div><!-- block-wrapper -->
                        
                
                    
                    <div class="clearfix"></div>
                    
                    
                </div><!-- boat-list wrapper -->
            </div><!-- row -->
        </div><!-- container -->
    </section>
@stop