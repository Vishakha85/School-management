<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentEditedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $editTime;
    public $editedFields;

    /**
     * Create a new message instance.
     */
    public function __construct($studentName, $editTime, $editedFields = [])
    {
        $this->studentName = $studentName;
        $this->editTime = $editTime;
        $this->editedFields = $editedFields;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Student Information Edited')
            ->markdown('emails.student_edited')
            ->with([
                'studentName' => $this->studentName,
                'editTime' => $this->editTime,
                'editedFields' => $this->editedFields,
            ]);
    }
}
