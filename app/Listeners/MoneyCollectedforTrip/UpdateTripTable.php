<?php

namespace App\Listeners\MoneyCollectedforTrip;

use App\Events\MoneyCollectedforTrip;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateTripTable
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
     * @param  MoneyCollectedforTrip  $event
     * @return void
     */
    public function handle(MoneyCollectedforTrip $event)
    {
        $event->trip->payment_status = 'paid';
        $event->trip->payment_method = $event->payment_info['payment_method'];
        $event->trip->collected_user_type = $event->payment_info['collected_user_type'];
        $event->trip->collected_by_user = $event->payment_info['collected_by_user'];

        $event->trip->save();
    }
}
