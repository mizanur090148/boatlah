<?php

namespace App\Listeners\TripWasStarted;

use App\Events\TripWasStarted;
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
     * @param  TripWasStarted  $event
     * @return void
     */
    public function handle(TripWasStarted $event)
    {
        $trip = $event->trip;
        $trip_id = $trip->trip_id;
        
        //Send Notification to Passenger
        $user_data['trip_id'] = $trip_id;
        $user_data['email'] = $trip->user->email;
        $user_data['name'] = $trip->user->name;     
        Mail::send('email.trip-start.notify-user', $user_data, function($message) use($user_data) {
            $message->to($user_data['email'], $user_data['name'])
                ->subject('Journey started for Trip '.$user_data['trip_id']);
        });

        //Send Notification Boat Owner
        $owner_data['trip_id'] = $trip_id;
        $owner_data['email'] = $trip->owner->email;
        $owner_data['name'] = $trip->owner->name;        
        Mail::send('email.trip-start.notify-owner', $owner_data, function($message) use($owner_data) {
            $message->to($owner_data['email'], $owner_data['name'])
                ->subject('Journey started for Trip '.$owner_data['trip_id']);
        });

    }
}
