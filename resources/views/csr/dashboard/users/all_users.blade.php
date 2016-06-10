@extends('user.layout')

@section('title')
    user Dashboard
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
                <div class="col-md-9 xol-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-bookmark"></i> All Users</h4>
                            </div>
                            <div class="padel-box-body">
                                <div role="tabpanel">
                                    <ul class="nav nav-pills nav-justified nav-trip" role="tablist">
                                        <li class="active" role="presentation"><a href="#pending" aria-controls="pending" role="tab" data-toggle="tab">Registered</a></li>
                                        <li role="presentation"><a href="#approved" aria-controls="approved" role="tab" data-toggle="tab"> Unregistered </a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="pending">
                                            <table class="display table dtable-default table-xpadd" id="myCompany">
                                                <thead>
                                                <tr>
                                                    <th>User Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Address</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($boat_users!='[]')
                                                    @foreach($boat_users as $boat_user)
                                                        <tr>
                                                            <td>{{$boat_user->user->name}}</td>
                                                            <td>{{$boat_user->user->email}}</td>
                                                            <td>{{$boat_user->user->phone}}</td>
                                                            <td>{{$boat_user->user->address}}</td>
                                                            <td><a href="/csr/dashboard/boats/{{$boat_user->user_id}}"> Book Boat </a></td>
                                                        </tr>
                                                @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="approved">
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    {{Form::open(array('url'=>'/csr/dashboard/post_book_create', 'class'=>'form-horizontal'))}}
                                                    <div class="form-group <?php if ($errors->first('name') != null) echo "has-error"?>">
                                                        <label class="col-sm-3 control-label">Name:</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="name" placeholder="Name">
                                                            <span class="validator_output <?php if ($errors->first('name') != null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group <?php if ($errors->first('email') != null) echo "has-error"?>">
                                                        <label class="col-sm-3 control-label">email:</label>
                                                        <div class="col-sm-9">
                                                            <input type="email" class="form-control" name="email" placeholder="Enter your email address">
                                                            <span class="validator_output <?php if ($errors->first('email') != null) echo "help-block"?>">{{ $errors->first('email') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group <?php if ($errors->first('phone') != null) echo "has-error"?>">
                                                        <label class="col-sm-3 control-label">Phone:</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="phone" placeholder="Enter your phone number">
                                                            <span class="validator_output <?php if ($errors->first('phone') != null) echo "help-block"?>">{{ $errors->first('phone') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-9 col-sm-offset-3">
                                                            <button type="submit" class="btn btn-primary">Go</button>
                                                        </div>
                                                    </div>
                                                    {{Form::close()}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- block about-block -->
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