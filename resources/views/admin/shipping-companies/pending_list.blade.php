@extends('admin.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/datatables-fixedheader/dataTables.fixedHeader.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/datatables-responsive/dataTables.responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/tables/datatable.css') }}">
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title"><i class="site-menu-icon fa-university" aria-hidden="true"></i> Shipping Companies</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li><a href="{{ url('/admin/shipping-companies') }}">Shipping Agency</a></li>
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
                        <th>Date & Time</th> 
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>                        
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Date & Time</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>                        
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @if(isset($allcompanies))
                        @foreach($allcompanies as $company)
                            <tr>
                                <td>{{$company->created_at}}</td>
                                <td>{{$company->name}}</td>
                                <td>{{$company->email}}</td>
                                <td>{{$company->phone}}</td>                               
                                <td class="td-actions">
                                    <a href="{{URL::to('/admin/shipping-companies/status/active/'.$company->id)}}" class="btn btn-sm btn-primary btn-outline" >Approve</a>
                                    <a href="{{URL::to('/admin/shipping-companies/status/block/'.$company->id)}}" class="btn btn-sm btn-primary btn-outline" >Block</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End Panel Basic -->
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
@endsection