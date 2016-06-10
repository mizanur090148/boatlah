<?php

namespace App\Http\Controllers\CSR;

use App\Http\Requests;
use App\Trip;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use Validator;
use Sentinel;

use App\Events\BoatWasBooked;

use App\Boat;
use App\BaseAnchorage;
use App\BoatUserProfile;
use App\WalkingBoatUser;

class BoatController extends DashboardController {

    public function index($user_id) {

        $data['current_page'] = 'Boats';
        $data['boats'] = Boat::where('captain_id', '!=', 'NULL')->where('status','=','available')->get();
        $data['user_id'] = $user_id;
        return view('csr.dashboard.boat.index', $data);
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

        return redirect('/csr/dashboard/boats/'.$user->id.'/'.Input::get('boat_id'));
    }

    public function book_boat($user_id, $boat_id)
    {
        $data['current_page'] = 'Book a Boat';
        $boat = Boat::find($boat_id);
        if($boat->status!='available' || $boat->captain==null ){
            return redirect('csr/dashboard/boats/'.$user_id)->with('error','Sorry! This boat is not available right now.');
        }
        $anchorages = BaseAnchorage::where('type','=',$boat->operating_zone)->get();
        return view('csr.dashboard.boat.book_boat',$data)->with([
            'user_id'=> $user_id,
            'boat'=> $boat,
            'anchorages' => $anchorages
        ]);
    }

    public function post_book_boat()
    {
        $booking_info = Input::all();
        $rules = [
            'trip_type' => 'required',
            'payment_status' => 'required',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('error','Please check the form carefully.');
        }

        //return Input::all();
        $user_id = Input::get('user_id');
        $boat_id = Input::get('boat_id');
        $start_point = Input::get('start_point');
        $end_point = Input::get('end_point');
        $trip_type = Input::get('trip_type');
        $payment_status = Input::get('payment_status');
        $boat = Boat::find($boat_id);
        $passenger = getThePassenger($user_id);

        if ($passenger==null)
            return redirect()->back()->with('error','Sorry! Invalid Passenger.');

        $journey_cost_info = getJourneyCost($boat->user_id, $passenger['company_id'], $trip_type, $boat->manning_type, $boat->operating_zone,$start_point,$end_point);
        if ($journey_cost_info==null)
            return redirect()->back()->with('error','Sorry! Costing was not found from Catalog.');
        $journey_cost = $journey_cost_info['cost'];
        if ($journey_cost==null)
            return redirect()->back()->with('error','Sorry! Costing was not found from Catalog.');

        return view('csr.dashboard.boat.confirm_booking')->with(['boat' => $boat, 'passenger' => $passenger, 'booking_info' => $booking_info,'cost'=>$journey_cost]);
    }

    public function post_book()
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
            return redirect('/user/dashboard/my_trips')->with('success','Boat booked successfully');
        } else {
            return redirect('boats/profile/'.Input::get('boat_id'))->with('error',$trip['message']);
        }
    }

    public function booking_details($booking_id)
    {
        $data['current_page'] = 'Booking Details';
        $data['trip'] = Trip::where('id','=',$booking_id)->first();
        return view('csr.dashboard.boat.booking_details',$data);
    }

}
