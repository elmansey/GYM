<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resetPassword extends Mailable
{
    use Queueable, SerializesModels;

   public $token;
   public $email;
   public $guard;

    public function __construct($token,$email,$guard)
    {
       $this->token = $token;
       $this->email = $email;
       $this->guard = $guard;
    }

    public function build()
    {
        return $this->markdown('emails.resetPassword')->with(['token' => $this->token,'email' => $this->email,'guard' => $this->guard]);
    }
}
