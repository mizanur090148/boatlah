<?php

namespace App\Listeners\BoatWasBooked;

use App\Events\BoatWasBooked;
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
     * @param  BoatWasBooked  $event
     * @return void
     */
    public function handle(BoatWasBooked $event)
    {
        $trip = $event->trip;
        $trip_id = $trip->trip_id;

         //Send Notification Boat Owner        
        $user_data['trip_id'] = $trip_id;
        $user_data['email'] = $trip->user->email;
        $user_data['name'] = $trip->user->name;        
        Mail::send('email.new-booking.notify-user', $user_data, function($message) use($user_data) {
            $message->to($user_data['email'], $user_data['name'])
                ->subject('Thanks for booking a boat with Boatlah');
        });

        //Send Notification Boat Owner        
        $owner_data['trip_id'] = $trip_id;
        $owner_data['email'] = $trip->owner->email;
        $owner_data['name'] = $trip->owner->name;        
        Mail::send('email.new-booking.notify-owner', $owner_data, function($message) use($owner_data) {
            $message->to($owner_data['email'], $owner_data['name'])
                ->subject('A new booking was created at Boatlah');
        });

    }
}
