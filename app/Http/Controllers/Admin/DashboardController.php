<?php

namespace App\Http\Controllers\Admin;

use App\Boat;
use App\BoatCaptainProfile;
use App\BoatCoardinatorProfile;
use App\BoatOwnerProfile;
use App\CSR;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Sentinel;;
use File;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Http\Request;
use App\Admin;

class DashboardController extends Controller {

    public function index() {
        $userCount = User::count();
        $boatCount = Boat::count();
        $captainCount = BoatCaptainProfile::count();
        $coordinatorCount = BoatCoardinatorProfile::count();
        $ownerCount = BoatOwnerProfile::count();
        $adminCount = Admin::count();
        $csrCount = CSR::count();

        return view('admin.dashboard.index')->with(
            ['userCount'=>$userCount,
              'boatCount'=>$boatCount,
                'captainCount' =>$captainCount,
                'coordinatorCount' =>$coordinatorCount,
                'ownerCount' => $ownerCount,
                'adminCount' => $adminCount,
                'csrCount' => $csrCount
            ]
        );
    }

    public function profile()
    {
        $user = Sentinel::getUser();
        $admin = Admin::where('user_id','=',$user->id)->first();
        return view('admin.dashboard.profile')->with('admin',$admin)->with('user',$user);
    }

    public function edit()
    {
        $user = Sentinel::getUser();
        $admin = Admin::where('user_id','=',$user->id)->first();
        return view('admin.dashboard.edit')->with('admin',$admin)->with('user',$user);
    }

    public function post_edit($id)
    {
        //return Input::all();
        $admin = Admin::find($id);
        $rules = [
            'name' => array('Regex:/^[\pL\s]+$/u'),
            'email' => 'required|email|unique:users,email,'.$admin->user_id,
            'phone' => 'required|numeric|digits_between:1,20|unique:users,phone,'.$admin->user_id,
            'username' => 'required|unique:users,username,'.$admin->user_id,
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
            $photo = $admin->user->photo;
            $thumb_photo = $admin->user->thumb_photo;
        }

        // Insert into User table
        $input = [
            'email' => Input::get('email'),
            'phone' => Input::get('phone'),
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'address' => Input::get('address'),
            'photo' => $photo,
            'thumb_photo' => $thumb_photo,
        ];


        $user = Sentinel::findById($admin->user_id);
        Sentinel::update($user,$input);

        //Insert into Profile Table

        $admin->user_id = $user->id;
        $admin->about = Input::get('about');
        $admin->save();

        return redirect('admin/dashboard')->with('success', 'Info updated successful');
    }
}
