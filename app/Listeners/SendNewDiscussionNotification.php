<?php

namespace App\Listeners;

use Notification;
use App\Notifications\NewDiscussionNofication;
use App\Events\NewDiscussion;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewDiscussionNotification
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
     * @param  NewDiscussion  $event
     * @return void
     */
    public function handle(NewDiscussion $event)
    {
        Notification::send($discussion->reachableUsers(),new NewDiscussionNofication($event->discussion));
    }
}
