<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\User;

class NewUserRegistered extends Event
{
    use SerializesModels;

    public $user, $user_type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $user_type)
    {
        $this->user_id = $user_id;
        $this->user_type = $user_type;
        $this->user = User::where('id',$user_id)->first();
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
