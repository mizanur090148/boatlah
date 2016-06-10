<?php

namespace App\Http\Controllers\Admin;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Validator;
use Redirect;
use Sentinel;
use App\Admin;


class AdminController extends Controller
{

    public function index()
    {
        $admins = Admin::all();
        return view('admin.admins.index')->with('admins',$admins);
    }

    public function create()
    {
        return view('admin.admins.create');
    }


    public function store(Request $request)
    {
        //return Input::all();
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => array('required','unique:users','numeric'),
            'password' => 'required|min:6',
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
            $photo = '/images/preview.png';
            $thumb_photo = '/images/preview.png';
        }

        // Insert into User table
        $input = [
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'phone' => Input::get('phone'),
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'address' => Input::get('address'),
            'photo' => $photo,
            'thumb_photo' => $thumb_photo,
        ];

        $user = Sentinel::register($input);
        
        // Find the role using the role name
        $userRole = Sentinel::findRoleBySlug('admin');
        // Assign the role to the users
        $userRole->users()->attach($user);

        // By default set a user role & profile
        $userRole = Sentinel::findRoleBySlug('user');
        $userRole->users()->attach($user);
        $activation = Activation::create($user);
        $data['confirmation_code'] = $activation->code;
        $data['id'] = $user->id;

        Mail::send('email.registration.verify', $data, function($message) {
            $message->to(Input::get('email'), Input::get('name'))
                ->subject('Verify your email address');
        });

        //Insert into Profile Table
        $admin = new Admin();
        $admin->user_id = $user->id;
        $admin->about = Input::get('about');
        $admin->save();

        $boat_user = new \App\BoatUserProfile;
        $boat_user->user_id = $user->id;
        $boat_user->save();

        return redirect('admin/admins')->with('success', 'Admin create successfully, Check email to activate');
    }


    public function show($id)
    {
        $admin = Admin::find($id);
        return view('admin.admins.show')->with('admin',$admin);
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        return view('admin.admins.edit')->with('admin',$admin);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        $rules = [
            'username' => 'required|unique:users,username,'.$admin->user_id,
            'email' => 'required|email|unique:users,email,'.$admin->user_id,
            'phone' => 'required|numeric|unique:users,phone,'.$admin->user_id,
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

        return redirect('admin/admins')->with('success', 'Admin updated successful');
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);

        $user = Sentinel::findById($admin->user_id);
        $user->delete();
        $admin->delete();

        return redirect('admin/admins')->with('success','Data Deleted Successfully');

    }
}
