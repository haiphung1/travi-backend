<?php

namespace App\Listeners;

use App\Events\ExampleEvent;
use App\Events\NotificationLikeEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificationLikeListeners
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
     * @param  ExampleEvent  $event
     * @return void
     */
    public function handle(NotificationLikeEvent $event)
    {
        //
    }
}
