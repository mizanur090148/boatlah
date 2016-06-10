<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Attempting' => [
            'App\Listeners\LogAuthenticationAttempt',
        ],

        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],

        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\LogSuccessfulLogout',
        ],

        'Illuminate\Auth\Events\Lockout' => [
            'App\Listeners\LogLockout',
        ],

        'App\Events\NewUserRegistered' => [
            'App\Listeners\NewUserRegistered\CreateBoatUserRole',
            'App\Listeners\NewUserRegistered\EmailVerificationLink',
        ],

        'App\Events\UserVerifiedMail' => [
            'App\Listeners\UserVerifiedMail\EmailSuccessMessage',
        ],

        'App\Events\AdminApprovedUser' => [
            'App\Listeners\AdminApprovedUser\EmailUser',
        ],

        'App\Events\UserForgotPassword' => [            
            'App\Listeners\UserForgotPassword\EmailResetPasswordPage',
        ],

        'App\Events\UserCompanyInteraction' => [            
            'App\Listeners\UserCompanyInteraction\EmailNotification',
        ],

        'App\Events\BoatWasBooked' => [            
            'App\Listeners\BoatWasBooked\UpdateBoatTable',            
            'App\Listeners\BoatWasBooked\PushNotifications',
            'App\Listeners\BoatWasBooked\EmailNotifications',
        ],

        'App\Events\TripWasStarted' => [            
            'App\Listeners\TripWasStarted\UpdateTripTable',            
            'App\Listeners\TripWasStarted\PushNotifications',
            'App\Listeners\TripWasStarted\EmailNotifications',
        ],

        'App\Events\TripCapainAtPickupPoint' => [                      
            'App\Listeners\TripCapainAtPickupPoint\PushNotifications',
            'App\Listeners\TripCapainAtPickupPoint\EmailNotifications',
        ],

        'App\Events\TripWasCompleted' => [            
            'App\Listeners\TripWasCompleted\UpdateTripTable',            
            'App\Listeners\TripWasCompleted\PushNotifications',
            'App\Listeners\TripWasCompleted\GenerateInvoice',
            'App\Listeners\TripWasCompleted\EmailInvoiceAndNoitifications',
        ],

        'App\Events\MoneyCollectedforTrip' => [            
            'App\Listeners\MoneyCollectedforTrip\UpdateTripTable',
        ],

        'App\Events\QueueTest' => [            
            'App\Listeners\QueueTestListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
