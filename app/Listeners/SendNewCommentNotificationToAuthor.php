<?php

namespace App\Listeners;

use Notification;
use App\Notifications\NewCommentNotificationForAuthor;
use App\Events\NewComment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewCommentNotificationToAuthor
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
        Notification::send($event->comment->discussion()->user, new NewCommentNotificationForAuthor($event->comment));
    }
}
