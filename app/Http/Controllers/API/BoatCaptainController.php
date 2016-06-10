<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\BoatCaptainProfile;



class BoatCaptainController extends Controller
{
    /**
     * Display the boat owner
     */
    public function show($id)
    {
        $captain = BoatCaptainProfile::where('user_id', $id)->with('user')->first();

        if (!$captain){
            return response()->json([
                'error' => [
                    'msg' => 'Not Found!'
                ]
            ], 404);
        }

        return response()->json([
            'data' => $captain->toArray(), 
        ], 200);
    }
}
