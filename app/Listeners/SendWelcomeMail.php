<?php

namespace App\Listeners;

use Mail;
use Session;
use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeMail
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
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        Session::flash('alert_success','Congratulations, you have just verified your email. No more restrictions, you can now create tags, forums, and discussions, Enjoy!');
        Mail::to($event->user->email)->send(new WelcomeMail($event->user));
    }
}