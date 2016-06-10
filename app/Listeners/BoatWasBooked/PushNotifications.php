<?php

namespace App\Listeners\BoatWasBooked;

use App\Events\BoatWasBooked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use PushNotification;

class PushNotifications
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

        $captain = $trip->captain;

        $device_reg_id = $captain->device_registration_id;

        if (isset($device_reg_id) && $device_reg_id!=''){

            $app = PushNotification::app('developmentAndroidCaptain');

            $new_client = new \Zend\Http\Client(null, array(
                'adapter' => 'Zend\Http\Client\Adapter\Socket',
                'sslverifypeer' => false
            ));
            $app->adapter->setHttpClient($new_client);

            $pushNotification = [
                'title' => 'Hello '.$captain->name,
                'description' => 'You have a new Trip',
                'trip_unique_id' => $trip->trip_id
            ];

            $app->to($device_reg_id)->send(json_encode($pushNotification));
        }
    }
}
