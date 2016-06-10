@extends('user.layout')

@section('title')
    Coordinator Dashboard
@stop

@section('content')
<section class="section-boat-list">
    <div class="container">
        @include('coordinator.dashboard.common.breadcrumb')        
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="sidebar">
                    <div class="widget widget-side-menu">
                        <div class="header-bar">
                            <h4><i class="fa fa-gear"></i>Manage account</h4>
                        </div>
                    @include('coordinator.dashboard.common.sidemenu')       
                    </div><!-- widget -->
                </div><!-- sidebar -->
            </div><!-- sidebar wrapper -->
            <div class="col-md-9 xol-sm-8">
                <div class="block-wrapper">
                    <div class="block account-block padel-box">
                        <ul class="nav nav-regs" role="tablist">
                            <li role="presentation" class="active"><a href="#register" aria-controls="register" role="tab" data-toggle="tab">Registered</a></li>
                            <li role="presentation"><a href="#unregister" aria-controls="unregister" role="tab" data-toggle="tab">Unregistered</a></li>
                        </ul>
                        <div class="padel-box-body regs-box">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="register">
                                    <div class="row">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            {{Form::open(array('url'=>'/coordinator/dashboard/post_book','class'=>'form-horizontal'))}}
                                            <input type="hidden" name="boat_id" value="{{$boat_id}}">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Email:</label>
                                                    <div class="col-sm-9">
                                                        <input type="email" name="email" class="form-control" placeholder="Enter your email address">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-9 col-sm-offset-3">
                                                        <button class="btn btn-primary" type="submit">Go</button>
                                                    </div>
                                                </div>
                                                
                                           {{Form::close()}}
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="unregister">
                                    <div class="row">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            {{Form::open(array('url'=>'/coordinator/dashboard/post_book_create', 'class'=>'form-horizontal'))}}
                                            <input type="hidden" name="boat_id" value="{{$boat_id}}">
                                            <div class="form-group <?php if ($errors->first('name') != null) echo "has-error"?>">
                                                    <label class="col-sm-3 control-label">Name:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="name" placeholder="Name">
                                                        <span class="validator_output <?php if ($errors->first('name') != null) echo "help-block"?>">{{ $errors->first('name') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group <?php if ($errors->first('email') != null) echo "has-error"?>">
                                                    <label class="col-sm-3 control-label">email:</label>
                                                    <div class="col-sm-9">
                                                        <input type="email" class="form-control" name="email" placeholder="Enter your email address">
                                                        <span class="validator_output <?php if ($errors->first('email') != null) echo "help-block"?>">{{ $errors->first('email') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group <?php if ($errors->first('phone') != null) echo "has-error"?>">
                                                    <label class="col-sm-3 control-label">Phone:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="phone" placeholder="Enter your phone number">
                                                        <span class="validator_output <?php if ($errors->first('phone') != null) echo "help-block"?>">{{ $errors->first('phone') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-9 col-sm-offset-3">
                                                        <button type="submit" class="btn btn-primary">Go</button>
                                                    </div>
                                                </div>
                                          {{Form::close()}}
                                        </div>
                                    </div>
                                </div>
                              </div>                                                
                        </div>
                    </div>
                    <!-- block about-block -->
                </div>
                <!-- block-wrapper -->
                <div class="clearfix"></div>
            </div>
        </div><!-- row -->
    </div><!-- container -->
</section>
@stop