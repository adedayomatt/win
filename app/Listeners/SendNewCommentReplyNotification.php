<?php

namespace App\Listeners;

use Auth;
use Notification;
use App\Notifications\NewCommentReplyNotification;
use App\Events\NewCommentReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewCommentReplyNotification
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
     * @param  NewCommentReply  $event
     * @return void
     */
    public function handle(NewCommentReply $event)
    {
        $other_repliers = [];
        foreach($event->reply->comment->repliers() as $replier){
            // if it's not the parent comment owner and not the person that is replying
            if($replier->id != $event->reply->comment->user->id && $replier->id != Auth::id()){
                array_push($other_repliers, $replier);
            }
        }

        if($event->reply->user->id != Auth::id()){
            // notification for the parent comment owner
            Notification::send($event->reply->comment->user, new NewCommentReplyNotification($event->reply, true));
        }
        //notification for other users aside the parent comment owner and the replier
        if(count($other_repliers) > 0){
            Notification::send(collect($other_repliers), new NewCommentReplyNotification($event->reply));
        }
    }
}
