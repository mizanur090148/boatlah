@extends('admin.layout')

@section('header')

    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/pages/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/datatables-fixedheader/dataTables.fixedHeader.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/datatables-responsive/dataTables.responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/tables/datatable.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/global/vendor/alertify-js/alertify.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/advanced/alertify.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title"><i class="site-menu-icon fa-link" aria-hidden="true"></i> User and Roles</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li><a href="{{ url('/admin/users-and-roles') }}">User and Roles</a></li>
            <li class="active"><a href="#">Manage Roles</a></li>
        </ol>
        <div class="page-header-actions">
            <a class="btn btn-sm btn-primary btn-outline" href="{{url('/admin/users-and-roles/create_user_role/'.$user->id)}}">
                <i class="icon md-link" aria-hidden="true"></i>
                <span class="hidden-xs">Add New Role</span>
            </a>
        </div>
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
                            <h4 class="profile-user">{{$user->name}}</h4>
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
                                                <div class="profile-brief">{{$user->email}}</div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">Phone
                                                </h4>
                                                <div class="profile-brief">{{$user->phone}}</div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <header class="panel-heading">
                            <div class="panel-actions"></div>
                            <h3 class="panel-title">Roles</h3>
                        </header>
                        <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
                            <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Role Name</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @foreach($roles as $role)
                            <tr>
                                <td>{{$role->name}}</td>
                                <td class="td-actions">
                                    {{Form::open(array('url'=>'/admin/users-and-roles/'.$role->id, 'method' => 'DELETE','id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal'))}}
                                    <input type="hidden" name="user_id" value="{{$role->pivot->user_id}}">
                                    <button class="btn btn-sm btn-outline btn-danger" type="submit"><i class="fa fa-times"></i> </button>
                                    {{Form::close()}}</td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Panel -->
            </div>
        </div>
    </div>

@endsection

@section('footer')

    <script src="{{asset('admin/global/vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{asset('admin/global/vendor/datatables-fixedheader/dataTables.fixedHeader.js') }}"></script>
    <script src="{{asset('admin/global/vendor/datatables-bootstrap/dataTables.bootstrap.js') }}"></script>
    <script src="{{asset('admin/global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{asset('admin/global/vendor/datatables-tabletools/dataTables.tableTools.js') }}"></script>
    <script src="{{asset('admin/global/vendor/asrange/jquery-asRange.min.js') }}"></script>
    <script src="{{asset('admin/global/vendor/bootbox/bootbox.js') }}"></script>

    <script src="{{asset('admin/global/js/components/datatables.js') }}"></script>
    <script src="{{asset('admin/assets/examples/js/tables/datatable.js') }}"></script>
    <script src="{{asset('admin/assets/examples/js/uikit/icon.js') }}"></script>

    <script src="{{asset('admin/global/js/components/alertify-js.js') }}"></script>

    <script>
        (function(document, window, $) {
            'use strict';
            var Site = window.Site;
            $(document).ready(function() {
                Site.run();
            });
        })(document, window, jQuery);
    </script>
@endsection