@extends('user.layout')

@section('title')
    Company Dashboard
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
                                <h4 class="clearfix padel-title"><i class="fa fa-group"></i> Pending Approval Request
                                </h4>
                            </div>
                            <div class="padel-box-body my-boats">
                                <div class="" style="padding: 20px;">
                                    <div class="notebook">
                                        Users who requested to connect to your company
                                    </div>
                                </div>
                                
                                
                                <div class="table-holder">
                                    <table id="myCompany" class="display table dtable-default table-xpadd">
                                        <thead class="hide">
                                        <tr>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($approve_lists as $pending)
                                        <tr>
                                            <td>
                                                <div class="company-binfo">
                                                    <div class="com-thumb">                                                        
                                                        <img class="img-responsive" src="{{$pending->userProfile->user->photo}}" alt="img">
                                                    </div>
                                                    <div class="com-note">
                                                        <h4><a href="">{{$pending->userProfile->user->name}}</a></h4>
                                                        <p>
                                                            {{$pending->userProfile->about}}
                                                        </p>
                                                        <p>
                                                            <a href="{{url('/company/dashboard/approve/'.$pending->user_id)}}" class="btn btn-success btn-sm"> <i class="fa fa-check"></i> Approve</a>
                                                            <a href="{{url('/company/dashboard/approve_delete/'.$pending->user_id)}}" class="btn btn-danger btn-sm"> <i class="fa fa-check"></i> Delete</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
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