@extends('user.layout')

@section('title')
    Company Dashboard
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            @include('company.dashboard.common.breadcrumb')
                    <!-- breadcrumbs -->
            <div class="row">
                <!-- sidebar wrapper -->
                <div class="col-sm-12">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-bookmark"></i> Advance Booking
                                    <a href="/company/dashboard/" class="pull-right rb-edit go-my-book">Go Back <i class="fa fa-angle-right"></i></a>
                                </h4>
                            </div>
                            <div class="padel-box-body">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="nav-books">
                                            <li><a href="/company/dashboard/advance-booking">New Advance booking</a></li>
                                            <li class="active"><a href="#">My Advance booking</a></li>
                                        </ul>
                                    </div>
                                </div>

                                 <div class="row">
                                    <div class="col-sm-12">
                                       You have no new requests now!
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- block about-block -->
                    </div>
                    <!-- block-wrapper -->
                    <div class="clearfix"></div>
                </div>
                <!-- boat-list wrapper -->
            </div>
        </div><!-- container -->
    </section>
@stop


@section('footer_scripts')
    <script>

        $(function(){
            $('input[name="tab__bookings"]').click(function () {
                $(this).tab('show');
            });
        })      

    </script>
@endsection