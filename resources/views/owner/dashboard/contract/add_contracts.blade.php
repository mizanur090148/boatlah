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
                                <h4 class="clearfix padel-title"><i class="fa fa-file-text-o"></i> Manage Contracts
                                </h4>
                            </div>
                            <div class="padel-box-body">
                                <div class="panel panel-success panel-manage">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Add New Contract</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="padding-20">
                                                    {{Form::open(array('url'=>'/owner/dashboard/contracts/addContracts','class'=>'form-horizontal'))}}

                                                    <select class="form-control select-styled mb-15" name="company_id">
                                                        <option value="">Select Company</option>
                                                        @foreach($companies as $company)
                                                            <option value="{{$company->user_id}}">{{$company->user->name}}</option>
                                                        @endforeach
                                                    </select>

                                                    <input type="text" class="form-control mb-15" placeholder="Invoice Prefix" name="invoice_prefix" required>
                                                    <input type="number" class="form-control mb-15" min="0" step=".01" placeholder="Credit Limit" name="credit_limit" required>
                                                    <input type="number" class="form-control mb-15" min="0" placeholder="Aging Limit" name="aging_limit" required>
                                                    {{Form::submit('Add Contract!',array('class'=>'btn btn-primary'))}}

                                                    {{Form::close()}}
                                                </div>
                                            </div>
                                        </div>
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