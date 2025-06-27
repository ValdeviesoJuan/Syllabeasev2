<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BLeaderCreatedMail extends Mailable
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
        return $this->subject('You’ve been assigned as a Bayanihan Leader')
                    ->view('emails.bayanihan_leader_assigned');
    }
}
