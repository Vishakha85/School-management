<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Assignment;
use App\Models\Student;

class AssignmentDelivered extends Mailable
{
    use Queueable, SerializesModels;

    public $assignment;
    public $student;

    public function __construct(Assignment $assignment, Student $student)
    {
        $this->assignment = $assignment;
        $this->student = $student;
    }

    public function build()
    {
        return $this->subject('New Assignment Available')
                    ->view('emails.assignment_delivered');
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Assignment Delivered',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
