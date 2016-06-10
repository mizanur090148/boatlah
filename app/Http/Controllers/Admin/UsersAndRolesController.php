<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\BoatCaptainProfile;
use App\BoatCoardinatorProfile;
use App\BoatOwnerProfile;
use App\CSR;
use App\ShippingCompanyProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Sentinel;

use App\User;
use App\BoatUserProfile;

class UsersAndRolesController extends Controller
{
    public function index()
    {
        $users = Sentinel::getUserRepository()->with('roles')->get();
        return view('admin.users-and-roles.index')->with('users',$users);
    }

    public function show($id)
    {
        $user = Sentinel::findById($id);
        $roles = $user->getRoles();
        return view('admin.users-and-roles.manage_account')->with('user',$user)->with('roles',$roles);
    }

    public function create_user_role($id)
    {
        //return $id;
        $user = Sentinel::findById($id);
        $roles = Sentinel::getRoleRepository()->where('slug','!=','admin')->where('slug','!=','walkingUser')->get();
        return view('admin.users-and-roles.create_user_role')->with('user',$user)->with('roles',$roles);
    }

    public function store(Request $request){
        //return Input::all();
        $rules = [
            'name' => 'required',
        ];
        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $name = Input::get('name');
        $user = Sentinel::findById(Input::get('user_id'));
        $userRole = Sentinel::findRoleById($name);
        if($user->inRole($userRole))
        {
            return redirect('/admin/users-and-roles/'.Input::get('user_id'))->with('error','Data already exist');
        }
        $userRole->users()->attach($user);

        if($userRole->slug=='admin')
        {
            $adminProfiles = new  Admin();
            $adminProfiles->user_id = $user->id;
            $adminProfiles->save();
        } else if($userRole->slug=='owner'){
            $ownerProfiles =new BoatOwnerProfile();
            $ownerProfiles->user_id = $user->id;
            $ownerProfiles->save();

        } else if($userRole->slug=='coordinator'){
            $coordinatorProfiles =new BoatCoardinatorProfile();
            $coordinatorProfiles->user_id = $user->id;
            $coordinatorProfiles->save();

        } else if($userRole->slug=='captain'){
            $captainProfiles =new BoatCaptainProfile();
            $captainProfiles->user_id = $user->id;
            $captainProfiles->save();

        } else if($userRole->slug=='user'){
            $boatUserProfiles =new BoatUserProfile();
            $boatUserProfiles->user_id = $user->id;
            $boatUserProfiles->save();

        } else if($userRole->slug=='company'){
            $companyProfiles =new ShippingCompanyProfile();
            $companyProfiles->user_id = $user->id;
            $companyProfiles->save();

        } else if($userRole->slug=='csr'){
            $csrProfiles =new CSR();
            $csrProfiles->user_id = $user->id;
            $csrProfiles->save();
        }

        return redirect('/admin/users-and-roles/'.Input::get('user_id'))->with('success','Data created Successfully');
    }

    public function destroy($id)
    {
        $user = Sentinel::findById(Input::get('user_id'));
        $userRole = Sentinel::findRoleById($id);
        $userRole->users()->detach($user);

        if($userRole->slug=='admin')
        {
            Admin::where('user_id','=',$user->id)->delete();

        } else if($userRole->slug=='owner'){

            BoatOwnerProfile::where('user_id','=',$user->id)->delete();

        } else if($userRole->slug=='coordinator'){

            BoatCoardinatorProfile::where('user_id','=',$user->id)->delete();

        } else if($userRole->slug=='captain'){

            BoatCaptainProfile::where('user_id','=',$user->id)->delete();

        } else if($userRole->slug=='user'){

            BoatUserProfile::where('user_id','=',$user->id)->delete();

        } else if($userRole->slug=='company'){

            ShippingCompanyProfile::where('user_id','=',$user->id)->delete();

        } else if($userRole->slug=='csr'){

            CSR::where('user_id','=',$user->id)->delete();
        }

        return redirect('/admin/users-and-roles/'.Input::get('user_id'))->with('success','Data Deleted Successfully');
    }
}
