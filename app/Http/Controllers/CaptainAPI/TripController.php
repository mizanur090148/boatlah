<?php

namespace App\Http\Controllers\CaptainAPI;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Validator;

use Event;
use App\Events\TripWasStarted;
use App\Events\TripWasCompleted;
use App\Events\TripCapainAtPickupPoint;
use App\Events\MoneyCollectedforTrip;

use App\Trip;

class TripController extends CaptainAPIController
{
    /**
     * Show My Trips
     */
    public function index()
    {
        $user = Auth::guard('api')->user();

        if ($user){ 

            $trips = Trip::where('captain_id', $user->id);

            $filter = Input::get('status');

            if($filter){
                $trips->where('status', $filter);
            }

            $trips = $trips->with('boat', 'captain', 'user.userProfile', 'start', 'destination');

            if ($filter=='upcoming'){
               $trips = $trips->limit(1)->orderBy('trips.id','ASC')->get();
            } else {
                $trips = $trips->orderBy('trips.id','DESC')->get();
            }

            $responseData = ['trips' => $trips];

            return $this->apiResponse('success', '200', $responseData);
        } else {
            return $this->apiResponse('error', '401', 'No Valid Token');
        }
    }

    /**
     * Show Trip Details
     */
    public function show($trip_unique_id)
    {
        $user = Auth::guard('api')->user();

        if ($user){
            $trip = Trip::where('trip_id', $trip_unique_id)->with('boat', 'captain', 'user', 'start', 'destination')->first();

            if (!$trip){
                return $this->apiResponse('error', '401', 'Sorry! This trip does not exist.');
            }

            if($user->id != $trip->captain_id){
                return $this->apiResponse('error', '401', 'Sorry! You are not authorized captain for this trip.');
            }

            $responseData = ['trip' => $trip];

            return $this->apiResponse('success', '200', $responseData);
        } else {
            return $this->apiResponse('error', '401', 'No Valid Token');
        }
    }

    /**
     * Update Trip Status
     */
    public function updateStatus($trip_unique_id, Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user){
            $trip = Trip::where('trip_id', $trip_unique_id)->with('user')->first();

            if (!$trip){
                return $this->apiResponse('error', '401', 'Sorry! This trip does not exist.');
            }

            if($user->id != $trip->captain_id){
                return $this->apiResponse('error', '401', 'Sorry! You are not authorized captain for this trip.');
            }

            $status = Input::get('status');

            $trip->status = $status;

            if($status == 'ongoing'){
               Event::fire(new TripWasStarted($trip_unique_id));
            } else if($status == 'completed'){
               Event::fire(new TripWasCompleted($trip_unique_id));
            }      
            return $this->apiResponse('success', '200', 'Updated Successfully');

        } else {
            return $this->apiResponse('error', '401', 'No Valid Token');
        }
    }

    /**
     * Show Trip Details
     */
    public function notifyUser($trip_unique_id)
    {
        $user = Auth::guard('api')->user();

        if ($user){
            $trip = Trip::where('trip_id', $trip_unique_id)->with('boat', 'captain', 'user', 'start', 'destination')->first();

            if (!$trip){
                return $this->apiResponse('error', '401', 'Sorry! This trip does not exist.');
            }

            if($user->id != $trip->captain_id){
                return $this->apiResponse('error', '401', 'Sorry! You are not authorized captain for this trip.');
            }

            Event::fire(new TripCapainAtPickupPoint($trip_unique_id));

            $responseData = ['trip' => $trip];

            return $this->apiResponse('success', '200', $responseData);
        } else {
            return $this->apiResponse('error', '401', 'No Valid Token');
        }
    }

    /**
     * Collect Money From User
     */
    public function moneyCollected($trip_unique_id)
    {
        $user = Auth::guard('api')->user();

        if ($user){
            $trip = Trip::where('trip_id', $trip_unique_id)->first();

            if (!$trip){
                return $this->apiResponse('error', '401', 'Sorry! This trip does not exist.');
            }

            if($user->id != $trip->captain_id){
                return $this->apiResponse('error', '401', 'Sorry! You are not authorized captain for this trip.');
            }

            //Fire Event
            $payment_info['trip_unique_id'] =  $trip->trip_id;
            $payment_info['collected_user_type'] = 'captain';
            $payment_info['collected_by_user'] = $user->id;
            $payment_info['cost'] = $trip->cost;
            $payment_info['payment_method'] = 'cash';

            Event::fire(new MoneyCollectedforTrip($payment_info));
            //end
            
            $trip = Trip::where('trip_id', $trip_unique_id)->first();

            $responseData = ['trip' => $trip];

            return $this->apiResponse('success', '200', $responseData);
        } else {
            return $this->apiResponse('error', '401', 'No Valid Token');
        }
    }

}
