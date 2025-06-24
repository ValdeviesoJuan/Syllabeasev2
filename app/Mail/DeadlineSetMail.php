<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeadlineSetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $deadline;

    public function __construct($deadline)
    {
        $this->deadline = $deadline;
    }

    public function build()
    {
        return $this->subject('New Deadline Set')
            ->view('emails.deadline_set');
    }
}
