@extends('user.layout')

@section('title')
    Owner Sign Up
@stop

@section('content')
    <section class="section-page-banner">
        <div class="bg-layer"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="page-header has-bg">
                        <h2 class="top-header">Boat listing is easy</h2>
                        <h4 class="sub-header">Boatlah lets you make money renting out your boat.</h4>
                    </div><!-- page-header -->
                </div>
            </div>
        </div>
    </section><!-- section-page-banner -->

    <!-- Section-boat-list -->
    <section class="section-boat-listing">
        <div class="container">

            <div class="row">
                <div class="">
                    <div class="boat-list-form">
                        <form action="{{  url('owner/register')}}" class="boat-registration-form" id="boat-registration-form" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-md-6">
                                <div class="inner">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2 class="text-center">User info</h2>
                                            <hr />
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="userName">Username</label>
                                                <input type="text" class="form-control" id="userName" name="username" value="{{old('username')}}" placeholder="User Name"/>
                                                {!! $errors->first('username','<p class="text-danger">:message</p>') !!}
                                            </div>

                                            <div class="form-group">
                                                <label for="">Email </label>
                                                <input type="email" class="form-control" name="email" value="{{old('email')}}" id="ownerMail" placeholder="Enter mail ID"/>
                                                {!! $errors->first('email','<p class="text-danger">:message</p>') !!}
                                            </div><!-- form-group -->
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
                                                <label for="userConfirmPassword">Confirm Password</label>
                                                <input type="password" class="form-control" id="userConfirmPassword" name="password_confirmation" autocomplete="off" placeholder="Confirm Password"/>
                                                {!! $errors->first('password_confirmation','<p class="text-danger">:message</p>') !!}
                                            </div>

                                            {{--<div class="form-group">--}}
                                                {{--<label for="">Gender</label>--}}
                                                {{--<select name="gender" class="form-control">--}}
                                                    {{--<option value="">Select One</option>--}}
                                                    {{--<option value="male" @if(\Illuminate\Support\Facades\Input::old('gender')=='male') selected @endif>Male</option>--}}
                                                    {{--<option value="female" @if(\Illuminate\Support\Facades\Input::old('gender')=='female') selected @endif>Female</option>--}}
                                                {{--</select>--}}
                                                {{--{!! $errors->first('gender','<p class="text-danger">:message</p>') !!}--}}
                                            {{--</div><!-- form-group -->--}}

                                        </div><!-- col-md-12 -->
                                    </div><!-- row -->
                                </div><!-- inner -->
                            </div>

                            <div class="col-md-6">
                                <div class="inner">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2 class="text-center">Company info</h2>
                                            <hr />
                                        </div>
                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label for="">Company Name</label>
                                                <input type="text" class="form-control" name="company_name" value="{{old('company_name')}}" id="company_name" placeholder="Company Name"/>
                                                {!! $errors->first('company_name','<p class="text-danger">:message</p>') !!}
                                            </div><!-- form-group -->
                                            <div class="form-group">
                                                <label for="">UEN</label>
                                                <input type="text" class="form-control" name="uen_number" value="{{old('uen_number')}}" id="uen_number" placeholder="UEN Number"/>
                                                {!! $errors->first('uen_number','<p class="text-danger">:message</p>') !!}
                                            </div><!-- form-group -->
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                <input type="text" class="form-control" name="address" value="{{old('address')}}" id="address" placeholder="Address"/>
                                                {!! $errors->first('address','<p class="text-danger">:message</p>') !!}
                                            </div><!-- form-group -->
                                            <div class="form-group">
                                                <label for="">Name (Contact Person)</label>
                                                <input type="text" class="form-control" name="name" value="{{old('name')}}" id="address" placeholder="Name"/>
                                                {!! $errors->first('name','<p class="text-danger">:message</p>') !!}
                                            </div><!-- form-group -->
                                        </div><!-- col-md-12 -->
                                       

                                        <div class="col-md-12">
                                            <hr />
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="checkbox-inline">
                                                    <label for="agree-legal"  class="agree-legal">
                                                        <input type="checkbox" id="agree-legal" name="agree"/>
                                                        By Signing up, you agree to Boatlah's
                                                        <a href="https://boathlah.com/legal" target="_blank">Terms of Use</a>,
                                                        <a href="https://boathlah.com/legal" target="_blank">Privacy Policy</a>,
                                                        &amp; <a href="https://boathlah.com/legal" target="_blank">Member Interface Agreement</a>.

                                                    </label>
                                                </div>
                                                {!! $errors->first('agree','<p class="text-danger">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-block">Register Now</button>
                                            </div>
                                        </div>
                                    </div><!-- row -->
                                </div><!-- inner -->
                            </div>
                        </form>
                    </div><!-- boat-list-form -->
                </div>
            </div><!-- row -->
        </div><!-- container -->
    </section>
@stop