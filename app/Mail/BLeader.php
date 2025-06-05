<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\Department;
use App\Models\User;
use App\Models\BayanihanGroup;
class BLeader extends Mailable
{
    use Queueable, SerializesModels;
    public $chairperson;
    public $user;
    public $department;
    public $bGroup; 

    /**
     * Create a new message instance.
     */
    public function __construct(User $user,  User $chairperson, Department $department, BayanihanGroup $bGroup)
    {
        $this->user = $user;
        $this->bGroup = $bGroup;
        $this->chairperson = $chairperson;
        $this->department = $department;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bayanihan Leader Assignment',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Mails.blMail',
        );
    }

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
