<?php

namespace App\Listeners\NewUserRegistered;

use App\Events\NewUserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Support\Facades\Mail;

class EmailVerificationLink
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

        $data['id'] = $user->id;
        $data['name'] = $user->name;
        $data['email'] = $user->email;

        $activation = Activation::create($user);
        $data['confirmation_code'] = $activation->code;

        Mail::send('email.registration.verify', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])
                ->subject('Account Validation on Boatlah');
        });
    }
}
