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
                                <h4 class="clearfix padel-title"><i class="fa fa-usd"></i> Tariff Tables </h4>
                            </div>

                            <div class="padel-box-body">
                                <div class="panel panel-primary panel-manage">
                                  <div class="panel-heading">
                                    <h3 class="panel-title">Statndard Price List</h3>
                                  </div>
                                  <div class="panel-body">
                                        <div class="padd-15">
                                            <div class="calog-alist calog-alist-lg">
                                              <a href="/owner/dashboard/catalogs/edit/{{$standard_eastern->id}}" class="{{$standard_eastern->status}}">Eastern</a>
                                              <a href="/owner/dashboard/catalogs/edit/{{$standard_western->id}}" class="{{$standard_western->status}}">Eastern</a>
                                            </div>
                                        </div>
                                    </div>
                                  <div class="panel-footer text-right">
                                    <ul class="list-inline status-lists">
                                        <li class="active">Active</li>
                                        <li class="inactive">Inactive</li>
                                    </ul>
                                  </div>
                                </div>
                            </div>

                            @foreach($catalogs as $catalog)
                                <div class="padel-box-body">
                                    <div class="panel panel-primary panel-manage">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                {{$catalog->company->name}}
                                            </h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="padd-15">

                                                <?php
                                                $catalogs_details = \App\CatalogsParent::where('company_id', $catalog->company_id)->where('owner_id', '=', $catalog->owner_id)->get();
                                                ?>
                                                @foreach($catalogs_details as $catalogs_detail)
                                                    <?php
                                                    $eastern = \App\Catalog::where('catalogs_parent_id', '=', $catalogs_detail->id)->where('zone', '=', 'Eastern')->first();
                                                    $western = \App\Catalog::where('catalogs_parent_id', '=', $catalogs_detail->id)->where('zone', '=', 'Western')->first();
                                                    ?>
                                                    <div class="calog-tags clearfix">
                                                        <span>{{$catalogs_detail->catalogs_code}}</span>

                                                        <div class="pull-right">
                                                        </div>
                                                    </div>
                                                    <?php $principles = \App\CatalogRelation::where('catalogs_parent_id', '=', $catalogs_detail->id)->get();?>
                                                    <div class="principals">
                                                        @foreach($principles as $principle)
                                                            <span class="label label-default">{{$principle->principle->title}}</span>
                                                        @endforeach
                                                    </div>
                                                    <div class="calog-alist calog-alist-lg  mt-15">
                                                        <a href="/owner/dashboard/catalogs/edit/{{$eastern->id}}"
                                                           class="{{$eastern->status}}">Eastern</a>
                                                        <a href="/owner/dashboard/catalogs/edit/{{$western->id}}"
                                                           class="{{$western->status}}">Western</a>
                                                    </div>
                                                    <hr style="margin-bottom: 20px;">
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <ul class="list-inline status-lists">
                                                <li class="active">Active</li>
                                                <li class="inactive">Inactive</li>
                                                <li class="pending">Pending</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
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