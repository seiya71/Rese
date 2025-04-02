<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageBody;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($messageBody, $user)
    {
        $this->messageBody = $messageBody;
        $this->user = $user;
    }
    
    public function build()
    {
        return $this->subject('お知らせです')
            ->view('emails.notice')
            ->with([
                'messageBody' => $this->messageBody,
                'user' => $this->user,
            ]);
    }

}
