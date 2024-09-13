<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $otp;

    public function __construct(User $user,string $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Forgot Password',
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'mail.forgot-password',
        );
    }

    public function attachments()
    {
        return [];
    }
}
