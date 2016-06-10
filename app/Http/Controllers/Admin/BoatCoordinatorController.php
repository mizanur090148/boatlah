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

use App\BoatCoardinatorProfile;
use App\BoatOwnerProfile;


class BoatCoordinatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allcoordinators = BoatCoardinatorProfile::all();

        return view('admin.boat-coordinators.index')->with('allcoordinators', $allcoordinators);

    }

    public function show($id)
    {
        $boat_coordinator = BoatCoardinatorProfile::findOrFail($id);
        return view('admin.boat-coordinators.show')->with('boat_coordinator', $boat_coordinator);
    }

    public function edit($id)
    {
        $boat_owner_profiles = BoatOwnerProfile::all();

        $boat_coordinator = BoatCoardinatorProfile::findOrFail($id);

        return view('admin.boat-coordinators.edit')->with('boat_coordinator', $boat_coordinator)->with('boat_owner_profiles', $boat_owner_profiles);
    }


    public function update(Request $request, $id)
    {
        $coordinators = BoatCoardinatorProfile::where('id', $id)->first();
        $rules = [
            'username' => 'required|unique:users,username,'.$coordinators->user_id,
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'gender' => 'required',
            'location' => 'required',
            'boat_owner_id' => 'required',
            'email' => 'required|email|unique:users,email,'.$coordinators->user_id,
            'phone' => 'required|numeric|unique:users,phone,'.$coordinators->user_id,
            'photo' => 'max:2048|mimes:jpg,jpeg,png,gif'
        ];

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
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
            $photo = $coordinators->user->photo;
            $thumb_photo = $coordinators->user->thumb_photo;
        }

        // Insert into User table
        $coordinator_input = [
            'email' => Input::get('email'),
            'phone' => Input::get('phone'),
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'address' => Input::get('address'),
            'photo' => $photo,
            'thumb_photo' => $thumb_photo,
        ];

        $user = Sentinel::findById($coordinators->user_id);
        Sentinel::update($user, $coordinator_input);

        //Update Profile table
        $boat_coordinator = BoatCoardinatorProfile::find($id);
        $boat_coordinator->about = Input::get('about');
        $boat_coordinator->location = Input::get('location');
        $boat_coordinator->gender = Input::get('gender');
        $boat_coordinator->boat_owner = Input::get('boat_owner_id');
        $boat_coordinator->save();

        return Redirect::to('admin/boat-coordinators')->with('success', "Boat Coordinators Data updated successfully");

    }

    public function destroy($id)
    {
       // return 'delete';
        $coordinators = BoatCoardinatorProfile::find($id);
        $rules = [
            'id' => 'exists:booking,user_id'
        ];
        $validator=Validator::make(['id'=>$coordinators->user_id],$rules);
        $user = Sentinel::findById($coordinators->user_id);
        $user->delete();

        return Redirect::to('/admin/boat-coordinators')->with('success', "Boat Coordinators Data deleted successfully");
    }
}
