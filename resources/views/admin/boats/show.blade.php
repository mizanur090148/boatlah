@extends('admin.layout')

@section('header')

    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/pages/profile.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title"><i class="site-menu-icon fa-ship" aria-hidden="true"></i> Boats</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li><a href="{{ url('/admin/boats') }}">Boats</a></li>
            <li class="active"><a>Show</a></li>
        </ol>
    </div>
    <div class="page-profile container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Page Widget -->
                <div class="widget widget-shadow text-center">
                    <div class="widget-header">
                        <div class="widget-header-content">
                            <a class="avatar avatar-lg" href="">
                                @if($boat->thumb_photo!=null)
                                    <img src="{{URL::asset($boat->thumb_photo)}}" alt="...">
                                @else
                                    <img src="{{URL::asset('/images/preview.png')}}" alt="...">
                                @endif
                            </a>
                            <h4 class="profile-user">{{$boat->name}}</h4>
                            <p class="profile-job">{{$boat->owner->user->name}}</p>
                            <p class="profile-job">{{$boat->unique_id}}</p>
                            <p class="profile-job">{{$boat->about}}</p>
                        </div>
                    </div>
                </div>
                <!-- End Page Widget -->
            </div>
            <div class="col-md-9">
                <!-- Panel -->
                <div class="panel">
                    <div class="panel-body nav-tabs-animate">
                        <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                            <li class="active" role="presentation"><a data-toggle="tab" href="#description" aria-controls="activities"
                                                                      role="tab">Description </a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active animation-slide-left" id="description" role="tabpanel">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">License
                                                </h4>
                                                <div class="profile-brief">{{$boat->license}}</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">License Date
                                                </h4>
                                                <div class="profile-brief">{{$boat->license_date}}</div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">Habourcraft Number
                                                </h4>
                                                <div class="profile-brief">{{$boat->habourcraft_number}}</div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">Average Speed
                                                </h4>
                                                <div class="profile-brief">{{$boat->average_speed}} knots</div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">Capacity
                                                </h4>
                                                <div class="profile-brief">{{$boat->capacity}}</div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">Status
                                                </h4>
                                                <div class="profile-brief">{{$boat->status}}</div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">Operating Zone
                                                </h4>
                                                <div class="profile-brief">{{$boat->operating_zone}}</div>
                                            </div>
                                        </div>
                                    </li>

                                     <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">Anchorage
                                                </h4>
                                                <div class="profile-brief">{{$boat->anchorage->title}}</div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Panel -->
            </div>
        </div>
    </div>

@endsection