<?php

namespace App\Http\Controllers\Coordinator;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Http\Request;
use Sentinel;
use File;

use App\Events\BoatWasBooked;
use App\Events\MoneyCollectedforTrip;

use App\User;
use App\Boat;
use App\BoatCoardinatorProfile;
use App\BaseAnchorage;
use App\BoatUserProfile;
use App\WalkingBoatUser;

class BoatController extends DashboardController {

    public function index() { 

        $data['current_page'] = 'Boats';
        
        $myProfile = BoatCoardinatorProfile::where('user_id', $this->coordinatorUserID)->with('boatOwner')->first();

        $is_valid_profile = $this->isValidProfile($myProfile);

        if(!$is_valid_profile)
            dd('Sorry! this is not a valid coordiantor profile');

        $myOwnerId = $myProfile->boat_owner;
        $myZone = $myProfile->location;
        
        if($myOwnerId) {
        	$data['companies'] = \App\Contracts::where('owner_id', '=', $myOwnerId)->where('company_id', '!=', 'NULL')->groupBy('company_id')->get();
        	$data['boats'] = Boat::where(['user_id' => $myOwnerId, 'operating_zone' => $myZone])->orderBy('status')->get();
        } else {
        	$data['companies'] = [];
        	$data['boats'] = [];
        }

        $data['my_profile'] = $myProfile;
        
        return view('coordinator.dashboard.boat.index', $data);
    }

    public function map() { 

        $data['current_page'] = 'Boats';
        
        $myProfile = BoatCoardinatorProfile::where('user_id', $this->coordinatorUserID)->with('boatOwner')->first();
        
        $myOwnerId = $myProfile->boat_owner;
        $myZone = $myProfile->location;
        
        if($myOwnerId) {
            $data['companies'] = \App\Contracts::where('owner_id', '=', $myOwnerId)->where('company_id', '!=', 'NULL')->groupBy('company_id')->get();
            $data['boats'] = Boat::where(['user_id' => $myOwnerId, 'operating_zone' => $myZone])->orderBy('status')->get();
        } else {
            $data['companies'] = [];
            $data['boats'] = [];
        }

        $data['my_profile'] = $myProfile;
        
        return view('coordinator.dashboard.boat.map', $data);
    }

    public function book($id) {

        $data['current_page'] = 'Book a Boat';
        return view('coordinator.dashboard.boat.book', $data)->with('boat_id',$id);
    }

    public function post_book()
    {
        //return Input::all();
        $email = Input::get('email');
        $boat_id = Input::get('boat_id');
        $user = User::where('email','=',$email)->where('status','=','active')->first();
        if ($user){
            return redirect('/coordinator/dashboard/book/'.$user->id.'/'.$boat_id);
        } else {
            return redirect()->back()->withInput()->with('error','Invalid User');
        }
        
    }

    public function post_book_create()
    {
        //return Input::all();

        $rules = [
            'name' => array('Regex:/^[\pL\s]+$/u'),
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|unique:users|digits_between:1,20',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('error','Please check the form carefully.');
        }
        $photo = '/images/preview.png';
        $thumb_photo = '/images/preview.png';
        $input = [
            'email' => Input::get('email'),
            'phone' => Input::get('phone'),
            'name' => Input::get('name'),
            'password'=>'123456',
            'photo' => $photo,
            'thumb_photo' => $thumb_photo
        ];

        $user = Sentinel::registerAndActivate($input);
        $userRole = Sentinel::findRoleBySlug('walkingUser');
        $userRole->users()->attach($user);

        $userRole1 = Sentinel::findRoleBySlug('user');
        $userRole1->users()->attach($user);

        $boat_user = new WalkingBoatUser();
        $boat_user->user_id = $user->id;
        $boat_user->save();

        $boat_user = new BoatUserProfile();
        $boat_user->user_id = $user->id;
        $boat_user->save();

        return redirect('/coordinator/dashboard/book/'.$user->id.'/'.Input::get('boat_id'));
    }

    public function book_boat($user_id, $boat_id)
    {
        $data['current_page'] = 'Book a Boat';
        $boat = Boat::find($boat_id);
        if($boat->status!='available' || $boat->captain==null ){
            return redirect('coordinator/dashboard/boats')->with('error','Sorry! This boat is not available right now.');
        }
        $anchorages = BaseAnchorage::where('type','=',$boat->operating_zone)->get();
        return view('coordinator.dashboard.boat.book_boat',$data)->with([
            'user_id'=> $user_id,
            'boat'=> $boat,
            'anchorages' => $anchorages
        ]);
    }

    public function post_book_boat()
    {
        $rules = [
            'trip_type' => 'required',
            'payment_status' => 'required',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('error','Please check the form carefully.');
        }
        $trip_data = [
            'boat_id' => Input::get('boat_id'),
            'start_point'=> Input::get('start_point'),
            'destination_point'=> Input::get('end_point'),
            'trip_type'=> Input::get('trip_type'),
            'user_id'=> Input::get('user_id'),
            'zone'=> Input::get('zone'),
            'vessel_name'=>  Input::get('vessel_name'),
            'accompanying_passenger'=>  Input::get('accompanying_passenger'),
            'remarks'=> Input::get('remarks'),
            'booked_by'=> Sentinel::getUser()->id,
            'others'=> null,
            'passenger_name'=> null,
        ];

        $trip = insertNewTrip($trip_data);

        if ($trip['status']=='success'){

            Event::fire(new BoatWasBooked($trip['trip']->id));

            if(Input::get('payment_status')=='paid'){
                
                $payment_info['trip_unique_id'] =  $trip['trip']->trip_id;
                $payment_info['collected_user_type'] = 'coordinator';
                $payment_info['collected_by_user'] = $this->coordinatorUserID;
                $payment_info['cost'] = $trip['trip']->cost;
                $payment_info['payment_method'] = 'cash';

                Event::fire(new MoneyCollectedforTrip($payment_info));
            }
                        
            return redirect('/coordinator/dashboard/boats')->with('success','Boat booked successfully');
        } else {
            return redirect('boats/profile/'.Input::get('boat_id'))->with('error',$trip['message']);
        }
    }

    private function isValidProfile($profile){
        return ($profile->boat_owner == null) ? false : true;
    }

}
