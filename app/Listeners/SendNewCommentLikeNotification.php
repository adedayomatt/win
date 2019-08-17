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
        // don't bother to send notification if the person liking the comment is the owner
        if($event->comment_like->user->id != $event->comment_like->comment->user->id){
            Notification::send($event->comment_like->comment->user, new NewCommentLikeNotification($event->comment_like));
        }
    }
}
