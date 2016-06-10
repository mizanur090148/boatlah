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
                            <h4 class="clearfix padel-title"><i class="fa fa-group"></i> My Coordinators
                                <a href="/owner/dashboard/coordinators/add" class="pull-right rb-edit"><i class="fa fa-plus"></i>Add New</a>
                            </h4>
                        </div>
                        <div class="padel-box-body my-boats">
                            @foreach($coordinators as $coordinator)
                             <div class="single-boat dtable">
                                <div class="cell media">
                                    <a><img alt="" src="{{ asset($coordinator->user->photo) }}" width="150px"></a>
                                </div>
                                <div class="cell content">
                                    <h4><a>{{ $coordinator->user->name }}</a></h4>
                                    <div class="info">
                                        <ul>
                                            <li>Name: <span><a>{{ $coordinator->user->name }}</a></span></li>
                                            <li>Mobile: <span>{{ $coordinator->user->phone }}</span></li>
                                            <li>location: <span>{{ $coordinator->location }}</span></li>
                                        </ul>
                                    </div>
                                    <!-- boat-info -->
                                    <div class="boat-meta">
                                        <a class="btn btn-warning btn-sm" href="/owner/dashboard/coordinators/{{ $coordinator->id }}/edit"><i class="fa fa-pencil"></i> Edit</a>
                                        <a class="btn btn-danger btn-sm" href="/owner/dashboard/coordinators/{{ $coordinator->user_id }}/delete/"><i class="fa fa-times"></i> Delete</a>
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