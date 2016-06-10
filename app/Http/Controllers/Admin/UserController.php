<?php

namespace App\Http\Controllers\Admin;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Sentinel;

use App\User;
use App\BoatUserProfile;

class UserController extends Controller
{

    public function index()
    {
        $users = Sentinel::getUserRepository()->with('roles')->get();
        return view('admin.user.index')->with('users',$users);
    }

    public function show($id)
    {
        $boat_user = \App\BoatUserProfile::where('user_id', $id)->first();
        return view('admin.user.show')->with('boat_user',$boat_user);
    }

    public function edit($id)
    {
        $boat_user = \App\BoatUserProfile::where('user_id', $id)->first();
        return view('admin.user.edit')->with('boat_user',$boat_user);
    }

    public function update(Request $request, $id)
    {
       // return $id;
        $boat_user = \App\BoatUserProfile::where('id','=', $id)->first();
        $rules = [
            'username' => 'required|unique:users,username,'.$boat_user->user_id,
            'email' => 'required|email|unique:users,email,'.$boat_user->user_id,
            'phone' => 'required|numeric|unique:users,phone,'.$boat_user->user_id,
            'name' => array('Regex:/^[\pL\s]+$/u'),
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
            $photo = $boat_user->user->photo;
            $thumb_photo = $boat_user->user->thumb_photo;
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

        $user = Sentinel::findById($boat_user->user_id);
        Sentinel::update($user,$input);

        //Insert into Profile Table

        $boat_user->user_id = $user->id;
        $boat_user->about = Input::get('about');
        $boat_user->save();

        return redirect('admin/users')->with('success', 'User update successful');
    }

    public function destroy($id)
    {
        $boat_user = \App\BoatUserProfile::where('user_id', $id)->first();

        $user = Sentinel::findById($boat_user->user_id);
        $user->delete();
        $boat_user->delete();

        return redirect('admin/users')->with('success','Data Deleted Successfully');
    }

}
