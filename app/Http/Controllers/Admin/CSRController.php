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
use App\CSR;

use Event;
use App\Events\NewUserRegistered;

class CSRController extends Controller
{

    public function index()
    {
        $csr = CSR::all();
        return view('admin.csr.index')->with('csr',$csr);
    }

    public function create()
    {
        return view('admin.csr.create');
    }


    public function store(Request $request)
    {
        //return Input::all();
        $rules = [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|unique:users|digits_between:1,20',
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
        $userRole = Sentinel::findRoleBySlug('csr');
        // Assign the role to the users
        $userRole->users()->attach($user);

        //Insert into Profile Table
        $csr = new CSR();
        $csr->user_id = $user->id;
        $csr->about = Input::get('about');
        $csr->save();

        Event::fire(new NewUserRegistered($user->id, 'csr'));

        return redirect('admin/csr')->with('success', 'CSR create successfully, Check email to activate');
    }


    public function show($id)
    {
        $csr = CSR::find($id);
        return view('admin.csr.show')->with('csr',$csr);
    }

    public function edit($id)
    {
        $csr = CSR::find($id);
        return view('admin.csr.edit')->with('csr',$csr);
    }

    public function update(Request $request, $id)
    {
        //return Input::all();
        $csr = CSR::find($id);
        $rules = [
            'username' => 'required|unique:users,username,'.$csr->user_id,
            'email' => 'required|email|unique:users,email,'.$csr->user_id,
            'phone' => 'required|unique:users,phone,'.$csr->user_id,
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
            $photo = $csr->user->photo;
            $thumb_photo = $csr->user->thumb_photo;
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


        $user = Sentinel::findById($csr->user_id);
        Sentinel::update($user,$input);

        //Insert into Profile Table

        $csr->user_id = $user->id;
        $csr->about = Input::get('about');
        $csr->save();

        return redirect('admin/csr')->with('success', 'CSR updated successfully');
    }

    public function destroy($id)
    {
        //return $id;
        $csr = CSR::find($id);

        $user = Sentinel::findById($csr->user_id);
        $user->delete();
        $csr->delete();

        return redirect('admin/csr')->with('success','CSR Deleted Successfully');

    }
}
