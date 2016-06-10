<?php

namespace App\Http\Controllers\Admin;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Validator;
use Redirect;
use Sentinel;
use App\BoatCaptainProfile;


class BoatCaptainController extends Controller
{

    public function index()
    {  
        $allcaptains = BoatCaptainProfile::all();
        return view('admin.boat-captains.index')->with('allcaptains', $allcaptains);
    }

    public function show($id)
    {
        $boat_captain = BoatCaptainProfile::find($id);
        return view('admin.boat-captains.show')->with('boat_captain',$boat_captain);
    }

    public function edit($id)
    {
        $boat_owner_profiles = \App\BoatOwnerProfile::all();
        $boat_captain = BoatCaptainProfile::find($id);

        return view('admin.boat-captains.edit')->with('boat_captain',$boat_captain)->with('boat_owner_profiles',$boat_owner_profiles);
    }
   
    public function update(Request $request, $id)
    {
        $captain = BoatCaptainProfile::where('id',$id)->first();
        $rules = [
            'username' => 'required|unique:users,username,'.$captain->user_id,
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'gender'=>'required',
            'boat_owner_id'=>'required',
            'email' => 'required|email|unique:users,email,'.$captain->user_id,
            'phone' => 'required|numeric|unique:users,phone,'.$captain->user_id,
            'photo' => 'max:2048|mimes:jpg,jpeg,png,gif'
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
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
            $photo = $captain->user->photo;
            $thumb_photo = $captain->user->thumb_photo;
        }

        // Insert into User table
        $captain_input = [
            'email' => Input::get('email'),
            'phone' => Input::get('phone'),
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'address' => Input::get('address'),
            'photo' => $photo,
            'thumb_photo' => $thumb_photo,
        ];

        $user = Sentinel::findById($captain->user_id);
        Sentinel::update($user,$captain_input);        

        //Update Profile table
        $boat_captain = BoatCaptainProfile::find($id);
        $boat_captain->gender = Input::get('gender');
        $boat_captain->nric = Input::get('nric');
        $boat_captain->years_of_boating = Input::get('years_of_boating');
        $boat_captain->about = Input::get('about');
        $boat_captain->boat_owner = Input::get('boat_owner_id');
        $boat_captain->save();

        return redirect('admin/boat-captains')->with('success',"Boat Captain Data updated successfully");
    }

    public function destroy($id)
    {
        $captain = BoatCaptainProfile::find($id);
        $user = Sentinel::findById($captain->user_id);

        $user->delete();
        $captain->delete();

        return redirect('/admin/boat-captains')->with('success',"Boat Captain Data deleted successfully");

    }
}
