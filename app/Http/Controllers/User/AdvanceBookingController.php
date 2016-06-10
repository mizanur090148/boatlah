<?php

namespace App\Http\Controllers\User;

use App\Catalog;
use App\Contracts;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Sentinel;

use App\BoatUserProfile;
use App\BoatOwnerProfile;
use App\BaseAnchorage;
use App\AdvanceBooking;

class AdvanceBookingController extends DashboardController
 {
    private $company_id;

    public function __construct()
    {
        parent::__construct();
        $user = BoatUserProfile::where('user_id', $this->boatUserID)->first();
        if(!$user->company_id){
           dd('Unauthorized Page');
        } else {
            $this->company_id = $user->company_id;
        }

    }

    public function index()
    {
        $contracts = Contracts::where('company_id',$this->company_id)->get();
        $count = 0;
        $contracted_owners = [];
        if($contracts!='[]')
        {
            foreach($contracts as $contract)
            {
                $contracted_owners[$count] = BoatOwnerProfile::where('user_id','=',$contract->owner_id)->first();
                $count++;
            }
        }
        else
        {
            $contracted_owners = '[]';
        }
    	//$data['contracted_owners'] = BoatOwnerProfile::all();
    	$data['Eastern_anchorages'] = BaseAnchorage::where('type', 'Eastern')->get();
        $data['Western_anchorages'] = BaseAnchorage::where('type', 'Western')->get();

        $data['current_page'] = 'Advance Booking';

        return view('user.dashboard.advance-booking.index', $data)->with('contracted_owners',$contracted_owners);
    }

    public function store(Request $request)
    {

        //return Input::all();
        $date=date_create_from_format("d/m/Y",Input::get('booking_date'));
        $date2 =  date_format($date,"Y-m-d");
        $now = time(); // or your date as well
        $ts1 = strtotime($date2);
        $datediff = $ts1 - $now;
        $value =  ceil($datediff/(60*60*24));
        $rules = [
            'owner_user_id' => 'required',
            'booking_date' => 'required',
            'booking_time' => 'required',
            'number_of_boats' => 'required|Integer|Min:1',
            'trip_type' => 'required',
            'boat_type' => 'required',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            if($value<=2)
            return redirect()->back()->withErrors($validator)->withInput()->withInput()->with('error','booking can not be completed, provide correct data');
            else
                return redirect()->back()->withErrors($validator)->withErrors(['booking_date'=>'You can book for maximum 48 hours in advance'])->withInput()->with('error','booking can not be completed, provide correct data');
        }

        if($value>2)
            return redirect()->back()->withErrors(['booking_date'=>'You can book for maximum 48 hours in advance'])->withInput()->with('error','booking can not be completed, provide correct data');



        $booking = new AdvanceBooking();
        $booking->booking_id = uniqid();
        $booking->user_id = Sentinel::getUser()->id;
        $booking->owner_user_id =  Input::get('owner_user_id');
        $booking->booking_date = Input::get('booking_date');
        $booking->booking_time = Input::get('booking_time');
        $booking->number_of_boats = Input::get('number_of_boats');
        $booking->trip_type = Input::get('trip_type');
        $booking->boat_type = Input::get('boat_type');
        $booking->zone = Input::get('zone');
        $booking->vessel_name = Input::get('vessel_name');
        $booking->accompanying_passenger = Input::get('accompanying_passenger');
        $booking->remarks = Input::get('remarks');
        $booking->booked_by = Sentinel::getUser()->id;
        $booking->company_id = $this->company_id;
        $booking->status = 'pending';

        if (Input::get('zone') == 'Eastern'){
			$booking->start_point_id = Input::get('Eastern_start_point');
        	$booking->destination_point_id	 = Input::get('Eastern_end_point');
        } else {
        	$booking->start_point_id = Input::get('Western_start_point');
        	$booking->destination_point_id	 = Input::get('Western_end_point');
        }
        $booking->save();

        $owner = User::find( Input::get('owner_user_id'));
        $email = $owner->email;
        $name = $owner->name;
        $data['booking_id'] = $booking->booking_id;
        $data['booking_date'] = $booking->booking_date;
        $data['booking_time'] = $booking->booking_time;
        $data['number_of_boats'] = $booking->number_of_boats;
        $data['trip_type'] = $booking->trip_type;
        $data['boat_type'] = $booking->boat_type;
        $data['start_point_id'] = $booking->start->title;
        $data['destination_point_id'] = $booking->destination->title;

        \Mail::send('email.advance-booking.request', $data, function($message) use ($email, $name){
            $message->to($email, $name)
                ->subject('Advanced Booking');
        });

        return redirect('/user/dashboard/advance-booking')->with('success','Advanced Booking successful, email sent successful');
    }

    public function myBookings()
    {
        $data['current_page'] = 'My Booking';
        $data['booking_lists'] = AdvanceBooking::where('user_id','=',Sentinel::getUser()->id)->get();
        return view('user.dashboard.advance-booking.my-bookings',$data);
    }

    public function resent($id)
    {
        $booking = AdvanceBooking::find($id);
        $owner = User::find($booking->owner_user_id);
        $email = $owner->email;
        $name = $owner->name;
        $data['booking_id'] = $booking->booking_id;
        $data['booking_date'] = $booking->booking_date;
        $data['booking_time'] = $booking->booking_time;
        $data['number_of_boats'] = $booking->number_of_boats;
        $data['trip_type'] = $booking->trip_type;
        $data['boat_type'] = $booking->boat_type;
        $data['start_point_id'] = $booking->start->title;
        $data['destination_point_id'] = $booking->destination->title;

        \Mail::send('email.advance-booking.request', $data, function($message) use ($email, $name){
            $message->to($email, $name)
                ->subject('Advanced Booking');
        });

        return redirect('/user/dashboard/my-advance-bookings')->with('email resent successfully');
    }
}
