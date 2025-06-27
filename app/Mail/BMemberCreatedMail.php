<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BMemberCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $chairperson, $department, $bGroup;

    public function __construct($user, $chairperson, $department, $bGroup)
    {
        $this->user = $user;
        $this->chairperson = $chairperson;
        $this->department = $department;
        $this->bGroup = $bGroup;
    }

    public function build()
    {
        return $this->subject('You’ve been added as a Bayanihan Member')
                    ->view('emails.bayanihan_member_assigned');
    }
}
