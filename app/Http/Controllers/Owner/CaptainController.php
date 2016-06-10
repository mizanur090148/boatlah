<?php

namespace App\Http\Controllers\Owner;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use File;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Sentinel;

use Event;
use App\Events\NewUserRegistered;

use App\User;
use App\BoatCaptainProfile;

class CaptainController extends DashboardController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $data['current_page'] = 'My Captains';
        $data['captains'] = BoatCaptainProfile::where('boat_owner', $this->ownerUserID)->get();
        return view('owner.dashboard.captain.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['current_page'] = 'My Captains';
        $checkCaptain = BoatCaptainProfile::where('user_id',$this->ownerUserID)->first();
        return view('owner.dashboard.captain.create', $data)->with('checkCaptain',$checkCaptain);
    }

    public function promote()
    {
        $user = Sentinel::findById($this->ownerUserID);
        $userRole = Sentinel::findRoleBySlug('captain');
        $userRole->users()->attach($user);

        $captainProfiles =new BoatCaptainProfile();
        $captainProfiles->user_id = $this->ownerUserID;
        $captainProfiles->boat_owner = $this->ownerUserID;
        $captainProfiles->save();

        return redirect('/owner/dashboard')->with('success','You are successfully promoted as Captain');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $rules = [
            'username' => 'required|unique:users',
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'gender'=>'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|unique:users',
            'password' => 'required|min:6',
            'photo' => 'max:2048|mimes:jpg,jpeg,png,gif'
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->withInput()->with('error','captain can not be created, provide correct data');
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
            $photo = '/images/preview.png';
            $thumb_photo = '/images/preview.png';
        }

        // Insert into User table
        $captain_input = [
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'phone' => Input::get('phone'),
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'address' => Input::get('address'),
            'photo' => $photo,
            'thumb_photo' => $thumb_photo,
        ];
        
        $captainUser = Sentinel::register($captain_input);
        // Find the owner role using the role name
        $captainRole = Sentinel::findRoleBySlug('captain');
        // Assign the role to the users
        $captainRole->users()->attach($captainUser);

        //Insert into Profile Table      
        $boat_captain = new BoatCaptainProfile;
        $boat_captain->user_id = $captainUser->id;
        $boat_captain->gender = Input::get('gender');
        $boat_captain->about = Input::get('about');
        $boat_captain->nric = Input::get('nric');
        $boat_captain->years_of_boating = Input::get('years_of_boating');
        $boat_captain->boat_owner = $this->ownerUserID;
        $boat_captain->save();

        Event::fire(new NewUserRegistered($captainUser->id, 'captain'));

        return redirect('/owner/dashboard/captains')->with('success','Captain created successfully');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
     {  
        $data['current_page'] = 'My Captains';
        $data['boat_captain'] = BoatCaptainProfile::findOrFail($id);
        return view('owner.dashboard.captain.edit', $data);
     }
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $captain = BoatCaptainProfile::where('id',$id)->first();
        $rules = [
            'username' => 'required|unique:users,username,'.$captain->user_id,
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'gender'=>'required',
            'email' => 'required|email|unique:users,email,'.$captain->user_id,
            'phone' => 'required|numeric|unique:users,phone,'.$captain->user_id,
            'photo' => 'max:2048|mimes:jpg,jpeg,png,gif'
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->withInput()->with('error','captain can not be updated, provide correct data');
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
        $boat_captain = BoatCaptainProfile::findOrFail($id);
        $boat_captain->gender = Input::get('gender');
        $boat_captain->about = Input::get('about');
        $boat_captain->nric = Input::get('nric');
        $boat_captain->years_of_boating = Input::get('years_of_boating');
        $boat_captain->save();

        return redirect('owner/dashboard/captains')->with('success','Captain updated successfully');
    }

    public function delete($id)
    {
        User::where('id','=',$id)->delete();

        return redirect('/owner/dashboard/captains')->with('success',"Captain removed successfully");
    }
}
