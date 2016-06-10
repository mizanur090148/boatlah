@extends('user.layout')

@section('title')
    Sign Up
@stop

@section('content')
    <section class="section-form">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                    <div class="form-wrapper">
                        <div class="signup">
                            @include('common.flash')
                            <form action="{{  url('user/register')}}" class="signup-form" id="signup-form" method="POST">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="header">
                                    <h3>Sign<span>Up</span></h3>
                                </div>
                                <div class="form-group">
                                    <div class="hr-line">
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="userName">Username</label>
                                    <input type="text" class="form-control" id="userName" name="username" value="{{old('username')}}" placeholder="User Name"/>
                                    {!! $errors->first('username','<p class="text-danger">:message</p>') !!}
                                </div>

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" placeholder="Name"/>
                                    {!! $errors->first('name','<p class="text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="userMail">Email </label>
                                    <input type="email" class="form-control" id="userMail" name="email" value="{{old('email')}}" placeholder="Email"/>
                                    {!! $errors->first('email','<p class="text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="userPhone">Phone </label>
                                    <input type="text" class="form-control" id="userPhone" name="phone" value="{{old('phone')}}" placeholder="Phone Number"/>
                                    {!! $errors->first('phone','<p class="text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="userPassword">Password</label>
                                    <input type="password" class="form-control" id="userPassword" name="password" autocomplete="off" placeholder="Password"/>
                                    {!! $errors->first('password','<p class="text-danger">:message</p>') !!}
                                </div>

                                <div class="form-group">
                                    <label for="userPasswordConfirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="userPasswordConfirmation" name="password_confirmation" autocomplete="off" placeholder="Confirm Password"/>
                                    {!! $errors->first('password_confirmation','<p class="text-danger">:message</p>') !!}
                                </div>
                                
                                <div class="form-group">
                                    <div class="checkbox-inline">
                                        <label for="agree-legal">
                                            <input type="checkbox" id="agree-legal" name="agree" />
                                            By Signing up, you agree to Boatlah's
                                            <a href="https://boathlah.com/legal" target="_blank">Terms of Use</a>, 
                                            <a href="https://boathlah.com/legal" target="_blank">Privacy Policy</a>, 
                                            &amp; <a href="https://boathlah.com/legal" target="_blank">Member Interface Agreement</a>.
                
                                        </label>
                                    </div>
                                    {!! $errors->first('agree','<p class="text-danger">:message</p>') !!}
                                </div>
                                
                                <div class="form-group">
                                    <label for="signUpSubmit" class="sr-only"></label>
                                    <button type="submit"  id="signUpSubmit" name="signUpSubmit" class="btn btn-primary full">SignUp</button>
                                </div>
                                
                            </form>
                            <div class="form-link">
                                <span>Already have an account? <a href="{{url('login')}}">Login</a></span>
                            </div>
                        </div>
                    </div><!-- form-wrapper -->
                </div>
            </div><!-- row -->
        </div><!-- container -->
    </section>
@stop