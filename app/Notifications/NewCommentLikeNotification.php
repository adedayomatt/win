<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewCommentLikeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     * 
     * @return void
     */
    public $comment_like;
    public function __construct($comment_like)
    {
        $this->comment_like = $comment_like; 
    }

    /**
     * Get the notification's delivery channels.
     *b
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
        $subject = $this->comment_like->user->fullname().' ('.$this->comment_like->user->username().') liked your comment on "'.$this->comment_like->comment->discussion()->title.'"';
        return (new MailMessage)
                    ->subject($subject)
                    ->view('mail.notification.new-comment-like',['subject' => $subject, 'comment_like' => $this->comment_like]);
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
