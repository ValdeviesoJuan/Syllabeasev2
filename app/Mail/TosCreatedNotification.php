<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Tos;

class TosCreatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $tos;

    public function __construct(Tos $tos)
    {
        $this->tos = $tos;
    }

    public function build()
    {
        return $this->subject('New TOS Submitted')
                    ->view('emails.tos_created');
    }
}

