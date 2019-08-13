<?php

namespace App\Listeners;
use Notification;
use App\Notifications\NewTrainingNofication;
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
        Notification::send($training->reachableUsers(),new NewTrainingNofication($event->discussion));
    }
}
