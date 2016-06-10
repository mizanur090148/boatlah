@extends('user.layout')

@section('title')
    Shipping Agency Dashboard
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.1.0/css/select.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css">
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            @include('company.dashboard.common.breadcrumb')
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('company.dashboard.common.sidemenu')
                        </div><!-- widget -->
                    </div><!-- sidebar -->
                </div><!-- sidebar wrapper -->
                <div class="col-md-9 xol-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-group"></i> My Principals
                                    <a href="/company/dashboard/my_principals/create" class="pull-right rb-edit"><i class="fa fa-plus"></i>Add New</a>
                                </h4>
                            </div>
                            <div class="padel-box-body my-boats">

                                @if($principles!='[]')
                                <div class="table-holder">
                                    <table id="myCompany" class="display table dtable-default table-xpadd">
                                        <thead>
                                        <tr>
                                            <th colspan="3">Principle Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($principles as $principle)
                                            <tr>
                                                <td colspan="3">
                                                    {{$principle->title}}
                                                </td>
                                                <td>
                                                    <div class="boat-meta">
                                                        <a class="btn btn-warning btn-sm" href="/company/dashboard/my_principals/{{ $principle->id }}/edit"><i class="fa fa-pencil"></i> Edit</a>
                                                        {{Form::open(array('url'=>'/company/dashboard/my_principals/'.$principle->id, 'method' => 'DELETE','id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal form-inline-block'))}}
                                                        <button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-times"></i> Delete</button>
                                                        {{Form::close()}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                    @endif
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

@section('footer_scripts')
    <script type="text/javascript" charset="utf8" src="/plugins/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myCompany').DataTable();

            $('.datatable').DataTable();
            $('.account-datatable').DataTable();

        });
    </script>
@stop