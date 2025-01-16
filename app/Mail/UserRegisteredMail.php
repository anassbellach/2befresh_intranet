<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $this->user->getKey(),
                'hash' => sha1($this->user->getEmailForVerification()),
            ]
        );

        return $this->subject('Welcome to 2BeFresh!')
            ->view('emails.user-registered')
            ->with([
                'firstName' => $this->user->user_firstname,
                'lastName' => $this->user->user_lastname,
                'verificationUrl' => $verificationUrl,
            ]);
    }
}
