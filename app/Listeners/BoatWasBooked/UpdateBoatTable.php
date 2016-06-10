<?php

namespace App\Listeners\BoatWasBooked;

use App\Events\BoatWasBooked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateBoatTable
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
        $event->trip->boat->status = 'booked';
        $event->trip->boat->save();
    }
}
