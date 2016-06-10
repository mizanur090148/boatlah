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
                                <h4 class="clearfix padel-title"><i class="fa fa-group"></i> My Coordinators
                                </h4>
                            </div>
                            <div class="padel-box-body">

                                <div class="row">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        {{Form::open(array('url'=>'/owner/dashboard/coordinators/promote_post','class'=> 'form-horizontal form-edit-profile'))}}
                                            <input name="_token" type="hidden" value="{{csrf_token()}}">
                                            <div class="form-group  <?php if($errors->first('location')!=null) echo "has-error"?>">
                                                <label class="col-sm-3 control-label">Location <span>*</span></label>
                                                <div class="col-sm-9">
                                                    <select name="location" class="form-control">
                                                        <option value="">Select One</option>
                                                        <option value="Western" @if(\Illuminate\Support\Facades\Input::old('location')=='Western') selected @endif>Western</option>
                                                        <option value="Eastern" @if(\Illuminate\Support\Facades\Input::old('location')=='Eastern') selected @endif>Eastern</option>
                                                    </select>
                                                    <span class="validator_output <?php if($errors->first('location')!=null) echo "help-block"?>">{{ $errors->first('location') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-9 col-sm-offset-3">
                                                    <button type="submit" class="btn btn-primary">Save</button>
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