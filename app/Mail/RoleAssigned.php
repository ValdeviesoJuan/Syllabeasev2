<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoleAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $roleName;

    public function __construct($user, $roleName)
    {
        $this->user = $user;
        $this->roleName = $roleName;
    }

    public function build()
    {
        return $this->subject('New Role Assigned in SyllabEase')
                    ->view('emails.role_assigned');
    }
}
