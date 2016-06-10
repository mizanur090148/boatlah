<?php

namespace App\Listeners\TripWasCompleted;

use App\Events\TripWasCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Mail;
use App\Invoice;

class EmailInvoiceAndNoitifications implements ShouldQueue
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
     * @param  TripWasCompleted  $event
     * @return void
     */
    public function handle(TripWasCompleted $event)
    {
        
        $trip = $event->trip;
        
        $invoice = Invoice::where('trip_id','=',$trip->id)->first();
        
        if($invoice)
        {
            //Send Invoice to User or Company
            $user_data['trip_unique_id'] = $trip->trip_id;
            $user_data['trip_id'] = $trip->id;
            if ($trip->contract_company!=null){
                $user_data['email'] = $trip->company->email;
                $user_data['name'] = $trip->company->name;
            } else {
                $user_data['email'] = $trip->user->email;
                $user_data['name'] = $trip->user->name;
            }
            Mail::send('email.trip-completed.send-invoice', $user_data, function($message) use($user_data) {
                $message->to($user_data['email'], $user_data['name'])
                    ->subject('Invoice for Trip '.$user_data['trip_unique_id']);
            });
            //end

            //Send Notification & Invoice to Boat Owner
            $owner_data['trip_unique_id'] = $trip->trip_id;
            $owner_data['trip_id'] = $trip->id;
            $owner_data['email'] = $trip->owner->email;
            $owner_data['name'] = $trip->owner->name;
            Mail::send('email.trip-completed.notify-owner', $owner_data, function($message) use($owner_data) {
                $message->to($owner_data['email'], $owner_data['name'])
                    ->subject('Invoice for Trip '.$owner_data['trip_unique_id']);
            });
            //end
        }
        
    }
}
