@extends('user.layout')

@section('title')
    Coordinator Dashboard
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            @include('coordinator.dashboard.common.breadcrumb')
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-folder"></i> Manage Catalog
                                    <a href="{{ URL::previous()}}" class="pull-right rb-edit"><i
                                                class="fa fa-arrow-circle-o-left"></i> Go Back</a>
                                </h4>
                            </div>
                            @if($catalogs!=null)
                            @if($check_catalog!=null)
                            <div class="padel-box-body manage-catalog-pbody">
                                <h5 class="text-uppercase clearfix mana-cate-heading">{{ $catalogs->boat_type }} / {{ $catalogs->trip_type }} / {{ $catalogs->zone }}
                                    <a href="{{URL::to('/coordinator/dashboard/catalogs/downloadExcel/'.$catalogs->id.'/'.$catalogs->zone)}}" class="pull-right btn btn-info rb-edit"><i class="fa fa-download"></i> Download as Excel</a>
                                </h5>

                                <div class="table-responsive">
                                    <table class="table table-manage-catalog">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            @foreach($anchorages as $anchorage)
                                                <th>{{$anchorage->title}}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count = 0;?>
                                        @foreach($data2 as $dt2)
                                            <?php $count++;$count2 = 1;?>
                                            <tr>
                                                <td>{{$dt2[$count2]['title']}}</td>
                                                @foreach($dt2 as $d2)

                                                    <td>
                                                        <input type="number" step="0.01" min=0 name="{{$count.'0'.$count2}}"
                                                               value="{{$d2['cost']}}" class="form-control"
                                                               style="border:solid 1px #ccc; text-align:right; padding:2px;" disabled>
                                                    </td>
                                                    <?php $count2++; ?>
                                                @endforeach
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                                @else



                                    @endif
                                @else
                                <div class="padel-box-body manage-catalog-pbody">
                                <h5 class="text-uppercase">No Catalog Found</h5>
                                    </div>
                            @endif
                        </div>
                        <!-- block about-block -->
                    </div>
                    <!-- block-wrapper -->
                    <div class="clearfix"></div>
                </div>
                <!-- boat-list wrapper -->
            </div><!-- row -->
        </div><!-- container -->
    </section>
@stop