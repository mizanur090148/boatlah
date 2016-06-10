<?php

namespace App\Http\Controllers\Owner;

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

use App\BoatOwnerProfile;

class ProfileController extends DashboardController
 {

    public function index() 
    { 
        $data['current_page'] = 'Profile';

        $data['user_info'] = BoatOwnerProfile::findOrFail($this->ownerProfileID);

        return view('owner.dashboard.profile.index', $data);
    }

    public function edit() 
    { 
        $data['current_page'] = 'Profile';

        $data['user_info'] = BoatOwnerProfile::findOrFail($this->ownerProfileID);

        return view('owner.dashboard.profile.edit', $data);
    }

    public function update(Request $request) { 
    
        $rules = [
            'username' => 'required|unique:users,username,'.$this->ownerUserID,
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'company_name' => array('required','Regex:/^[\pL\s]+$/u'),
            'type_of_firm' => 'required',
            'uen_number' => array('required','Regex:/^(\d{9})([A-Z])$/'),
            'date_of_registration' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->ownerUserID,
            'phone' => 'required|numeric|unique:users,phone,'.$this->ownerUserID,
            'invoice_header_image' => 'max:2048|mimes:jpg,jpeg,png,gif|image_size:<=600,<=72',
            'invoice_footer_image' => 'max:2048|mimes:jpg,jpeg,png,gif|image_size:<=600,<=72',
            'photo' => 'max:2048|mimes:jpg,jpeg,png,gif'
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->withInput()->with('error','profile can not be updated, provide correct data');
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
        $owner_input = [
            'email' => Input::get('email'),
            'phone' => Input::get('phone'),
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'address' => Input::get('address'),
            'photo' => $photo,
            'thumb_photo' => $thumb_photo,
        ];

        $boat_owner = BoatOwnerProfile::findOrFail($this->ownerProfileID);
        $user = Sentinel::findById($boat_owner->user_id);
        Sentinel::update($user, $owner_input);

        //Update Profile Table
        $boat_owner = BoatOwnerProfile::findOrFail($this->ownerProfileID);          
        $boat_owner->company_name = $request->company_name;
        $boat_owner->type_of_firm = $request->type_of_firm;
        $boat_owner->date_of_registration = $request->date_of_registration;
        $boat_owner->about = $request->about;
        $boat_owner->uen_number = $request->uen_number;
        $boat_owner->gst_registration = $request->gst_registration; 
        $boat_owner->invoice_bank_details = $request->invoice_bank_details;

            $destinationPath = '/uploads/header_images/';
            $destinationPath2 = '/uploads/footer_images/';

        #Invoice Header Image
        $invoice_header_image = Input::file('invoice_header_image');

        if ($invoice_header_image != null) {

            $filename1 = $invoice_header_image->getClientOriginalName();
            $invoice_header_image->move(public_path() . $destinationPath, $filename1);
            $boat_owner->invoice_header_image = $destinationPath . $filename1;
        } else {

        }
        #end

        #Invoice Footer Image
        $invoice_footer_image = Input::file('invoice_footer_image');

        if ($invoice_footer_image != null) {

            $filename2 = $invoice_footer_image->getClientOriginalName();
            $invoice_footer_image->move(public_path() . $destinationPath2, $filename2);
            $boat_owner->invoice_footer_image = $destinationPath2 . $filename2;
        } else {

        }
        #end
           
        $boat_owner->save();

        return redirect('owner/dashboard')->with('success','Profile updated successfully');
    }

}
