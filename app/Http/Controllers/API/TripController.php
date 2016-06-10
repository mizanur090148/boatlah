<?php

namespace App\Http\Controllers\API;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Validator;
use Sentinel;

use App\Boat;
use App\Booking;
use App\Catalog;
use App\CatalogInfo;
use App\BoatUserProfile;
use App\BoatCoardinatorProfile;
use App\Trip;

class TripController extends Controller
{
    
    /**
     * Display my trips
     */
    public function myTrips()
    {
        $user = Auth::guard('api')->user();

        $trips = Trip::where('user_id', $user->id);

        $filter = Input::get('status');

        if($filter){
            $trips->where('status', $filter);
        }

        $trips = $trips->with(['boat.owner.user','start', 'destination','captain','owner'])->get();


        return response()->json([
            'data' => [
                'trips' => $trips,
            ]
        ], 200);
    }

    /**
     * Display my trips
     */
    public function getTripDetails($trip_unique_id)
    {
        $user = Auth::guard('api')->user();

        $trip = Trip::where('trip_id', $trip_unique_id)->with('boat', 'captain')->first();

        if ($trip){
            $coordinaotor = getCoordinatorForThisTrip($trip->id);

            return response()->json([
                'data' => [
                    'coordinator' => $coordinaotor,
                    'boat' => $trip->boat,
                    'captain' => $trip->captain,
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'msg' => 'Invalid Trip!'
                ]
            ], 404);
        }
        
    }

    /**
     * Pay for the trip
     */
    public function pay($trip_unique_id)
    {
        $rules = [
            'collected_user_type' => 'required',
            'payment_method' => 'required',
            'collected_by_user' => 'required'
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

        $trip = Trip::where('trip_id', $trip_unique_id);

        $payment = payForTrip($trip->trip_unique_id, Input::get('payment_method'), Input::get('collected_user_type'), Input::get('collected_by_user'));

        if ($payment){
                return response()->json([
                    'data' => [
                        'trips' => $trip,
                    ]
                ], 200);
        } else {
            return response()->json([
                'error' => [
                    'msg' => 'Payment was not successfull!'
                ]
            ], 404);
        }

    }

}
