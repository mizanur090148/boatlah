<?php

namespace App\Http\Controllers\Admin;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Validator;
use Redirect;
use Sentinel;

use Event;
use App\Events\AdminApprovedUser;

use App\BoatOwnerProfile;


class BoatOwnerController extends Controller
{

    public function index()
    {
        $allboatowners = BoatOwnerProfile::all();
        return view('admin.boat-owners.index')->with('allboatowners', $allboatowners);
    }
    
    public function show($id)
    {
        $boat_owner = BoatOwnerProfile::findOrFail($id);
        return view('admin.boat-owners.show')->with('boat_owner', $boat_owner);
    }

    public function edit($id)
    {
        $boat_owner = BoatOwnerProfile::findOrFail($id);
        return view('admin.boat-owners.edit')->with('boat_owner', $boat_owner);
    }

    public function update(Request $request, $id)
    {
        $boat_owner = BoatOwnerProfile::findOrFail($id);
        $rules = [
            'username' => 'required|unique:users,username,'.$boat_owner->user_id,
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'company_name' => array('required','Regex:/^[\pL\s]+$/u'),
            'type_of_firm' => 'required',
            'uen_number' => array('required','Regex:/^(\d{9})([A-Z])$/'),
            'date_of_registration' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users,email,'.$boat_owner->user_id,
            'phone' => 'required|numeric|unique:users,phone,'.$boat_owner->user_id,
            'invoice_header_image' => 'max:2048|mimes:jpg,jpeg,png,gif',
            'invoice_footer_image' => 'max:2048|mimes:jpg,jpeg,png,gif',
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
            $photo = $boat_owner->user->photo;
            $thumb_photo = $boat_owner->user->thumb_photo;
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

        $user = Sentinel::findById($boat_owner->user_id);
        Sentinel::update($user, $owner_input);

        //Update Profile Table
        $boat_owner = BoatOwnerProfile::findOrFail($id);
        $boat_owner->company_name = Input::get('company_name');
        $boat_owner->type_of_firm = Input::get('type_of_firm');
        $boat_owner->gender = Input::get('gender');
        $boat_owner->landline = Input::get('landline');
        $boat_owner->uen_number = Input::get('uen_number');
        $boat_owner->date_of_registration = Input::get('date_of_registration');
        $boat_owner->about = Input::get('about');
        $boat_owner->gst_registration = Input::get('gst_registration');
        $boat_owner->invoice_bank_details = Input::get('invoice_bank_details');
        
        #photos
            $destinationPath = '/uploads/header_images/';
            $destinationPath2 = '/uploads/footer_images/';

        $invoice_header_image = Input::file('invoice_header_image');

        if ($invoice_header_image != null) {
            $filename1 = $invoice_header_image->getClientOriginalName();
            $invoice_header_image->move(public_path() . $destinationPath, $filename1);
            $boat_owner->invoice_header_image = $destinationPath . $filename1;
        } 

        $invoice_footer_image = Input::file('invoice_footer_image');

        if ($invoice_footer_image != null) {
            $filename2 = $invoice_footer_image->getClientOriginalName();
            $invoice_footer_image->move(public_path() . $destinationPath2, $filename2);
            $boat_owner->invoice_footer_image = $destinationPath2 . $filename2;
        }
        #end photos

        $boat_owner->save();

        return redirect('admin/boat-owners')->with('success',"Boat Owner Data updated successfully");
    }

    public function destroy($id)
    {
        $owner = BoatOwnerProfile::find($id);

        $user = Sentinel::findById($owner->user_id);

        $user->delete();

        return redirect('/admin/boat-owners')->with('success',"Boat Owner Data deleted successfully");
    }

    public function pendingList()
    {
        $owners = BoatOwnerProfile::all();
        $allboatowners = [];
        foreach($owners as $owner)
        {
            $cc = User::where('status','=','pending')->where('id','=',$owner->user_id)->first();
            if($cc!=null)
            {
                $allboatowners[] = $cc;
            }
        }
        return view('admin.boat-owners.pending_list')->with('allboatowners', $allboatowners);
    }

    public function status($type,$id)
    {
        \App\User::where('id','=',$id)->update(['status'=>$type]);
        if($type=='active')
        {
            Event::fire(new AdminApprovedUser($id));
        }
        return redirect('/admin/boat-owners/pendingList');
    }
}
