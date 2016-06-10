<?php

namespace App\Http\Controllers\Coordinator;

use App\Boat;
use App\BoatCoardinatorProfile;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Sentinel;

use Event;
use App\Events\BoatWasBooked;
use App\BaseAnchorage;
use App\AdvanceBooking;

class AdvanceBookingController extends DashboardController
{
    private $ownerUserID, $coordinatorZone;

    public function __construct()
    {
        parent::__construct();
        $currentCoordinator = BoatCoardinatorProfile::where('id', $this->coordinatorProfileID)->first();
        $this->ownerUserID =  $currentCoordinator->boat_owner;
        $this->coordinatorZone =  $currentCoordinator->location;
    }

    public function myBookings()
    {
        $data['current_page'] = 'My Booking';
        $data['pending_booking_lists'] = AdvanceBooking::where('owner_user_id', '=', $this->ownerUserID)->where('status', '=', 'pending')->where('zone','=',$this->coordinatorZone)->get();
        $data['approved_booking_lists'] = AdvanceBooking::where('owner_user_id', '=', $this->ownerUserID)->where('status', '=', 'approved')->where('zone','=',$this->coordinatorZone)->get();
        // return $data['pending_booking_lists'];
        return view('coordinator.dashboard.advance-booking.my-bookings', $data);
    }

    public function book($id)
    {
        $booking = AdvanceBooking::find($id);
        $boats = Boat::where('user_id', $this->ownerUserID)->where('status','=','available')->where('captain_id', '!=' ,'NULL')->get();

        //$data['contracted_owners'] = BoatOwnerProfile::all();
        $data['Eastern_anchorages'] = BaseAnchorage::where('type', 'Eastern')->get();
        $data['Western_anchorages'] = BaseAnchorage::where('type', 'Western')->get();
        $data['current_page'] = 'Book Now';
        $data['booking'] = $booking;
        return view('coordinator.dashboard.advance-booking.book', $data)->with('boats', $boats);
    }

    public function postBook()
    {
        //return Input::all();
        $rules = [
            'boat_id' =>'required'
        ];
        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('error','booking can not be completed, provide correct data');
        }

        $boats = Input::get('boat_id');
        $user_id = Input::get('user_id');
        $trip_type = Input::get('trip_type');
        $zone = Input::get('zone');

        $vessel_name = Input::get('vessel_name');
        $accompanying_passenger = Input::get('accompanying_passenger');
        $remarks = Input::get('remarks');

        if ($zone == 'Eastern') {
            $start_point = Input::get('Eastern_start_point');
            $destination_point = Input::get('Eastern_end_point');
         } elseif ($zone == 'Western') {
            $start_point = Input::get('Western_start_point');
            $destination_point = Input::get('Western_end_point');
        }

        else
        {
            $start_point = '';
            $destination_point = '';
        }
            foreach ($boats as $boat) {

                $trip_data = [
                    'boat_id' => $boat->id,
                    'start_point'=> $start_point,
                    'destination_point'=> $destination_point,
                    'trip_type'=> $trip_type,
                    'user_id'=> $user_id,
                    'zone'=> $zone,
                    'vessel_name'=>  $vessel_name,
                    'accompanying_passenger'=>  $accompanying_passenger,
                    'remarks'=> $remarks,
                    'booked_by'=> Sentinel::getUser()->id,
                    'others'=> null,
                    'passenger_name'=> null,
                ];

                $trip = insertNewTrip($trip_data);

                if ($trip['status']=='success'){
                    Event::fire(new BoatWasBooked($trip['trip']->id));
                    return redirect('/user/dashboard/my_trips')->with('success','Boat booked successfully');
                } else {
                    return redirect('boats/profile/'.Input::get('boat_id'))->with('error',$trip['message']);
                }
            
            }

            return redirect('/coordinator/dashboard/my-advance-bookings')->with('success', 'Boat booked successfully');

    }

    public function approve($id)
    {
        //return $id;
        AdvanceBooking::where('id', '=', $id)->update(['status' => 'approved']);

        return redirect('/coordinator/dashboard/my-advance-bookings')->with('success', 'Advanced booking approved');

    }
}
