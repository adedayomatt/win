<?php

namespace App\Listeners;

use Notification;
use Carbon\Carbon;
use App\Jobs\SendNotificationEmails;
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
        $recipient = $event->comment->discussion()->user;
        $notification = new NewCommentNotificationForAuthor($event->comment);
        // Notification::send($recipients, $notification);

        // queue the mailing job instead...
        if($recipient->id !== $event->comment->user->id){ //if not self comment
            SendNotificationEmails::dispatch($recipient, $notification)
                        ->onQueue(config('custom.notification_mail_queue'))
                        ->delay(Carbon::now()->addSeconds(config('custom.queue_delay')));
}
    }
}
