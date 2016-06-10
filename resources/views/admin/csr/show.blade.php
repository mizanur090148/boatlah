@extends('admin.layout')

@section('header')

    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/pages/profile.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title"><i class="site-menu-icon fa-phone" aria-hidden="true"></i> CSR</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li><a href="{{ url('/admin/csr') }}">All CSR</a></li>
            <li class="active"><a href="#">Show</a></li>
        </ol>
        <div class="col-lg-4 col-sm-6">
            <!-- Example Delay -->

            <!-- End Example Delay -->
        </div>
    </div>
    <div class="page-profile container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Page Widget -->
                <div class="widget widget-shadow text-center">
                    <div class="widget-header">
                        <div class="widget-header-content">
                            <a class="avatar avatar-lg" href="">
                                @if($csr->user->thumb_photo!=null)
                                    <img src="{{URL::asset($csr->user->thumb_photo)}}" alt="...">
                                @else
                                    <img src="{{URL::asset('/images/preview.png')}}" alt="...">
                                @endif
                            </a>
                            <h4 class="profile-user">{{$csr->user->name}}</h4>
                            <p class="profile-job">{{$csr->user->address}}</p>
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
                                                <h4 class="media-heading">About
                                                </h4>
                                                <div class="profile-brief">{{$csr->about}}</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">Email
                                                </h4>
                                                <div class="profile-brief">{{$csr->user->email}}</div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">Phone
                                                </h4>
                                                <div class="profile-brief">{{$csr->user->phone}}</div>
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