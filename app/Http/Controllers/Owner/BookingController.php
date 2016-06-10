<?php

namespace App\Http\Controllers\Owner;

use App\Http\Requests;
use App\Trip;
use Sentinel;

class BookingController extends DashboardController
{

    public function myBookings()
    {
        $data['current_page'] = 'My Bookings';
        $data['upcoming_booking_lists'] = Trip::where('owner_id', '=', $this->ownerUserID)->where('status', '=', 'upcoming')->get();
        $data['ongoing_booking_lists'] = Trip::where('owner_id', '=', $this->ownerUserID)->where('status', '=', 'ongoing')->get();
        // return $data['pending_booking_lists'];
        return view('owner.dashboard.bookings.my-bookings', $data);
    }
}
