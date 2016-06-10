<?php

namespace App\Http\Controllers\Boat;

use App\BoatUserProfile;
use App\Contracts;
use App\ShippingCompanyProfile;
use App\Trip;
use App\UnregisteredUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Sentinel;
use PushNotification;

use Event;
use App\Events\BoatWasBooked;

use App\Boat;
use App\BaseAnchorage;
use \App\Catalog;

class BoatController extends Controller
{
    /**
     * Display boat list
     */
    public function index()
    {
        $allBoats = Boat::where('status','available')->where('captain_id', '!=', 'null');
        $check_boats = Boat::where('status','available')->where('captain_id', '!=', 'null');
        $contracted_boats = [];
        $available_boats = [];
        if(Sentinel::check())
        {
            $passenger = getThePassenger(Sentinel::getUser()->getUserId());
            if ($passenger==null)
                return redirect()->back()->with('error','Sorry! Invalid Passenger.');

            $contracts = Contracts::where('company_id',$passenger['company_id'])->get();
            if($contracts!='[]')
            {
                foreach($contracts as $contract)
                {
                    $contracted_boats[] = $allBoats->where('user_id',$contract->owner_id)->get();
                    $check_boats = $check_boats->where('user_id','!=',$contract->owner_id);
                }
                $available_boats[] = $check_boats->get();

            }
            else{
                $available_boats[] = $allBoats->get();
            }
        }
        else {
            $available_boats[] = $allBoats->get();
        }
        
        $Eastern_anchorages = BaseAnchorage::where('type', 'Eastern')->get();
        $Western_anchorages = BaseAnchorage::where('type', 'Western')->get();
        $zone = 'Western';
        $start = '';
        $destination = '';
        $manning_type= '';
        return view('boat.index')->with([
            'available_boats' => $available_boats,
            'contracted_boats' => $contracted_boats,
            'Eastern_anchorages' => $Eastern_anchorages,
            'Western_anchorages' => $Western_anchorages,
            'manning_type'=>$manning_type,
            'zone' => $zone,
            'start'=>$start,
            'destination' =>$destination
        ]);
    }

    /**
     * Display search result
     */
    public function searchResult(Request $request)
    {
        $contracted_boats = [];
        $available_boats = [];
        $allBoats = Boat::where('status','available')->where('captain_id', '!=', 'null');
        $check_boats = Boat::where('status','available')->where('captain_id', '!=', 'null');
        $zone = 'Western';
        if($request->input('zone')){
            $allBoats = $allBoats->where('operating_zone', $request->input('zone'));
            $check_boats = $check_boats->where('operating_zone', $request->input('zone'));
        }
        if($request->input('manning_type'))
        {
            $allBoats = $allBoats->where('manning_type', $request->input('manning_type'));
            $check_boats = $check_boats->where('manning_type', $request->input('manning_type'));
        }

        if($request->input('zone')=="Western")
        {
            $zone = $request->input('zone');
            $start = $request->input('east-start-point');
            $destination = $request->input('east-destination');
            // $all_boats = $all_boats->where('anchorage_id', $request->input('east-start-point'));
        }
        elseif($request->input('zone')=="Eastern")
        {
            $zone = $request->input('zone');
            $start = $request->input('west-start-point');
            $destination = $request->input('west-destination');
           // $all_boats = $all_boats->where('anchorage_id', $request->input('west-start-point'));
        }
        else
        {
            $start = '';
            $destination = '';
        }

        if(Sentinel::check())
        {
            $passenger = getThePassenger(Sentinel::getUser()->getUserId());
            if ($passenger==null)
                return redirect()->back()->with('error','Sorry! Invalid Passenger.');

            $contracts = Contracts::where('company_id',$passenger['company_id'])->get();
            if($contracts!='[]')
            {
                foreach($contracts as $contract)
                {
                    $contracted_boats[] = $allBoats->where('user_id',$contract->owner_id)->get();
                    $check_boats = $check_boats->where('user_id','!=',$contract->owner_id);

                }
                $available_boats[] = $check_boats->get();

            }
            else{
                $available_boats[] = $allBoats->get();
            }
        }
        else {
            $available_boats[] = $allBoats->get();
        }

        if($request->input('manning_type'))
        {
           $manning_type= $request->input('manning_type');
        }
        else
        {
            $manning_type= '';
        }

        $Eastern_anchorages = BaseAnchorage::where('type', 'Eastern')->get();
        $Western_anchorages = BaseAnchorage::where('type', 'Western')->get();
                
        return view('boat.index')->with([
            'available_boats' => $available_boats,
            'contracted_boats' => $contracted_boats,
            'Eastern_anchorages' => $Eastern_anchorages,
            'Western_anchorages' => $Western_anchorages,
            'manning_type'=>$manning_type,
            'zone' =>$zone,
            'start'=>$start,
            'destination' =>$destination
        ]);
    }

