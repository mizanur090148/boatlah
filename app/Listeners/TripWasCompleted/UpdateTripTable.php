<?php

namespace App\Listeners\TripWasCompleted;

use App\Events\TripWasCompleted;
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
     * @param  TripWasCompleted  $event
     * @return void
     */
    public function handle(TripWasCompleted $event)
    {
        $event->trip->completed_at = time();
        $event->trip->status = 'completed';
        $event->trip->save();

        /*
        $event->trip->boat->status = 'available';
        $event->trip->boat->save();
        */
    }
}
