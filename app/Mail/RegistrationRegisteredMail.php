<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class RegistrationRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public Registration $registration;
    public string $badgePath;

    public function __construct(Registration $registration, string $badgePath)
    {
        $this->registration = $registration;
        $this->badgePath = $badgePath;
    }

    public function build()
    {
        return $this
            ->subject('Registration Successful')
            ->view('emails.registration-registered');
    }
}