    /**
     * Display the specified boat.
     */
    public function show($id, $start = NULL, $destination = NULL)
    {
        $boat = Boat::where('id',$id)->with('captain.user')->first();
        if(isset($boat->captain->user->device_registration_id) && $boat->captain->user->device_registration_id!=''){
            $this->requestCaptainLocationPush($boat->captain->user->device_registration_id);
        }
        if(Sentinel::check()){
            $boat_users = BoatUserProfile::where('company_id','=',Sentinel::getUser()->id)->get();
        } else {
            $boat_users = [];
        }

        $boat = Boat::where('id',$id)->with('captain.user')->first();

        $anchorages = BaseAnchorage::where('type', $boat->operating_zone)->get();

        return view('boat.profile')->with(['boat' => $boat, 'anchorages' => $anchorages,'start'=>$start,'destination'=>$destination,'boat_users'=>$boat_users]);
    }

    /**
     * Display the Confirm Booking Page
     */
    public function book(Request $request, $id)
    {
        $booking_info = $request->all();

        $rules = [
            'start_point' => array('required'),
            'destination_point' => array('required', 'different:start_point'),
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('error','Start & Destination point can not be same!');
        }

        $boat = Boat::findOrFail($id);

        if (isset($booking_info['for_who']) && $booking_info['for_who']==1){
            $passenger_user_id = Input::get('boat_user');
        } elseif (isset($booking_info['for_who']) && $booking_info['for_who']==2){
            $passenger_user_id = Sentinel::getUser()->id;
        } else {
            $booking_info['for_who'] = 0;
            $passenger_user_id = Sentinel::getUser()->id;
        }

        $passenger = getThePassenger($passenger_user_id);
        if ($passenger==null)
            return redirect()->back()->with('error','Sorry! Invalid Passenger.');

        $journey_cost_info = getJourneyCost($boat->user_id, $passenger['company_id'], $booking_info['trip_type'], $boat->manning_type, $boat->operating_zone, $booking_info['start_point'], $booking_info['destination_point']);
        $journey_cost = $journey_cost_info['cost'];
        if ($journey_cost==null)
            return redirect()->back()->with('error','Sorry! Costing was not found from Catalog.');

        if ($journey_cost_info['contract_id']!=null){
            $payment_method = 'invoice';
        } else {
            $payment_method = 'cash';
        }

        return view('boat.confirm_booking')->with(['boat' => $boat, 'passenger' => $passenger, 'booking_info' => $booking_info,'cost'=>$journey_cost, 'payment_method'=> $payment_method]);
    }

    /**
     * Store the booking in database
     */
    public function post_book()
    {   
        //The Booking Inputs
        $booking_info = Input::all();

        $others = null;
        $passenger_name = null;

        //If Other Passenger
        if($booking_info['for_who']==2)
        {
            $unregistered = new UnregisteredUsers();
            $unregistered->name = $booking_info['other_passenger_name'];
            $unregistered->email = $booking_info['other_email'];
            $unregistered->phone = $booking_info['other_phone'];
            $unregistered->save();

            $passenger_name = $booking_info['other_passenger_name'];
            $others = $unregistered->id;
        }

        //Final Data in Array
        $trip_data = [
            'boat_id' => $booking_info['boat_id'],
            'start_point'=> $booking_info['start_point'],
            'destination_point'=> $booking_info['destination_point'],
            'trip_type'=> $booking_info['trip_type'],
            'user_id'=> $booking_info['passenger_user_id'],
            'zone'=> $booking_info['operating_zone'],
            'vessel_name'=> $booking_info['vessel_name'],
            'accompanying_passenger'=>  $booking_info['accompanying_passenger'],
            'remarks'=> $booking_info['remarks'],
            'booked_by'=> Sentinel::getUser()->id,
            'others'=> $others,
            'passenger_name'=> $passenger_name,
        ];

        $trip = insertNewTrip($trip_data);

        if ($trip['status']=='success'){
            Event::fire(new BoatWasBooked($trip['trip']->id));
            return redirect('/user/dashboard/my_trips')->with('success','Boat booked successfully');
        } else {
            return redirect('boats/profile/'.$booking_info['boat_id'])->with('error',$trip['message']);
        }
        
    }

    private function requestCaptainLocationPush($device_registration_id){

        $app = PushNotification::app('developmentAndroidCaptain');

        $new_client = new \Zend\Http\Client(null, array(
            'adapter' => 'Zend\Http\Client\Adapter\Socket',
            'sslverifypeer' => false
        ));
        $app->adapter->setHttpClient($new_client);

        $pushNotification = [
            'to' => '/topics/current-location',
            'title' => 'Give me notification',
            'key' => 'location'
        ];

        $app->to($device_registration_id)->send(json_encode($pushNotification));
    }

    public function unauthorized()
    {
        return "Please Login as a user to book a boat";
    }

}
