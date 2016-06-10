<?php

namespace App\Http\Controllers\Company;

use File;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Http\Request;
use Sentinel;

use App\ShippingCompanyProfile;

class ProfileController extends DashboardController
 {

    public function index() 
    { 
        $data['current_page'] = 'Profile';

        $data['user_info'] = ShippingCompanyProfile::findOrFail($this->companyProfileID);

        return view('company.dashboard.profile.index', $data);
    }

    public function edit() 
    { 
        $data['current_page'] = 'Profile';

        $data['user_info'] = ShippingCompanyProfile::findOrFail($this->companyProfileID);

        return view('company.dashboard.profile.edit', $data);
    }

    public function update(Request $request) { 

        $rules = [
            'username' => 'required|unique:users,username,'.$this->companyUserID,
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'type_of_firm'=>'required',
            'owner_name' => array('required','Regex:/^[\pL\s]+$/u'),
            'address'=>'required',
            'gender'=>'required',
            'registration_date'=>'required',
            'registration_uen'=>array('required','Regex:/^(\d{9})([A-Z])$/'),
            'email' => 'required|email|unique:users,email,'.$this->companyUserID,
            'phone' => 'required|numeric|unique:users,phone,'.$this->companyUserID,
            'photo' => 'max:2048|mimes:jpg,jpeg,png,gif'
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('error','profile can not be updated, provide correct data');
        }

        $photo = Input::file('photo');
        $destinationPath = '/uploads/users/';
        if($photo!=null)
        {
            $filename = $photo->getClientOriginalName();
            $photo->move(public_path() . $destinationPath, $filename);
            $photo = $destinationPath.$filename;
            resize( $destinationPath,$filename,300,'/thumbnail'.$destinationPath);
            $thumb_photo = '/thumbnail'.$destinationPath.'thumb_'.$filename;
        } else {
            $photo = Sentinel::getUser()->photo;
            $thumb_photo = Sentinel::getUser()->thumb_photo;
        }

        // Insert into User table
        $company_input = [
            'email' => Input::get('email'),
            'phone' => Input::get('phone'),
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'address' => Input::get('address'),
            'photo' => $photo,
            'thumb_photo' => $thumb_photo,
        ];

        $boat_company = ShippingCompanyProfile::findOrFail($this->companyProfileID);
        $user = Sentinel::findById($boat_company->user_id);
        Sentinel::update($user, $company_input);

        //Update Profile Table
        $boat_company = ShippingCompanyProfile::findOrFail($this->companyProfileID);          
        $boat_company->user_id = $user->id;
        $boat_company->about = $request->about;
        $boat_company->owner_name = $request->owner_name;
        $boat_company->type_of_firm = $request->type_of_firm;
        $boat_company->gender = $request->gender;
        $boat_company->registration_uen = $request->registration_uen;
        $boat_company->registration_date = $request->registration_date;
        $boat_company->about = $request->about;
        $boat_company->save();

        return redirect('company/dashboard')->with('success','Company information updated successfully');
    }

}
