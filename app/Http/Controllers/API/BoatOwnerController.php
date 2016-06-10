<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\BoatOwnerProfile;

class BoatOwnerController extends Controller
{
    /**
     * Display the boat owner
     */
    public function show($id)
    {
        $owner = BoatOwnerProfile::where('user_id', $id)->with('user','boats.captain.user')->first();
        if (!$owner){
            return response()->json([
                'error' => [
                    'msg' => 'Not Found!'
                ]
            ], 404);
        }

        return response()->json([
            'data' => $owner->toArray(), 
        ], 200);
    }
}
