<?php

namespace App\Listeners\UserForgotPassword;

use App\Events\UserForgotPassword;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Illuminate\Support\Facades\Mail;

class EmailResetPasswordPage implements ShouldQueue
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
     * @param  UserForgotPassword  $event
     * @return void
     */
    public function handle(UserForgotPassword $event)
    {
        $user = $event->user;

        $reminder = Reminder::create($user);

        $data = [
            'email' => $user->email,
            'name' => $user->name,
            'subject' => 'Reset Your Password',
            'code' => $reminder->code,
            'id' => $user->id
        ];

        Mail::send('email.forget_password', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])
                ->subject($data['subject']);
        });
    }
}
