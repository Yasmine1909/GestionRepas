<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $notification;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->notification->type === 'success'
            ? 'Notification de Confirmation'
            : 'Notification d\'Annulation';

        return $this
            ->view('emails.notification')
            ->with('notification', $this->notification)
            ->subject($subject);
    }
}
