<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\User;
use App\Approval;

class UserCompanyInteraction extends Event
{
    use SerializesModels;

    public $company_id, $user_id, $action_type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($company_id, $user_id, $action_type)
    {
        $this->company_id = $company_id;
        $this->user_id = $user_id;
        $this->action_type = $action_type;
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
