<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        // Génère l'URL de réinitialisation vers la route nommée 'password.reset'
        $url = route('password.reset', [
            'token' => $this->token,
            'email' => $this->email,
        ]);

        return $this->subject('Réinitialisation de votre mot de passe')
                    ->view('emails.reset-password')
                    ->with(['url' => $url]);
    }
}