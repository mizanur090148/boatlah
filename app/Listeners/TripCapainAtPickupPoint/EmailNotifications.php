<?php

namespace App\Listeners\TripCapainAtPickupPoint;

use App\Events\TripCapainAtPickupPoint;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Mail;

class EmailNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TripCapainAtPickupPoint  $event
     * @return void
     */
    public function handle(TripCapainAtPickupPoint $event)
    {
        $trip = $event->trip;
        $trip_id = $trip->trip_id;
        
        //Send Email to Passenger
        $user_data['trip_id'] = $trip_id;
        $user_data['email'] = $trip->user->email;
        $user_data['name'] = $trip->user->name;     
        Mail::send('email.trip-start.boat-is-ready', $user_data, function($message) use($user_data) {
            $message->to($user_data['email'], $user_data['name'])
                ->subject('Your boat is ready for trip #'.$user_data['trip_id']);
        });
    }
}
