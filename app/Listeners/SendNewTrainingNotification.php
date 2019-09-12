<?php

namespace App\Listeners;


use Notification;
use Carbon\Carbon;
use App\Jobs\SendNotificationEmails;
use App\Notifications\NewTrainingNotification;
use App\Events\NewTraining;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewTrainingNotification
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
     * @param  NewTraining  $event
     * @return void
     */
    public function handle(NewTraining $event)
    {
        // Notification::send($event->training->reachableUsers(),new NewTrainingNofication($event->training));
        
        // queue the mailing job instead...
        SendNotificationEmails::dispatch($event->training->reachableUsers(), new NewTrainingNotification($event->training))
                            ->onQueue(config('custom.notification_mail_queue'))
                            ->delay(Carbon::now()->addSeconds(config('custom.queue_delay')));

    }
}
