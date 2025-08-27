<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CollegeEditedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $collegeName;
    public $editTime;
    public $editedFields;
    public $studentId;

    public function __construct($studentName, $studentId, $collegeName, $editTime, $editedFields = [])
    {
        $this->studentName = $studentName;
        $this->studentId = $studentId;
        $this->collegeName = $collegeName;
        $this->editTime = $editTime;
        $this->editedFields = $editedFields;
    }

    public function build()
    {
        return $this->subject('College Information Edited')
            ->markdown('emails.college_edited')
            ->with([
                'studentName' => $this->studentName,
                'studentId' => $this->studentId,
                'collegeName' => $this->collegeName,
                'editTime' => $this->editTime,
                'editedFields' => $this->editedFields,
            ]);
    }
}
