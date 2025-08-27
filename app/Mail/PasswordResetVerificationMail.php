<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function build()
    {
         return $this->subject('Password Reset Verification')
                ->view('emails.password_reset_verification')
                ->with([
                    'email' => $this->email,
                    'token' => $this->token,
                ]);
    }
}
