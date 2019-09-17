<?php

namespace App\Listeners;

use Auth;
use Notification;
use Carbon\Carbon;
use App\Jobs\SendNotificationEmails;
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
        //notification for other users aside the parent comment owner and the replier
        foreach($event->reply->comment->repliers() as $replier){
            // if it's not the parent comment owner and not the person that is replying
            if($replier->id != $event->reply->comment->user->id && $replier->id != $event->reply->user->id){
                SendNotificationEmails::dispatch($replier, new NewCommentReplyNotification($event->reply))
                                        ->onQueue(config('custom.notification_mail_queue'))
                                        ->delay(Carbon::now()->addSeconds(config('custom.queue_delay')));
            }
        }
        
        if($event->reply->user->id != $event->reply->comment->user->id){ //if the replier is not the owner of the parent comment
            // notification for the parent comment owner

            //Notification::send($recipient, $notification);
            
            // dispatch the mailing job instead...
            SendNotificationEmails::dispatch($event->reply->comment->user, new NewCommentReplyNotification($event->reply, $comment_owner = true))
                                    ->onQueue(config('custom.notification_mail_queue'))
                                    ->delay(Carbon::now()->addSeconds(config('custom.queue_delay')));

        }

    }
}
