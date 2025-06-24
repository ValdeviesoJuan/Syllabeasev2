<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeanAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $college;
    public $start;
    public $end;

    public function __construct($user, $college, $start, $end)
    {
        $this->user = $user;
        $this->college = $college;
        $this->start = $start;
        $this->end = $end;
    }

    public function build()
    {
        return $this->subject('You Have Been Assigned as Dean')
                    ->view('emails.dean_assigned');
    }
}