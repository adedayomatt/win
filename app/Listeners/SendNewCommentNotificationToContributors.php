<?php

namespace App\Listeners;

use Notification;
use App\Notifications\NewCommentNotificationForContributors;
use App\Events\NewComment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewCommentNotificationToContributors
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
     * @param  NewComment  $event
     * @return void
     */
    public function handle(NewComment $event)
    {
        Notification::send($event->comment->discussion()->contributors(), new NewCommentNotificationForContributors($event->comment));
    }
}
