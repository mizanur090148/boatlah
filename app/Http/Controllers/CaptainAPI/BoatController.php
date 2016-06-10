<?php

namespace App\Http\Controllers\CaptainAPI;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Validator;
use Sentinel;

use App\User;
use App\Boat;
use App\BoatCaptainProfile;
use App\RelBoatsCaptains;

class BoatController extends CaptainAPIController
{
    /**
     * Get Boat Status
     */
    public function getBoatStatus($boat_id)
    {
        $user = Auth::guard('api')->user();

        if ($user){
            $boat = Boat::where('unique_id',$boat_id)->with('owner')->first();
            return $this->apiResponse('success', '200', $boat);
        } else {
            return $this->apiResponse('error', '401', 'No Valid Token');
        }
    }

    /**
     * Update Current Boat Status
     */
    public function updateBoatStatus($boat_id, Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user){
            $boat = Boat::where('unique_id',$boat_id)->first();
            $boat->status = Input::get('status');
            if ($boat->save()){
                $responseData = ['status' => $boat->status];
                return $this->apiResponse('success', '200', $responseData);
            } else {
                return $this->apiResponse('error', '401', 'Sorry! Error in updating status.');
            }
        } else {
            return $this->apiResponse('error', '401', 'No Valid Token');
        }
    }

    /**
     * Update Current Boat Status
     */
    public function updateBoatLocation($boat_id, Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user){
            $boat = Boat::where('unique_id',$boat_id)->first();
            $boat->latitude = Input::get('latitude');
            $boat->longitude = Input::get('longitude');
            if ($boat->save()){
                return $this->apiResponse('success', '200', 'Boat Location Updated Successfully');
            } else {
                return $this->apiResponse('error', '401', 'Sorry! Error in updating location.');
            }
        } else {
            return $this->apiResponse('error', '401', 'No Valid Token');
        }
    }
    

}
