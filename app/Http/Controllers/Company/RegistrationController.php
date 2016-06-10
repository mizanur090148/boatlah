<?php

namespace App\Http\Controllers\Company;

use App\ShippingCompanyProfile;
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
        return view('company.auth.signup', $data);
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
            'username' => 'required|unique:users',
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'company_name' => array('required','Regex:/^[\pL\s]+$/u'),
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'uen_number' => array('required','Regex:/^(\d{9})([A-Z])$/'),
            'registration_date'=>'required',
            'agree' => 'required'
        ];

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->withInput()->with('error','profile can not be created, provide correct data');
        }

        $company_input = [
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'name' => Input::get('company_name'),
            'username' => Input::get('username'),
            'phone' => Input::get('phone'),
            'status' => 'pending',
            'photo' => '/images/preview.png',
            'thumb_photo' => '/images/preview.png',
        ];

        $companyUser = Sentinel::register($company_input);

        // Find the owner role using the role name
        $companyRole = Sentinel::findRoleBySlug('company');
        // Assign the role to the users
        $companyRole->users()->attach($companyUser);

        $shipping_companies = new ShippingCompanyProfile();
        $shipping_companies->user_id = $companyUser->id;
        $shipping_companies->owner_name = Input::get('name');
        $shipping_companies->registration_date = Input::get('registration_date');
        $shipping_companies->registration_uen = Input::get('uen_number');
        $shipping_companies->save();

        Event::fire(new NewUserRegistered($companyUser->id, 'company'));

        return redirect('login')->with('flash_message', 'Registration successful, Please check your email to activate your account');
    }
    
}
