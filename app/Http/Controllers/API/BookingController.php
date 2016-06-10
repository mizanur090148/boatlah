<?php

namespace App\Http\Controllers\API;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Validator;
use Sentinel;
use PushNotification;

use Event;
use App\Events\BoatWasBooked;

use App\Boat;
use App\Booking;
use App\Catalog;
use App\CatalogInfo;
use App\BoatUserProfile;
use App\Trip;

class BookingController extends Controller
{
    /**
     * Cost Calculator
     */
    public function costCalculator(Request $request)
    {

        $rules = [
            'boat_id' => 'required',
            'start_point' => 'required',
            'destination_point' => 'required',
            'trip_type' => 'required',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return response()->json([
                'error' => [
                    'msg' => 'Validation Failed!',
                    'validation_errors' => $validator->errors()->all()
                ]
            ], 400);
        }

        $user = Auth::guard('api')->user();
        $boat_user = BoatUserProfile::where('user_id', $user->id)->first();

        $isAvailable = $this->isThisBoatAvailable(Input::get('boat_id'));
        if(!$isAvailable) 
            return response()->json([
                'error' => [
                    'msg' => 'Sorry! This Boat is not available'
                ]
            ], 400);

        $booking_info = Input::all();

        $boat = Boat::where('id', $booking_info['boat_id'])->with('captain.user','owner.user')->first();

        $journey_cost_info = getJourneyCost($boat->user_id, $boat_user->company_id, $booking_info['trip_type'], $boat->manning_type, $boat->operating_zone, $booking_info['start_point'], $booking_info['destination_point']);
        $journey_cost = $journey_cost_info['cost'];
        if(isset($journey_cost_info['contract_id'])){
            $journey_cost_info['catalog_info']['payment_options'] = ['invoice'];
        } else {
             $journey_cost_info['catalog_info']['payment_options'] = ['cash'];
        }


        if ($journey_cost==null)
            return response()->json([
                'error' => [
                    'msg' => 'Sorry! The catalog is not available'
                ]
            ], 400);

        return response()->json([
            'data' => [
                'cost_information' => $journey_cost_info['catalog_info'],
                'boat_information' => $boat,
            ]
        ], 200);
    }

    /**
     * Book a boat
     */
    public function bookNow(Request $request)
    {
        $rules = [
            'boat_id' => 'required',
            'start_point' => 'required',
            'destination_point' => 'required',
            'trip_type' => 'required',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return response()->json([
                'error' => [
                    'msg' => 'Validation Failed!',
                    'validation_errors' => $validator->errors()->all()
                ]
            ], 400);
        }

        $user = Auth::guard('api')->user();

        $booking_info = Input::all();

        //Final Data in Array
        $trip_data = [
            'boat_id' => $booking_info['boat_id'],
            'start_point'=> $booking_info['start_point'],
            'destination_point'=> $booking_info['destination_point'],
            'trip_type'=> $booking_info['trip_type'],
            'user_id'=> $user->id,
            'zone'=> $booking_info['zone'],
            'vessel_name'=> $booking_info['vessel_name'],
            'accompanying_passenger'=>  $booking_info['accompanying_passenger'],
            'remarks'=> $booking_info['remarks'],
            'booked_by'=> $user->id,
            'others'=> null,
            'passenger_name'=> null,
        ];

        $trip = insertNewTrip($trip_data);

        if ($trip['status']=='success'){
            
            Event::fire(new BoatWasBooked($trip['trip']->id));

            $booking['trip'] = $trip['trip'];

            return response()->json([
                'data' => [
                    'booking' => $booking,
                ]
            ], 200);           
        } else {
            return response()->json([
                'error' => [
                    'msg' => $trip['message']
                ]
            ], 400);
        }        
    }


    /**
     * Display my bookings
     */
    public function myBookings()
    {
        $user = Auth::guard('api')->user();

        $bookings = Booking::where('user_id', $user->id)->get();

        return response()->json([
            'data' => [
                'bookings' => $bookings,
            ]
        ], 200);
    }

    /**
     * Is the Boat Availabe?
     */
    private function isThisBoatAvailable($boat_id)
    {

        $boat = Boat::where('id', $boat_id)->first();

        if( isset($boat) && ($boat->status=='available' && $boat->captain_id!=null))
            return TRUE;
        else 
            return FALSE;
    }

}
