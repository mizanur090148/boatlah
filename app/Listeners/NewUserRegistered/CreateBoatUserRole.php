<?php

namespace App\Listeners\NewUserRegistered;

use App\Events\NewUserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Sentinel;

class CreateBoatUserRole
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
     * @param  NewUserRegistered  $event
     * @return void
     */
    public function handle(NewUserRegistered $event)
    {
        $user = $event->user;

        // Assign the user role to the users
        $userRole = Sentinel::findRoleBySlug('user');
        $userRole->users()->attach($user);

        //insert into profile table
        $boat_user = new \App\BoatUserProfile;
        $boat_user->user_id = $user->id;
        $boat_user->save();
    }
}
