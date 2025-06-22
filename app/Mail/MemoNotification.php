<?php

namespace App\Mail;

use App\Models\Memo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemoNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $memo;

    public function __construct(Memo $memo)
    {
        $this->memo = $memo;
    }

    public function build()
    {
        return $this->subject('New Memo from the Dean')
            ->view('emails.memo')
            ->with(['memo' => $this->memo]);
    }

    /**
     * Get the message envelope.
     */


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
