@extends('user.layout')

@section('title')
    Company Dashboard
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
                                <h4><i class="fa fa-gear"></i>Manage account</h4>
                            </div>
                            @include('company.dashboard.common.sidemenu')
                        </div><!-- widget -->
                    </div><!-- sidebar -->
                </div><!-- sidebar wrapper -->
                <div class="col-md-9 xol-sm-8">
                    <div class="block-wrapper">
                        <div class="block account-block padel-box" style="background:#fff;">
                            <div class="header-bar padel-box-header">
                                <h4 class="clearfix padel-title"><i class="fa fa-bookmark-o"></i> Add New Tariff Tables </h4>
                            </div>
                            <div class="padel-box-body">
                                <div class="row">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        {{Form::open(array('url'=>'/company/dashboard/catalogs','id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal'))}}
                                        @if(Session::has('messages'))
                                            <div class="summary-errors alert alert-success alert-dismissible" style="display: block;">
                                                <button data-dismiss="alert" aria-label="Close" class="close" type="button">
                                                    <span aria-hidden="true">×</span>
                                                </button><p>{{Session::get('messages')}}</p>
                                            </div>
                                        @endif
                                        <div class="form-group form-material <?php if($errors->first('owner_name')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Boat Owner : <span>*</span></label>
                                            <div class="col-sm-9">
                                                <select class="form-control chosen" name="owner_name" id="owner">
                                                    @foreach($owners as $owner)
                                                    <option value="{{$owner->owner_id}}">{{$owner->owner->user->name}}</option>
                                                        @endforeach
                                                </select>
                                                <span class="validator_output <?php if($errors->first('owner_name')!=null) echo "help-block"?>">{{ $errors->first('owner_name') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group form-material <?php if($errors->first('catalog_name')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Catalog Name : <span>*</span></label>
                                            <div class="col-sm-9">
                                                <input class="form-control"  id="catalog" name="catalog_name">
                                                <span class="validator_output <?php if($errors->first('catalog_name')!=null) echo "help-block"?>">{{ $errors->first('catalog_name') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button type="submit" class="btn btn-primary">Connect</button>
                                            </div>
                                        </div>
                                        </form>
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