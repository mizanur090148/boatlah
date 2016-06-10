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
            <div class="col-md-9 xol-sm-8">
                <div class="block-wrapper">
                    <div class="block account-block padel-box" style="background:#fff;">
                        <div class="header-bar padel-box-header">
                            <h4 class="clearfix padel-title"><i class="fa fa-user"></i> Profile 
                                <a href="/owner/dashboard/profile/edit" class="pull-right rb-edit"><i class="fa fa-pencil"></i>Edit</a>
                            </h4>
                        </div>
                        <div class="padel-box-body">
                            <div class="profile-heading clearfix">
                                <div class="profile-avater">
                                    @if($user_info->user->thumb_photo!=null)
                                        <img src="{{URL::asset($user_info->user->thumb_photo)}}" alt="...">
                                    @else
                                        <img src="{{URL::asset('/images/preview.png')}}" alt="...">
                                    @endif
                                </div>
                                <div class="profile-denote">
                                    <h3 class="pro-name"><a href="/owners/profile/{{$user_info->user_id}}">{{$user_info->user->name}}</a></h3>
                                    <p>
                                       {{$user_info->about}}
                                    </p>
                                </div> 
                            </div>
                            <div class="profile-info">
                                <div class="table-responsive">
                                    <table class="table table-profile">
                                        <tbody>
                                        @if(isset($user_info))
                                            <tr>
                                                <td>Name:</td>
                                                <td>{{$user_info->user->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Company Name:</td>
                                                <td>{{$user_info->company_name}}</td>
                                            </tr>                                 
                                            <tr>
                                                <td>Mobile No.:</td>
                                                <td>{{$user_info->user->phone}}</td>
                                            </tr>
                                            <tr>
                                                <td>Uen Number:</td>
                                                <td>{{$user_info->uen_number}}</td>
                                            </tr>

                                            <tr>
                                                <td>Gst Registration:</td>
                                                <td>{{$user_info->gst_registration}}</td>
                                            </tr>
                                            <tr>
                                                <td>Invoice Bank Details:</td>
                                                <td>{{$user_info->invoice_bank_details}}</td>
                                            </tr>

                                          @endif  

                                        </tbody>
                                    </table>
                                </div>
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