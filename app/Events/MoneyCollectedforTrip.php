<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Trip;

class MoneyCollectedforTrip extends Event
{
    use SerializesModels;

    public $trip, $payment_info;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($payment_info)
    {
        $this->payment_info = $payment_info;
        $this->trip = Trip::where('trip_id', $payment_info['trip_unique_id'])->first();
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
