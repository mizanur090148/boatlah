<?php

namespace App\Http\Controllers\User;

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

use App\BoatUserProfile;

class ProfileController extends DashboardController
 {

    public function index() 
    { 
        $data['current_page'] = 'Profile';

        $data['user_info'] = BoatUserProfile::findOrFail($this->boatUserProfileID);

        return view('user.dashboard.profile.index', $data);
    }

    public function edit() 
    { 
        $data['current_page'] = 'Profile';

        $data['user_info'] = BoatUserProfile::findOrFail($this->boatUserProfileID);

        return view('user.dashboard.profile.edit', $data);
    }

    public function update(Request $request) { 
    
        $rules = [
            'username' => 'required|unique:users,username,'.$this->boatUserID,
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'email' => 'required|email|unique:users,email,'.$this->boatUserID,
            'phone' => 'required|numeric|unique:users,phone,'.$this->boatUserID,
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
        $user_input = [
            'email' => Input::get('email'),
            'phone' => Input::get('phone'),
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'address' => Input::get('address'),
            'photo' => $photo,
            'thumb_photo' => $thumb_photo,
        ];

        $boat_user = BoatUserProfile::findOrFail($this->boatUserProfileID);
        $user = Sentinel::findById($boat_user->user_id);
        Sentinel::update($user, $user_input);

        //Update Profile Table
        $boat_user = BoatUserProfile::findOrFail($this->boatUserProfileID);
        $boat_user->about = $request->about;
        $boat_user->save();

        return redirect('user/dashboard')->with('success','profile updated successfully');
    }

}
