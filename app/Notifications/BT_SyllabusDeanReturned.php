<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BT_SyllabusDeanReturned extends Notification
{
    use Queueable;

    public $course_code;
    public $bg_school_year;
    public $syll_id;
    /**
     * Create a new notification instance.
     */
    public function __construct($course_code, $bg_school_year, $syll_id)
    {
        $this->course_code = $course_code;
        $this->bg_school_year = $bg_school_year;
        $this->syll_id = $syll_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'The syllabus has been returned by the Dean.',
            'course_code' => $this->course_code,
            'bg_school_year' => $this->bg_school_year,
            'id' => $this->syll_id,
            'type' => 'syllabus',
            'for' => 'BT',
            'action_url' => route('bayanihanteacher.commentSyllabus', [$this->syll_id]),
        ];
    }
}
