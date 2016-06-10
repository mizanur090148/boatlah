@extends('user.layout')

@section('title')
    Owner Dashboard
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            @include('owner.dashboard.common.breadcrumb')
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('owner.dashboard.common.sidemenu')
                        </div><!-- widget -->
                    </div><!-- sidebar -->
                </div><!-- sidebar wrapper -->
                <div class="col-md-9 xol-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-ship"></i> My Boats
                                    <a href="/owner/dashboard/boats/add" class="pull-right rb-edit"><i
                                                class="fa fa-plus"></i>Add New</a>
                                </h4>
                            </div>
                            <div class="padel-box-body my-boats">
                                @foreach($boats as $boat)
                                    <div class="single-boat dtable">
                                        <div class="cell media">
                                            <a href="/boats/profile/{{ $boat->id }}"><img class="img-responsive" alt=""
                                                                                          src="{{ asset($boat->thumb_photo) }}"></a>
                                        </div>
                                        <div class="cell content">
                                            <h4><a href="/boats/profile/{{ $boat->id }}">{{ $boat->name }}</a>
                                                <span class="label @if($boat->status=='available')label-success @elseif($boat->status=='off-duty') label-danger @elseif($boat->status=='booked') label-warning @elseif($boat->status=='busy') label-warning @endif">{{$boat->status}}</span>
                                                </h4>

                                                <h4>Boat ID : <a href="/boats/profile/{{ $boat->id }}">{{ $boat->unique_id }}</a></h4>

                                            <p>
                                                {{ $boat->about }}
                                            </p>

                                            <div class="info">
                                                <ul>
                                                    <li>Average Speed: <span>{{ $boat->average_speed }} Knots</span></li>
                                                    <li>Capacity: <span>{{ $boat->capacity }}</span></li>
                                                    <li>Operating Zone: <span>{{ $boat->operating_zone }}</span></li>
                                                    <li>Manning type: <span>{{ $boat->manning_type }}</span></li>
                                                </ul>
                                            </div>
                                            <h5 class="current-capt">
                                                <span><i class="glyphicon glyphicon-king"></i> Current Captain: &nbsp;</span>
                                                @if($boat->captain!=null)
                                                        <a href="/captains/profile/{{ $boat->captain_id }}">{{ $boat->captain->user->name }}</a>
                                                    @else
                                                       <span class="no-capt">No Captain Found</span>
                                                @endif
                                            </h5>
                                            <!-- boat-info -->
                                            <div class="boat-meta">
                                                <a class="btn btn-warning btn-xsm"
                                                   href="/owner/dashboard/boats/{{ $boat->id }}/edit/"><i
                                                            class="fa fa-pencil"></i> Edit</a>
                                                <a class="btn btn-danger btn-xsm"
                                                   href="/owner/dashboard/boats/{{ $boat->id }}/delete/"><i
                                                            class="fa fa-times"></i> Delete</a>
                                            </div>
                                            
                                        </div>
                                        <!-- content -->
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- block about-block -->
                    </div>
                    <!-- block-wrapper -->
                    <div class="clearfix"></div>
                </div><!-- boat-list wrapper -->
            </div><!-- row -->
        </div><!-- container -->
    </section>
@stop