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
      <h1 class="page-title"><i class="site-menu-icon fa-university" aria-hidden="true"></i> Shipping Companies</h1>
      <ol class="breadcrumb">
        <li><a href="/admin/dashboard">Home</a></li>
        <li><a href="{{ url('/admin/shipping-companies') }}">Shipping Agency</a></li>
      </ol>
        <div class="col-lg-4 col-sm-6">
            <!-- Example Delay -->

            <!-- End Example Delay -->
        </div>
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
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
            @foreach($shipping_companies as $shipping_company)
              <tr>
                <td>{{$shipping_company->user->name}}</td>
                <td>{{$shipping_company->user->email}}</td>
                <td>{{$shipping_company->user->phone}}</td>
                <td>{{$shipping_company->user->address}}</td>
                <td>{{$shipping_company->created_at}}</td>
                <td class="td-actions"><a href="{{URL::to('admin/shipping-companies/'.$shipping_company->id)}}" class="btn btn-sm btn-primary btn-outline" ><i class="fa fa-file-text"></i></a>
                  <a href="{{URL::to('admin/shipping-companies/'.$shipping_company->id.'/edit')}}" class="btn btn-sm btn-warning btn-outline"><i class="fa fa-pencil"></i></a>
                  {{Form::open(array('url'=>'/admin/shipping-companies/'.$shipping_company->id, 'method' => 'DELETE','onsubmit'=>'return ConfirmDelete()','id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal'))}}
                  <button class="btn btn-sm btn-outline btn-danger" type="submit"><i class="fa fa-times"></i> </button>
                  {{Form::close()}}</td>
              </tr>
              @endforeach
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
  </script>
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