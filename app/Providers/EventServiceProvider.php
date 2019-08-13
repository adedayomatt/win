<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Verified::class => [
            'App\Listeners\SendWelcomeMail'
        ],
        'App\Events\NewTraining' => [ 
            'App\Listeners\SendNewTrainingNotification'
        ],
        'App\Events\NewDiscussion' => [
            'App\Listeners\SendNewDiscussionNotification'
        ],
        'App\Events\NewComment' => [
            'App\Listeners\SendNewCommentNotificationToAuthor',
            'App\Listeners\SendNewCommentNotificationToContributors'
        ],
        'App\Events\NewCommentReply' => [
            'App\Listeners\SendNewCommentReplyNotification',
        ],

        'App\Events\NewCommentLike' => [
            'App\Listeners\SendNewCommentLikeNotification'
        ]

];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
