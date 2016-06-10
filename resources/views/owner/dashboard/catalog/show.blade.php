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
                <div class="col-md-9 col-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-usd"></i> Tariff Tables
                                    <a href="" class="pull-right rb-edit hide"></i>Back</a>
                                </h4>
                            </div>
                            <div class="padel-box-body">
                                <div class="panel panel-default panel-manage">
                                    <div class="panel-body">
                                        Show Catalog Here
                                        <br />
                                        Approve Button (if needed)
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- block about-block -->
                    </div>
                    <!-- block-wrapper -->
                    <div class="clearfix"></div>
                </div>

            </div><!-- row -->
        </div><!-- container -->
    </section>
@stop