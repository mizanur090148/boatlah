<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Boat;

class BoatController extends Controller
{
    /**
     * Display boat list
     */
    public function index(Request $request)
    {
        $boats = Boat::with(['captain.user'])->where('status', 'available')->where('captain_id', '!=', 'null'); 

        if ( $request->input('lat') && $request->input('lon') ){
            $lat = $request->input('lat');
            $lon = $request->input('lon');
            $boats = Boat::getByDistance($lat, $lon, 8);
            return response()->json([
                'data' => $boats, 
            ], 200);
        }
        else {
            $boats = $boats->get();
            return response()->json([
                'data' => $boats->toArray(), 
            ], 200);
        }

        
    }

    /**
     * Display the specified boat.
     */
    public function show($id)
    {
        $boat = Boat::with(['owner', 'captain.user', 'coordinator', 'owner.user', 'captain.user', 'coordinator.user'])->where('id', $id)->get();

        if (!$boat){
            return response()->json([
                'error' => [
                    'msg' => 'Not Found!'
                ]
            ], 404);
        }

        return response()->json([
            'data' => $boat->toArray(), 
        ], 200);
    }

    /**
     * Display boat list by Zone
     */
    public function listByZone($zone)
    {
        $boats = Boat::with(['captain.user'])->where('operating_zone', $zone)->where('status', 'available')->where('captain_id', '!=', 'null')->get();        
                
        return response()->json([
            'data' => $boats->toArray(), 
        ], 200);
    }

    /**
     * Display boat list by Zone
     */
    public function searchResults(Request $request)
    {        
        $all_boats = Boat::with(['owner.user','captain.user']);

        if($request->input('zone'))
        $all_boats = $all_boats->where('operating_zone', $request->input('zone'));

        if($request->input('boat_type'))
        $all_boats = $all_boats->where('manning_type', $request->input('boat_type'));

        $result = $all_boats->where('status', 'available')->where('captain_id', '!=', 'null')->get();

        return response()->json([
            'data' => $result->toArray(), 
        ], 200);
        
    }

}
