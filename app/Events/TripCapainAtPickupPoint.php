<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Trip;

class TripCapainAtPickupPoint extends Event
{
    use SerializesModels;

    public $trip;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($trip_unique_id)
    {
        $this->trip_unique_id = $trip_unique_id;
        $this->trip = Trip::where('trip_id',$trip_unique_id)->with('captain','owner','user')->first();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
