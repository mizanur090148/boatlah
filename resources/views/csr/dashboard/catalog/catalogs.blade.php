@extends('user.layout')

@section('title')
    CSR Dashboard
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            @include('csr.dashboard.common.breadcrumb')
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('csr.dashboard.common.sidemenu')
                        </div><!-- widget -->
                    </div><!-- sidebar -->
                </div><!-- sidebar wrapper -->
                 <div class="col-md-9 col-sm-8">
                                    <div class="block-wrapper">
                                        <div class="block account-block padel-box" style="background:#fff;">
                                            <div class="header-bar padel-box-header">
                                                <h4 class="clearfix padel-title"><i class="fa fa-usd"></i> Manage Catalogs 
                                              </h4>
                                            </div>
                                            <div class="padel-box-body">
                                                <div class="panel panel-primary panel-manage">
                                                  <div class="panel-heading">
                                                    <h3 class="panel-title">General Catalog (for individual users)</h3>
                                                  </div>
                                                  <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <table class="table">
                                                                <thead>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><div class="calog-alist">
                                                                                <a href="{{ url('/csr/dashboard/catalogs/'.$boat->manning_type.'/one way/'.$boat->operating_zone.'/'.$boat->user_id) }}" @if($one_way==null) class="inactive" @else class="active" @endif> One Way</a>
                                                                                <a href="{{ url('/csr/dashboard/catalogs/'.$boat->manning_type.'/returning/'.$boat->operating_zone.'/'.$boat->user_id) }}" @if($returning==null) class="inactive" @else class="active" @endif> Returning</a>
                                                                            </div> 
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
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

                                            @foreach($companies as $company)
                                                <div class="padel-box-body">
                                                    <div class="panel panel-success panel-manage">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">Catalog for Company : {{$company->company->user->name}}
                                                                <span class="@if($company->status=='active') label label-success @else label label-warning @endif">{{$company->status}}</span>
                                                                </h3>
                                                                <br />
                                                                <p>Contract Code : {{$company->contract_code}}</p>
                                                        </div>
                                                        <?php
                                                        $one_way1 =  \App\Catalog::where('contract_id','=',$company->id)
                                                                ->where('boat_type','=',$boat->manning_type)->where('trip_type','=','one way')
                                                                ->where('zone','=',$boat->operating_zone)->first();
                                                        $returning1 =  \App\Catalog::where('contract_id','=',$company->id)->where('boat_type','=',$boat->manning_type)->where('trip_type','=','returning')
                                                                ->where('zone','=',$boat->operating_zone)->first();
                                                        ?>
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <table class="table">
                                                                        <thead>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td><div class="calog-alist">
                                                                                    <a href="{{ url('/csr/dashboard/catalogs/'.$boat->manning_type.'/one way/'.$boat->operating_zone.'/'.$boat->user_id.'/'.$company->company_id) }}" class="{{ $one_way1->status }}"> One Way </a>
                                                                                    <a href="{{ url('/csr/dashboard/catalogs/'.$boat->manning_type.'/returning/'.$boat->operating_zone.'/'.$boat->user_id.'/'.$company->company_id) }}" class="{{ $returning1->status }}"> Returning </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer text-right">
                                                            <ul class="list-inline status-lists">                                                                
                                                                <li class="active">Active</li>
                                                                <li class="inactive">Inactive</li>
                                                                <li class="pending">Pending for Company Approval</li>
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