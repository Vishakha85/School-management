<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoursePaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $course;

    public function __construct($student, $course)
    {
        $this->student = $student;
        $this->course = $course;
    }

    public function build()
    {
        return $this->subject('New Course Payment')
            ->view('emails.course_payment');
    }
}
