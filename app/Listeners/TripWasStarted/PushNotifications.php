<?php

namespace App\Listeners\TripWasStarted;

use App\Events\TripWasStarted;
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
     * @param  TripWasStarted  $event
     * @return void
     */
    public function handle(TripWasStarted $event)
    {
        $trip = $event->trip;

        //Android
        $passenger_android_device = $trip->user->consumer_device_registration_id;
        if(isset($passenger_android_device) && $passenger_android_device!=''){

            $app = PushNotification::app('developmentAndroidConsumer');
            $new_client = new \Zend\Http\Client(null, array(
                'adapter' => 'Zend\Http\Client\Adapter\Socket',
                'sslverifypeer' => false
            ));
            $app->adapter->setHttpClient($new_client);

             $pushNotification = [
                'title' => 'Hello '.$trip->user->name,
                'description' => 'Your Trip Just Started!'
            ];

            $app->to($passenger_android_device)->send(json_encode($pushNotification));
        }

        //iOs
        $passenger_ios_device = $trip->user->consumer_ios_device_token;
        if(isset($passenger_ios_device) && $passenger_ios_device!=''){
            $message = PushNotification::Message('Your Trip Just Started!',array(
                'sound' => 'default',
                'category' => 'ongoing',
                'custom' => array('trip_type' => 'ongoing')
            ));
            $app = PushNotification::app('developmentIosConsumer');
            $app->to($passenger_ios_device)->send($message);
        }
    }
}
