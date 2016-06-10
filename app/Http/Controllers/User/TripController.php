<?php

namespace App\Http\Controllers\User;

use App\Booking;
use App\Trip;
use File;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Http\Request;
use Sentinel;

use App\BoatUserProfile;

class TripController extends DashboardController
{
    public function my_trips()
    {
        $data['trips'] =  Trip::where('user_id','=', Sentinel::getUser()->id)->get();
        $data['current_page'] = 'My Trips';
        return view('user.dashboard.trip.my-trips',$data);
    }
}
