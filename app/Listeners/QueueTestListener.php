<?php

namespace App\Listeners;

use App\Events\QueueTest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueueTestListener implements ShouldQueue
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
     * @param  QueueTest  $event
     * @return void
     */
    public function handle(QueueTest $event)
    {
        $sum = 0;
        for($i=0;$i<=200000000;$i++){
            $sum+=$i;
        }
    }
}
