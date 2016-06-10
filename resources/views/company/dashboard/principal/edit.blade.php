@extends('user.layout')

@section('title')
    Shipping Agency Dashboard
@stop


@section('content')
    <section class="section-boat-list">
        <div class="container">
            @include('company.dashboard.common.breadcrumb')
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="sidebar">
                        <div class="widget widget-side-menu">
                            <div class="header-bar">
                                <h4><i class="fa fa-bookmark-o"></i>Manage Principals</h4>
                            </div>
                            @include('company.dashboard.common.sidemenu')
                        </div><!-- widget -->
                    </div><!-- sidebar -->
                </div><!-- sidebar wrapper -->
                <div class="col-md-9 xol-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-bookmark-o"></i> My Principals
                                </h4>
                            </div>
                            <div class="padel-box-body">
                                <div class="row">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        {{Form::open(array('url'=>'/company/dashboard/my_principals/'.$principle->id, 'files'=>true, 'method' => 'PUT','id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal','enctype'=>'multipart/form-data'))}}

                                        <div class="form-group form-material <?php if($errors->first('principle_name')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Principle Name: <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="principle_name" value="{{ \Illuminate\Support\Facades\Input::old('principle_name',$principle->title)}}">
                                                <span class="validator_output <?php if($errors->first('principle_name')!=null) echo "help-block"?>">{{ $errors->first('principle_name') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                        {{Form::close()}}
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