@extends('user.layout')

@section('title')
    Login
@stop

@section('content')	
	<section class="section-form">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
					<div class="form-wrapper">
						<div class="signin">
							@include('common.flash')
							@if($errors->has('login_error'))
	                        	<div class="alert alert-danger">{{ $errors->first('login_error') }}</div>
	                        @endif
							<form action="{{  url('login')}}" class="signin-form" id="signin-form" method="POST">
								{!! csrf_field() !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="header">
									<h3>Log<span>In</span></h3>
								</div>
								<div class="form-group">
									<div class="hr-line">
										
									</div>
								</div>
								<!-- <div class="form-group">
									<label for="userName">Name</label>
									<input type="text" class="form-control" id="userName" name="userName" Placeholder="Name"/>
								</div> -->
								<div class="form-group">
									<label for="userVerification">Username</label>
									<input type="text" class="form-control" id="userVerification" name="login" placeholder="Username"/>
									{!! $errors->first('login','<p class="text-danger">:message</p>') !!}
								</div>
								<div class="form-group">
									<label for="userPassword">Password</label>
									<input type="password" class="form-control" id="userPassword" name="password" autocomplete="off" placeholder="Password"/>
									{!! $errors->first('password','<p class="text-danger">:message</p>') !!}
								</div>
								<div class="form-group">
									<label for="signInSubmit"></label>
									<button type="submit"  id="signInSubmit" name="signInSubmit" class="btn btn-primary full">LogIn</button>
								</div>
								
						
							</form>
							
							<div class="form-link">
								<span>Don't have an account? <a href="{{url('user/register')}}">Sign Up</a> | <a href="{{url('user/forget_password')}}">Forget Password?</a></span>
							</div>
						</div>
					</div><!-- form-wrapper -->
				</div>
			</div><!-- row -->
		</div><!-- container -->
	</section>
@stop