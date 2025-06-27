<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class DeadlineSetNotification extends Notification
{
    use Queueable;

    protected $deadline;
    protected $type;

    public function __construct($deadline, $type = 'initial') // default to 'initial'
    {
        $this->deadline = $deadline;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Deadline Reminder')
            ->line($this->getMessage());
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->getMessage(),
            'deadline_id' => $this->deadline->dl_id,
            'for' => 'Bayanihan Leader',
            'action_url' => route('bayanihanleader.syllList'),
            'course_code' => $this->deadline->course_code ?? 'N/A',
            'bg_school_year' => $this->deadline->dl_school_year ?? 'N/A',
        ];
    }

    protected function getMessage()
    {
        $date = Carbon::parse($this->deadline->dl_syll)->format('F j, Y');

        return match ($this->type) {
            '3_days_before' => "⏳ Reminder: Syllabus deadline is in 3 days — $date.",
            'due_today'     => "📌 Today is the deadline for Syllabus — $date.",
            default         => "📅 A new deadline has been set for the Syllabus on $date.",
        };
    }
}
