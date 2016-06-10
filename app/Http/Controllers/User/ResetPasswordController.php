<?php

namespace App\Http\Controllers\User;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Sentinel;

use Event;
use App\Events\UserForgotPassword;

use App\User;
use App\BoatUserProfile;

class ResetPasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }


    public function forget_password()
    {
        return view('user.auth.forget_password');
    }


    public function forget_password_post(Request $request)
    {
       // return Input::all();
        $rules = [
            'email' => 'required|email',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Sentinel::findByCredentials(['email' => Input::get('email')]);
        if($user==null)
        {
            return redirect()->back()->withErrors($validator)->withInput()->with('error','No user found in our record belongs to this email');
        }

        Event::fire(new UserForgotPassword($user->id));

        return redirect('login')->with('success', 'Check email to reset password');
    }

    public function reset_password($id,$code)
    {
        $user = Sentinel::findById($id);
        if (Reminder::exists($user, $code)) {
            return view('user.auth.reset_password')->with(['id'=>$id,'code'=>$code]);
        }
        else {
            //incorrect info was passed
            return redirect('/')->with('error','Incorrect information for password reset');
        }
    }

    public function reset_password_post()
    {
        //return Input::all();
        $rules = [
            'password' => 'required',
            'password_confirmation' => 'required',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = Sentinel::findById(Input::get('id'));
        $reminder = Reminder::exists($user, Input::get('code'));
        if ($reminder == false) {
            return redirect('/')->with('error','Incorrect information for password reset');
        }
        if (Input::get('password') != Input::get('password_confirmation')) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error','Passwords must match');
        }

        Reminder::complete($user, Input::get('code'), Input::get('password'));
        return redirect('/')->with('success','reset password successful');
    }

}
