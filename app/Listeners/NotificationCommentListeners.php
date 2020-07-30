<?php

namespace App\Listeners;

use App\Events\ExampleEvent;
use App\Events\NotificationCommentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificationCommentListeners
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
    public function handle(NotificationCommentEvent $event)
    {
        //
    }
}
