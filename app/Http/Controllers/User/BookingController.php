<?php

namespace App\Http\Controllers\User;

use App\Booking;
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

class BookingController extends DashboardController
{
    public function my_booking()
    {
        $data['current_page'] = 'My Booking';
        $data['booking_lists'] = Booking::where('user_id','=',$this->boatUserID)->get();
        return view('user.dashboard.booking.my_booking',$data);
    }
}
