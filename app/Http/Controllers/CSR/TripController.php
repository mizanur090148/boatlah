<?php

namespace App\Http\Controllers\CSR;

use App\BaseAnchorage;
use App\BoatCoardinatorProfile;
use App\Trip;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TripController extends DashboardController
{
    public function trips()
    {
        $data['current_page'] = 'Trips';
        $trips = Trip::all();
        return view('csr.dashboard.trip.trips',$data)->with('trips',$trips);

    }
}
