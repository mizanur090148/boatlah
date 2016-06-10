@extends('user.layout')

@section('title')
    Dashboard
@stop

@section('content')
<section class="section-boat-list">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="sidebar">
                    <div class="widget owner">
                        
                        <div class="media">
                            @if($owner->user->thumb_photo!=null)
                                <img src="{{URL::asset($owner->user->thumb_photo)}}" alt="...">
                            @else
                                <img src="{{URL::asset('/images/preview.png')}}" alt="...">
                            @endif
                        </div>
                        <div class="content details">
                            <h3>{{ $owner->user->name }}</h3>
                            <p>Member since {{ $owner->created_at }}</p>
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
                                    <h5>{{ $owner->user->phone }}</h5>
                                </div>
                            </div><!-- bar -->
                            <div class="bar dtable verified">
                                <div class="icon">
                                    <i class="fa fa-gear"></i>
                                </div>
                                <div class="bar-content">
                                    <h4>Company</h4>
                                    <h5>{{ $owner->company_name }}</h5>
                                </div>
                            </div><!-- bar -->
                            <div class="bar dtable verified">
                                <div class="icon">
                                    <i class="fa fa-gear"></i>
                                </div>
                                <div class="bar-content">
                                    <h4>GST Registration</h4>
                                    <h5>{{ $owner->gst_registration }}</h5>
                                </div>
                            </div><!-- bar -->
                            <div class="bar dtable verified">
                                <div class="icon">
                                    <i class="fa fa-gear"></i>
                                </div>
                                <div class="bar-content">
                                    <h4>UEN No</h4>
                                    <h5>{{ $owner->uen_number }}</h5>
                                </div>
                            </div><!-- bar -->
                        </div><!-- content -->
                    </div><!-- widget -->
                </div><!-- sidebar -->
            </div><!-- col-md-4/ sidebar wrapper -->
            <div class="col-md-8">
                
                <div class="block-wrapper">
                    <div class="block about-block">
                        <div class="header-bar">
                            <h4><i class="fa fa-user"></i>About {{ $owner->user->name }}</h4>
                        </div><!-- list-bar -->
                        
                        <div class="content">
                            <p>{{ $owner->about }}</p>
                        </div>
                    </div><!-- block about-block -->
                    
            
                    
                    <div class="block">
                        <div class="header-bar">
                            <h4><i class="fa fa-ship"></i>Boats of {{ $owner->user->name }}</h4>
                        </div><!-- list-bar -->
                        
                        <div class="boat-items mappable">
                            @foreach($owner->user->boats as $boat)
                            <div class="single-boat dtable">
                                <div class="cell media">
                                    <a href="/boats/profile/{{ $boat->id }}"><img src="{{ $boat->photo }}" width="200px" alt="" /></a>
                                </div>
                                <div class="cell content">
                                    <h4><a href="/boats/profile/{{ $boat->id }}">{{ $boat->name }}</a></h4>
                                    <div class="info">
                                        <ul>
                                            <li>Average Speed: <span>{{ $boat->average_speed }}</span></li>
                                            <li>Capacity: <span>{{ $boat->capacity }}</span></li>
                                            <li>Operating Zone: <span>{{ $boat->operating_zone }}</span></li>
                                            <li>Manning type: <span>{{ $boat->manning_type }}</span></li>
                                        </ul>
                                    </div>
                                    <div class="boat-meta">
                                        <a href="/boats/profile/{{ $boat->id }}" class="btn btn-info btn-sm"><i class="fa fa-calendar-check-o"></i>Book now</a>
                                    </div>
                                </div><!-- content -->
                            </div><!-- single-boat -->
                            @endforeach
                        </div><!-- boat-items wrapper -->
                    </div><!-- block -->
                    
                </div><!-- block-wrapper -->
                
                <div class="clearfix"></div>
                
            </div><!-- boat-list wrapper -->
        </div><!-- row -->
    </div><!-- container -->
</section>
@stop