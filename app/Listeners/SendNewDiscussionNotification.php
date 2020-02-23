<?php

namespace App\Listeners;

use Notification;
use Carbon\Carbon;
use App\Jobs\SendNotificationEmails;
use App\Notifications\NewDiscussionNotification;
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
        // Notification::send($event->discussion->reachableUsers(),new NewDiscussionNotification($event->discussion));
        
        // queue the mailing job instead...
        foreach($event->discussion->reachableUsers() as $recipient){
            if($recipient->id !== $event->discussion->user->id){ //exclude the author
                SendNotificationEmails::dispatch($recipient, new NewDiscussionNotification($event->discussion))
                                ->onQueue(config('custom.notification_mail_queue'))
                                ->delay(Carbon::now()->addSeconds(config('custom.queue_delay')));
            }
        }

    }
}
