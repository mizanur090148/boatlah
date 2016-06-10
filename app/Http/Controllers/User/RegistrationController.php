<?php

namespace App\Http\Controllers\User;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Sentinel;

use Event;
use App\Events\NewUserRegistered;

use App\User;
use App\BoatUserProfile;

class RegistrationController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }


    public function register()
    {
        return view('user.auth.signup');
    }


    public function postRegister(Request $request)
    {
        //return Input::all();
        $rules = [
            'username' => 'required|unique:users',
            'name' => array('Regex:/^[\pL\s]+$/u'),
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|unique:users|digits_between:1,20',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'agree' => 'required'
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('error','profile can not be created, provide correct data');
        }

        // Insert into User table
        $input = [
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'phone' => Input::get('phone'),
            'name' => Input::get('name'),
            'username' => Input::get('username'),
        ];

        $user = Sentinel::register($input);

        Event::fire(new NewUserRegistered($user->id, 'user'));
        
        return redirect('login')->with('flash_message', 'Registration successful, Check email to activate');
    }

}
