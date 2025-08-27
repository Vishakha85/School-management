<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $changes;

    public function __construct($student, $changes)
    {
        $this->student = $student;
        $this->changes = $changes;
    }

    public function build()
    {
        return $this->subject('Student Information Updated')
            ->view('emails.student_updated');
    }
}
