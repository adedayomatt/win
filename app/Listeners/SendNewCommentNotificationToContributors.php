<?php

namespace App\Listeners;

use Notification;
use Carbon\Carbon;
use App\Jobs\SendNotificationEmails;
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
        $recipients = $event->comment->discussion()->contributors();
        $notification = new NewCommentNotificationForContributors($event->comment);

        // Notification::send($recipients, $notification);

        foreach($recipients as $recipient){
            // queue the mailing job instead...
            SendNotificationEmails::dispatch($recipient, $notification)
                            ->onQueue(config('custom.notification_mail_queue'))
                            ->delay(Carbon::now()->addSeconds(config('custom.queue_delay')));
        }

    }
}
