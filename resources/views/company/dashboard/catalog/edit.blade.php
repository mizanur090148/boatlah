@extends('user.layout')

@section('title')
    Company Dashboard
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            @include('company.dashboard.common.breadcrumb')
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-usd"></i> Tariff Table 1
                                    <a href="/company/dashboard/catalogs" class="pull-right rb-edit"><i
                                                class="fa fa-arrow-circle-o-left"></i> Go Back</a>
                                </h4>
                            </div>

                            <div class="padel-box-body manage-catalog-pbody">
                                    <div class="row mb-20">
                                        <div class="col-sm-6">
                                            <h5 class="clearfix pt-15 mana-cate-heading"><span class="">Update Prices</span></h5>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                {{Form::open(array('url'=>'','files'=>true))}}
                                                <div class="col-sm-8 <?php if($errors->first('excel')!=null) echo "has-error"?>">
                                                    <div class="file-styled">
                                                        <input type="file" name="excel">
                                                        <span>Upload your Excel File Here</span>
                                                    </div>
                                                    <span class="validator_output <?php if($errors->first('excel')!=null) echo "help-block"?>">{{ $errors->first('excel') }}</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    {{Form::submit('Upload',array('class'=>'btn btn-primary btn-block'))}}
                                                </div>
                                                {{Form::close()}}
                                            </div>
                                        </div>
                                    </div>
                                {{Form::open(array('url'=>'/company/dashboard/catalogs/'.$catalog->id))}}
                                    <div class="table-responsive">
                                        <div class="table-responsive">
                                            <table class="table table-manage-catalog">
                                                <thead>
                                                    <tr>
                                                        <th>Anchorage Code</th>
                                                        <th>Normal Rates (In SGD)</th>
                                                        <th>After Office Hours (AOH) Rates (In SGD)</th>
                                                        <th>Charges Within Same Anchorages (%)</th>
                                                        <th>Free Waiting Time (In Minutes)</th>
                                                        <th>Per Block Of Extra Times ( In Minutes )</th>
                                                        <th>Extra Waiting Time Charges Per Block Normal Hours (In SGD)</th>
                                                        <th>Extra Waiting Time Charges Per Block AOH Hours (In SGD)</th>
                                                        <th>Fuel Surcharge</th>
                                                        <th>Extra Boatman Charges</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($anchorages as $anchorage)
                                                    <tr>
                                                        <?php $info = \App\CatalogInfo::where('anchorage_code','=',$anchorage->id)->where('catalogs_id','=',$catalog->id)->first();?>
                                                        @if($info!=null)
                                                        <input type="hidden" name="anchorage_code[]" value="{{$anchorage->id}}">
                                                        <td><span>{{$anchorage->title}}</span></td>
                                                        <td><input type="number" step="0.01" min=0 class="form-control" name="normal_rates_{{$anchorage->id}}" value="{{$info->normal_rates}}"></td>
                                                        <td><input type="number" step="0.01" min=0 class="form-control" name="aoh_rates_{{$anchorage->id}}" value="{{$info->aoh_rates}}"></td>
                                                        <td><input type="number" step="0.01" min=0 class="form-control" name="charges_withing_same_anchorages_{{$anchorage->id}}" value="{{$info->charges_withing_same_anchorages}}"></td>
                                                        <td><input type="number" step="0.01" min=0 class="form-control" name="free_waiting_time_{{$anchorage->id}}" value="{{$info->free_waiting_time}}"></td>
                                                        <td><input type="number" step="0.01" min=0 class="form-control" name="per_block_of_extra_time_{{$anchorage->id}}" value="{{$info->per_block_of_extra_time}}"></td>
                                                        <td><input type="number" step="0.01" min=0 class="form-control" name="per_block_of_waiting_time_charges_normal_{{$anchorage->id}}" value="{{$info->per_block_of_waiting_time_charges_normal}}"></td>
                                                        <td><input type="number" step="0.01" min=0 class="form-control" name="per_block_of_waiting_time_charges_aoh_{{$anchorage->id}}" value="{{$info->per_block_of_waiting_time_charges_aoh}}"></td>
                                                        <td><input type="number" step="0.01" min=0 class="form-control" name="fuel_surcharge_{{$anchorage->id}}" value="{{$info->fuel_surcharge}}"></td>
                                                        <td><input type="number" step="0.01" min=0 class="form-control" name="extra_boatman_charges_{{$anchorage->id}}" value="{{$info->extra_boatman_charges}}"></td>
                                                            @else
                                                                <input type="hidden" name="anchorage_code[]" value="{{$anchorage->id}}">
                                                                <td><span>{{$anchorage->title}}</span></td>
                                                                <td><input type="number" step="0.01" min=0 class="form-control" name="normal_rates_{{$anchorage->id}}"></td>
                                                                <td><input type="number" step="0.01" min=0 class="form-control" name="aoh_rates_{{$anchorage->id}}"></td>
                                                                <td><input type="number" step="0.01" min=0 class="form-control" name="charges_withing_same_anchorages_{{$anchorage->id}}"></td>
                                                                <td><input type="number" step="0.01" min=0 class="form-control" name="free_waiting_time_{{$anchorage->id}}" ></td>
                                                                <td><input type="number" step="0.01" min=0 class="form-control" name="per_block_of_extra_time_{{$anchorage->id}}" ></td>
                                                                <td><input type="number" step="0.01" min=0 class="form-control" name="per_block_of_waiting_time_charges_normal_{{$anchorage->id}}"></td>
                                                                <td><input type="number" step="0.01" min=0 class="form-control" name="per_block_of_waiting_time_charges_aoh_{{$anchorage->id}}" ></td>
                                                                <td><input type="number" step="0.01" min=0 class="form-control" name="fuel_surcharge_{{$anchorage->id}}" ></td>
                                                                <td><input type="number" step="0.01" min=0 class="form-control" name="extra_boatman_charges_{{$anchorage->id}}" ></td>
                                                            @endif
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 col-sm-offset-9"><button class="btn btn-success btn-block" type="submit">Save</button></div>
                                    </div>
                                {{Form::close()}}
                                </div>

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