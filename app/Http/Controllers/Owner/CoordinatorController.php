<?php

namespace App\Http\Controllers\Owner;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use File;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use Sentinel;

use Event;
use App\Events\NewUserRegistered;

use App\User;
use App\BoatCoardinatorProfile;

class CoordinatorController extends DashboardController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $data['current_page'] = 'My Coordinators';
        $data['coordinators'] = BoatCoardinatorProfile::where('boat_owner', $this->ownerUserID)->get();
        return view('owner.dashboard.coordinator.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['current_page'] = 'My Coordinators';
        $checkCoordinator = BoatCoardinatorProfile::where('user_id',$this->ownerUserID)->first();
        return view('owner.dashboard.coordinator.create', $data)->with('checkCoordinator',$checkCoordinator);
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
            'gender' => 'required',
            'location' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|unique:users',
            'password' => 'required|min:6',
            'photo' => 'max:2048|mimes:jpg,jpeg,png,gif'
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->withInput()->with('error','coordinator can not be created, provide correct data');
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
        $coordinator_input = [
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'phone' => Input::get('phone'),
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'address' => Input::get('address'),
            'photo' => $photo,
            'thumb_photo' => $thumb_photo,
        ];
        $coordinatorUser = Sentinel::register($coordinator_input);
        // Find the owner role using the role name
        $coordinatorRole = Sentinel::findRoleBySlug('coordinator');
        // Assign the role to the users
        $coordinatorRole->users()->attach($coordinatorUser);
      
        //Insert into Profile table
        $boat_coordinator = new BoatCoardinatorProfile;
        $boat_coordinator->user_id = $coordinatorUser->id;
        $boat_coordinator->about = Input::get('about');
        $boat_coordinator->location = Input::get('location');
        $boat_coordinator->gender = Input::get('gender');
        $boat_coordinator->boat_owner = $this->ownerUserID;
        $boat_coordinator->save();

        Event::fire(new NewUserRegistered($coordinatorUser->id, 'coordinator'));

        return Redirect::to('owner/dashboard/coordinators')->with('success','Coordinator created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
     {  
        # TODO
        //AUTHORIZATION CHECK

        $data['current_page'] = 'My coordinators';
        $data['coordinator'] = BoatCoardinatorProfile::findOrFail($id);
        return view('owner.dashboard.coordinator.edit', $data);
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
        $coordinators = BoatCoardinatorProfile::where('id', $id)->first();
        $rules = [
            'username' => 'required|unique:users,username,'.$coordinators->user_id,
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'email' => 'required|email|unique:users,email,'.$coordinators->user_id,
            'phone' => 'required|numeric|unique:users,phone,'.$coordinators->user_id,
            'gender' => 'required',
            'location' => 'required',
            'photo' => 'max:2048|mimes:jpg,jpeg,png,gif'
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->withInput()->with('error','coordinator can not be updated, provide correct data');
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
        $boat_coordinator->save();

        return Redirect::to('owner/dashboard/coordinators')->with('success','Coordinator updated successfully');

    }

    public function delete($id)
    {
        User::where('id','=',$id)->delete();

        return Redirect::to('/owner/dashboard/coordinators')->with('success',"Coordinator removed successfully");
    }

    public function promote()
    {
        $data['current_page'] = 'My coordinators';
        return view('owner.dashboard.coordinator.promote', $data);
    }
    public function promote_post()
    {
        $rules = [
            'location' => 'required',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Sentinel::findById($this->ownerUserID);
        $userRole = Sentinel::findRoleBySlug('coordinator');
        $userRole->users()->attach($user);

        $coordinatorProfiles =new BoatCoardinatorProfile();
        $coordinatorProfiles->user_id = $this->ownerUserID;
        $coordinatorProfiles->boat_owner = $this->ownerUserID;
        $coordinatorProfiles->location = Input::get('location');
        $coordinatorProfiles->save();

        return redirect('/owner/dashboard')->with('success','You are successfully promoted as Coordinator');
    }
}
