<?php

namespace App\Http\Controllers\Captain;

use App\Trip;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\BoatCaptainProfile;

class CaptainController extends Controller
 {

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $captain = BoatCaptainProfile::where('user_id', $id)->first();
        $trips = Trip::where('captain_id','=',$id)->where('status','=','completed')->get();
        return view('captain.profile')->with('captain', $captain)->with('trips', $trips);
    }

}
