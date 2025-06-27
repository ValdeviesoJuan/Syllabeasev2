<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeanSyllabusChairApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $course_code, $bg_school_year, $syll_id;

    public function __construct($course_code, $bg_school_year, $syll_id)
    {
        $this->course_code = $course_code;
        $this->bg_school_year = $bg_school_year;
        $this->syll_id = $syll_id;
    }

    public function build()
    {
        return $this->subject('Syllabus Approved by Chairperson')
                    ->view('emails.dean_syllabus_approved');
    }
}
