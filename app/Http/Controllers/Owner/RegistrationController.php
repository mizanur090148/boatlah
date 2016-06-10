<?php

namespace App\Http\Controllers\Owner;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Sentinel;

use Event;
use App\Events\NewUserRegistered;

use App\User;
use App\BoatOwnerProfile;

class RegistrationController extends Controller
{
    /**
     * Create a new registration instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the register page.
     *
     * @return \Response
     */
    public function register()
    {
        $data['fullpage'] = TRUE;
        return view('owner.auth.signup', $data);
    }

    /**
     * Perform the registration.
     *
     * @param  Request   $request
     * @param  AppMailer $mailer
     * @return \Redirect
     */
    public function postRegister(Request $request)
    {
        //return Input::all();
        $rules = [
            'username' =>  'required|unique:users',
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'company_name' => array('required','Regex:/^[\pL\s]+$/u'),
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'uen_number' => 'required',
            'address' => 'required',
            'agree' => 'required'
        ];

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->withInput()->with('error','profile can not be created, provide correct data');
        }

        $owner_input = [
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'phone' => Input::get('phone'),
            'address' => Input::get('address'),
            'photo' => '/images/preview.png',
            'thumb_photo' => '/images/preview.png',
            'status' => 'pending'
        ];

        $ownerUser = Sentinel::register($owner_input);

        // Find the owner role using the role name
        $ownerRole = Sentinel::findRoleBySlug('owner');
        // Assign the role to the users
        $ownerRole->users()->attach($ownerUser);

        $boat_owner = new BoatOwnerProfile;
        $boat_owner->user_id = $ownerUser->id;
        $boat_owner->company_name = Input::get('company_name');
        $boat_owner->uen_number = Input::get('uen_number');
        $boat_owner->landline = '';

        $boat_owner->invoice_header_image = '';
        $boat_owner->invoice_footer_image = '';

        $boat_owner->save();

        Event::fire(new NewUserRegistered($ownerUser->id, 'owner'));
        
        return redirect('login')->with('flash_message', 'Registration successful, Please check your email to activate your account');
    }
    
}
