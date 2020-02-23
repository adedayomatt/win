<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewCommentReplyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $reply;
    public $comment_owner;
    public function __construct($reply, $comment_owner = false)
    {
        $this->reply = $reply;
        $this->comment_owner = $comment_owner;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if($this->comment_owner){
            $subject = $this->reply->user->fullname().' ('.$this->reply->user->username().') replied to your comment on "'.$this->reply->comment->discussion()->title.'"';
        }else{
            $subject = $this->reply->user->fullname().' ('.$this->reply->user->username().') also replied to '.$this->reply->comment->user->fullname().' ('.$this->reply->comment->user->username().')\' comment on "'.$this->reply->comment->discussion()->title.'"';
        }
        return (new MailMessage)
                    ->subject($subject)
                    ->view('mail.notification.new-comment-reply',['subject' => $subject, 'reply' => $this->reply]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
