<?php

namespace App\Http\Controllers\Admin;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Validator;
use App;

use Event;
use App\Events\AdminApprovedUser;

class ShippingCompaniesController extends Controller
{

    public function index()
    {
        $shipping_companies = App\ShippingCompanyProfile::all();
        return view('admin.shipping-companies.index')->with('shipping_companies',$shipping_companies);
    }

    public function show($id)
    {
        $shipping_company = App\ShippingCompanyProfile::find($id);
        return view('admin.shipping-companies.show')->with('shipping_company',$shipping_company);
    }

    public function edit($id)
    {
        $shipping_company = App\ShippingCompanyProfile::find($id);
        return view('admin.shipping-companies.edit')->with('shipping_company',$shipping_company);
    }

    public function update(Request $request, $id)
    {
        //return Input::all();
        $companyUser = App\ShippingCompanyProfile::where('id',$id)->first();
        $rules = [
            'username' => 'required|unique:users,username,'.$companyUser->user_id,
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'type_of_firm'=>'required',
            'owner_name' => array('required','Regex:/^[\pL\s]+$/u'),
            'address'=>'required',
            'gender'=>'required',
            'registration_date'=>'required',
            'registration_uen'=>array('required','Regex:/^(\d{9})([A-Z])$/'),
            'email' => 'required|email|unique:users,email,'.$companyUser->user_id,
            'phone' => 'required|numeric|unique:users,phone,'.$companyUser->user_id,
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
            $photo = $companyUser->user->photo;
            $thumb_photo = $companyUser->user->thumb_photo;
        }

        // Insert into User table
        $company_input = [
            'email' => Input::get('email'),
            'phone' => Input::get('phone'),
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'address' => Input::get('address'),
            'photo' => $photo,
            'thumb_photo' => $thumb_photo,
        ];


        //return $companyUser;
        $user = Sentinel::findById($companyUser->user_id);
        Sentinel::update($user,$company_input);

        $shipping_companies =  App\ShippingCompanyProfile::find($id);
        $shipping_companies->user_id = $companyUser->user_id;
        $shipping_companies->type_of_firm = Input::get('type_of_firm');
        $shipping_companies->owner_name = Input::get('owner_name');
        $shipping_companies->gender = Input::get('gender');
        $shipping_companies->registration_date = Input::get('registration_date');
        $shipping_companies->registration_uen = Input::get('registration_uen');
        $shipping_companies->landline = Input::get('landline');
        $shipping_companies->about = Input::get('about');
        $shipping_companies->save();

        return redirect('admin/shipping-companies')->with('success','Data Updated Successfully');
    }

    public function destroy($id)
    {
        $companyUser = App\ShippingCompanyProfile::find($id);

        $user = Sentinel::findById($companyUser->user_id);
        $user->delete();
        $companyUser->delete();

        return redirect('admin/shipping-companies')->with('success','Data Deleted Successfully');
    }

    public function pendingList()
    {
        $companies = App\ShippingCompanyProfile::all();
        $allcompanies= [];
        foreach($companies as $company)
        {
            $cc = App\User::where('status','=','pending')->where('id','=',$company->user_id)->first();
            if($cc!=null)
            {
                $allcompanies[] = $cc;
            }
        }
        return view('admin.shipping-companies.pending_list')->with('allcompanies', $allcompanies);
    }

    public function status($type,$id)
    {
        \App\User::where('id','=',$id)->update(['status'=>$type]);
        if($type=='active')
        {
            Event::fire(new AdminApprovedUser($id));
        }
        return redirect('/admin/shipping-companies/pendingList');
    }

}
