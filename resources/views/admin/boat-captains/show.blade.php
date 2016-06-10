@extends('admin.layout')

@section('header')

    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/pages/profile.css') }}">
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title"> <i class="site-menu-icon fa-street-view" aria-hidden="true"></i> Boat Captains</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li class="active"><a href="{{ url('/admin/boat-captains') }}">Boat Captains</a></li>
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
                                @if($boat_captain->user->thumb_photo!=null)
                                    <img src="{{URL::asset($boat_captain->user->thumb_photo)}}" alt="...">
                                @else
                                    <img src="{{URL::asset('/images/preview.png')}}" alt="...">
                                @endif
                            </a>
                            <h4 class="profile-user">{{$boat_captain->user->name}}</h4>
                            <p class="profile-job">{{$boat_captain->about}}</p>
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
                                                <h4 class="media-heading">Email
                                                </h4>
                                                <div class="profile-brief">{{$boat_captain->user->email}}</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">Phone
                                                </h4>
                                                <div class="profile-brief">{{$boat_captain->user->phone}}</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">NRIC
                                                </h4>
                                                <div class="profile-brief">{{$boat_captain->nric}}</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">Years of Boating
                                                </h4>
                                                <div class="profile-brief">{{$boat_captain->years_of_boating}}</div>
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