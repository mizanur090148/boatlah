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
            @include('user.dashboard.common.breadcrumb')
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('user.dashboard.common.sidemenu')
                        </div><!-- widget -->
                    </div><!-- sidebar -->
                </div><!-- sidebar wrapper -->
                <div class="col-md-9 xol-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-university"></i> My Company
                                </h4>
                            </div>
                            <div class="padel-box-body">
                                @if(isset($my_company))                                
                                    <div class="profile-heading clearfix">
                                        <div class="profile-avater">
                                            @if($my_company->user->thumb_photo!=null)
                                                <img class="pavater" src="{{URL::asset($my_company->user->thumb_photo)}}" alt="...">
                                            @else
                                                <img class="pavater" src="{{URL::asset('/images/preview.png')}}" alt="...">
                                            @endif
                                        </div>
                                        <div class="profile-denote">
                                            <h3 class="pro-name"><a href="#">{{$my_company->user->name}}</a></h3>
                                            <p>
                                               {{$my_company->about}}
                                            </p>
                                            @if($check_remove==null)
                                            <a href="{{url('/user/dashboard/company/remove')}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Request to Remove</a>
                                            @else
                                                <span class="btn-warning btn-sm">Remove Request Sent!</span>
                                            @endif
                                        </div>

                                    </div>                                   
                                @else
                                    <div class="alert alert-info alert-dash text-center" role="alert">
                                        <span class="title">You are not connected to any company yet.</span>
                                    </div>
                                    <div class="table-holder">
                                        <table id="myCompany" class="display table dtable-default table-xpadd">
                                            <thead class="hide">
                                            <tr>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($check_approve!=null)
                                                <?php $company_check = \App\ShippingCompanyProfile::where('user_id','=',$check_approve->company_id)->first();
                                                if($company_check!=null){
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="alert alert-warning alert-dash text-center" role="alert">
                                                            <span>Your request is currently pending. To cancel the request please Click 'Delete Request' Button</span>
                                                        </div>
                                                    
                                                        <div class="company-binfo">
                                                            <div class="com-thumb">
                                                                @if($company_check->user->photo!=null)
                                                                    <img class="img-responsive" src="{{$company_check->user->photo}}" alt="...">
                                                                @else
                                                                    <img class="img-responsive" src="{{URL::asset('/images/preview.png')}}" alt="...">
                                                                @endif
                                                            </div>
                                                            <div class="com-note">
                                                                <h4><a href="">{{$company_check->user->name}}</a></h4>

                                                                <p>
                                                                    {{$company_check->about}}
                                                                </p>
                                                                <label class="btn-warning btn-sm">Pending</label>
                                                                <a href="{{url('/user/dashboard/company/delete/'.$check_approve->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete Request</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                </tr>
                                               <?php }?>
                                                @else
                                            @foreach($all_companies as $company)
                                            <tr>
                                                <td>
                                                    <div class="company-binfo">
                                                        <div class="com-thumb">
                                                            @if($company->user->thumb_photo!=null)
                                                                <img class="img-responsive" src="{{$company->user->thumb_photo}}" alt="...">
                                                            @else
                                                                <img class="img-responsive" src="{{URL::asset('/images/preview.png')}}" alt="...">
                                                            @endif
                                                        </div>
                                                        <div class="com-note">
                                                            <h4><a href="">{{$company->user->name}}</a></h4>
                                                            <p>
                                                                {{$company->about}}
                                                            </p>
                                                            @if($check_approve==null)
                                                            <a href="{{url('/user/dashboard/company/connect/'.$company->user_id)}}" class="btn btn-success btn-sm"><i class="fa fa-link"></i>Request to Connect</a>
                                                       @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                                @endforeach
                                            @endif
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