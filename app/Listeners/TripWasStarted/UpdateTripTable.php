<?php

namespace App\Listeners\TripWasStarted;

use App\Events\TripWasStarted;
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
     * @param  TripWasStarted  $event
     * @return void
     */
    public function handle(TripWasStarted $event)
    {
        $event->trip->started_at = time();
        $event->trip->status = 'ongoing';
        $event->trip->save();

        $event->trip->boat->status = 'busy';
        $event->trip->boat->save();
    }
}
