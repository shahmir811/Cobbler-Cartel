<?php

namespace App\Mail\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $verification_key;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function build()
    {
        return $this->subject("Password reset link")
                    ->markdown('emails.auth.forgot-password');
    }
}
