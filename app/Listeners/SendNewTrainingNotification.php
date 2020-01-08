<?php

namespace App\Listeners;


use Notification;
use Carbon\Carbon;
use App\Jobs\SendNotificationEmails;
use App\Notifications\NewExperienceNotification;
use App\Events\NewExperience;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewExperienceNotification
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
     * @param  NewExperience  $event
     * @return void
     */
    public function handle(NewExperience $event)
    {
        // Notification::send($event->experience->reachableUsers(),new NewExperienceNofication($event->experience));
        
        // queue the mailing job instead...
        foreach($event->experience->reachableUsers() as $recipient){
            SendNotificationEmails::dispatch($recipient, new NewExperienceNotification($event->experience))
                            ->onQueue(config('custom.notification_mail_queue'))
                            ->delay(Carbon::now()->addSeconds(config('custom.queue_delay')));
        }
    }
}
