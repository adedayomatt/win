<?php

namespace App\Listeners;

use Notification;
use App\Events\NewCommentLike;
use App\Notifications\NewCommentLikeNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewCommentLikeNotification
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
     * @param  NewCommentLike  $event
     * @return void
     */
    public function handle(NewCommentLike $event)
    {
        Notification::send($event->comment_like->comment->user, new NewCommentLikeNotification($event->comment_like));
    }
}
