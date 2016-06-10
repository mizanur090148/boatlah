@extends('user.layout')

@section('title')
   Forget Password
@stop

@section('content')
    <section class="section-form">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                    <div class="form-wrapper">
                        <div class="signup">
                            @include('common.flash')
                            <form action="{{  url('user/forget_password')}}" class="signup-form" id="signup-form" method="POST">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="userMail">Email </label>
                                    <input type="email" class="form-control" id="userMail" name="email" value="{{old('email')}}" placeholder="Email"/>
                                    {!! $errors->first('email','<p class="text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="signUpSubmit" class="sr-only"></label>
                                    <button type="submit"  id="signUpSubmit" class="btn btn-primary full">Email Reset Link</button>
                                </div>

                            </form>
                        </div>
                    </div><!-- form-wrapper -->
                </div>
            </div><!-- row -->
        </div><!-- container -->
    </section>
@stop