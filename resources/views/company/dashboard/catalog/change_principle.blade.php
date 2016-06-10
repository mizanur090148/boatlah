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
                                <h4 class="clearfix padel-title"><i class="fa fa-bookmark-o"></i> {{$catalogs_parent->catalogs_code}}  ({{$catalogs_parent->owner->name}})</h4>
                            </div>
                            <div class="padel-box-body">
                                <div class="row">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        {{Form::open(array('url'=>'/company/dashboard/catalogs/change_principle/'.$catalogs_parent->id,'id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal'))}}
                                        @if(Session::has('messages'))
                                            <div class="summary-errors alert alert-success alert-dismissible" style="display: block;">
                                                <button data-dismiss="alert" aria-label="Close" class="close" type="button">
                                                    <span aria-hidden="true">×</span>
                                                </button><p>{{Session::get('messages')}}</p>
                                            </div>
                                        @endif
                                        <div class="form-group form-material <?php if($errors->first('principle_name')!=null) echo "has-error"?>">
                                            <label class="control-label col-sm-3">Principle Name : </label>
                                            <div class="col-sm-9">
                                                <select class="form-control chosen" name="principle_name[]" id="principle_name" multiple>
                                                    @foreach($principles as $principle)
                                                        <option value="{{$principle->id}}">{{$principle->title}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="validator_output <?php if($errors->first('principle_name')!=null) echo "help-block"?>">{{ $errors->first('principle_name') }}</span>
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