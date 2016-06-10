<?php

namespace App\Listeners\UserVerifiedMail;

use App\Events\UserVerifiedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Mail;

class EmailSuccessMessage
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
     * @param  UserVerifiedMail  $event
     * @return void
     */
    public function handle(UserVerifiedMail $event)
    {
        $user = $event->user;

        $data['id'] = $user->id;
        $data['name'] = $user->name;
        $data['email'] = $user->email;

        Mail::send('email.registration.success', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])
                ->subject('Successful Registration on Boatlah');
        });
    }
}
