@extends('user.layout')

@section('title')
    Reset Password
@stop

@section('content')
    <section class="section-form">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                    <div class="form-wrapper">
                        <div class="signup">
                            @include('common.flash')
                            <form action="{{  url('user/reset_password')}}" class="signup-form" id="signup-form" method="POST">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="hidden" name="code" value="{{ $code}}">
                                <div class="form-group">
                                    <label for="userPass">New Password </label>
                                    <input type="password" class="form-control" id="userPass" name="password" placeholder="Password"/>
                                    {!! $errors->first('password','<p class="text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="userPassConf">New Password Confirmation</label>
                                    <input type="password" class="form-control" id="userPassConf" name="password_confirmation" placeholder="Confirm Password"/>
                                    {!! $errors->first('password_confirmation','<p class="text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="signUpSubmit" class="sr-only"></label>
                                    <button type="submit"  id="signUpSubmit" class="btn btn-primary full">Reset Password</button>
                                </div>

                            </form>
                        </div>
                    </div><!-- form-wrapper -->
                </div>
            </div><!-- row -->
        </div><!-- container -->
    </section>
@stop