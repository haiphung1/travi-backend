<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ExampleEvent' => [
            'App\Listeners\ExampleListener',
        ],
        'App\Events\NotificationLikeEvent' => [
            'App\Listeners\NotificationLikeListeners',
        ],
        'App\Events\NotificationCommentEvent' => [
            'App\Listeners\NotificationCommentListeners',
        ],
        'App\Events\NotificationApplyGroupEvent' => [
            'App\Listeners\NotificationApplyGroupListeners',
        ],
        'App\Events\NotificationApprovedGroupEvent' => [
            'App\Listeners\NotificationApprovedGroupListener',
        ],
        'App\Events\NotificationAddFriendEvent' => [
            'App\Listeners\NotificationAddFriendListener',
        ],
        'App\Events\NotificationApprovedFriendEvent' => [
            'App\Listeners\NotificationApprovedFriendListener',
        ],
    ];
}
