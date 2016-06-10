<?php

namespace App\Listeners\AdminApprovedUser;

use App\Events\AdminApprovedUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Mail;

class EmailUser
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
     * @param  AdminApprovedUser  $event
     * @return void
     */
    public function handle(AdminApprovedUser $event)
    {
        $user = $event->user;

        $data['id'] = $user->id;
        $data['name'] = $user->name;
        $data['email'] = $user->email;

        Mail::send('email.registration.admin-approve', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])
                ->subject('Approval of your account on Boatlah');
        });
    }
}
