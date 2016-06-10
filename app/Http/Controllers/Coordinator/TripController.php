<?php

namespace App\Http\Controllers\Coordinator;

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
        $coordinator = BoatCoardinatorProfile::where('user_id','=',$this->coordinatorUserID)->first();
        $owner_id = $coordinator->boat_owner;
        $zone = $coordinator->location;
        $start = BaseAnchorage::where('type','=',$zone)->first()->id;
        $end = BaseAnchorage::where('type','=',$zone)->orderBy('id','DESC')->first()->id;

        if(Session::has('from')&&Session::has('to'))
        {
            $from = createDbFormattedDateFromDatePicker(Session::get('from'));
            $to = createDbFormattedDateFromDatePicker(Session::get('to'));
            $trips = Trip::where('trip_date','>=',$from)->where('trip_date','<=',$to)->where('status','=','completed')
                ->where('owner_id','=',$owner_id)->whereBetween('start_point', array($start, $end))->whereBetween('destination_point', array($start, $end))->get();

            return view('coordinator.dashboard.trip.trips',$data)->with('trips',$trips)->with('from',Session::get('from'))->with('to',Session::get('to'));
        }
        else
        {
            $trips = '[]';
            return view('coordinator.dashboard.trip.trips',$data)->with('trips',$trips)->with('from',Session::get('from'))->with('to',Session::get('to'));
        }
    }

    public function trips_post()
    {
        $rules = [
            'from' => 'required',
            'to' => 'required',
        ];

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->withInput();
        }
        return redirect('/coordinator/dashboard/trips')->with('from', Input::get('from'))->with('to', Input::get('to'));
    }
}
