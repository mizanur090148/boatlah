@extends('admin.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/datatables-fixedheader/dataTables.fixedHeader.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/datatables-responsive/dataTables.responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/tables/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/alertify-js/alertify.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/advanced/alertify.css') }}">
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title"><i class="site-menu-icon fa-group" aria-hidden="true"></i> Boat Coordinators</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li class="active"><a href="/admin/boat-coordinators">Boat Coordinators</a></li>
        </ol>
    </div>
    <div class="page-content">
        <!-- Panel Basic -->
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-actions"></div>
                <h3 class="panel-title">List</h3>
            </header>
            <div class="panel-body">
                <table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone No.</th>
                        <th>E-mail</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Phone No.</th>
                        <th>E-mail</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @if(isset($allcoordinators))
                        @foreach($allcoordinators as $coordinator)
                            <tr>
                                <td>{{$coordinator->user->name}}</td>
                                <td>{{$coordinator->user->phone}}</td>
                                <td>{{$coordinator->user->email}}</td>
                                <td>{{$coordinator->created_at}}</td>
                                <td class="td-actions"><a
                                            href="{{URL::to('/admin/boat-coordinators/'.$coordinator->id)}}"
                                            class="btn btn-sm btn-primary btn-outline"><i
                                                class="fa fa-file-text"></i></a>
                                    <a href="{{URL::to('/admin/boat-coordinators/'.$coordinator->id.'/edit')}}"
                                       class="btn btn-sm btn-warning btn-outline"><i class="fa fa-pencil"></i></a> |
                                    {{Form::open(array('url'=>'/admin/boat-coordinators/'.$coordinator->id, 'method' => 'DELETE','onsubmit'=>'return ConfirmDelete()','id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal'))}}
                                    <button class="btn btn-sm btn-outline btn-danger" type="submit"><i
                                                class="fa fa-times"></i></button>
                                    {{Form::close()}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
            <!-- End Example Confirm Dialog -->
            </div>
        </div>

@stop

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
    <script src="{{asset('admin/global/vendor/alertify-js/alertify.js') }}"></script>
    <script src="{{asset('admin/global/js/components/alertify-js.js') }}"></script>
    <script>
        function ConfirmDelete()
        {
            var x = confirm("This will delete the user with all his roles. do you want to continue?");
            if (x)
                return true;
            else
                return false;
        }
        function confirmHello()
        {
            alertify.confirm("This is a confirm dialog", function() {
                return true;
            }, function() {
                return false;
            });
        }
    </script>
@endsection