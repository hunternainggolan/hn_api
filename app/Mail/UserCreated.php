<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Mailable
{
    public $user_name;
    public $user_email;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(string $user_name,string $user_email)
    {
        //
        $this->user_name = $user_name;
        $this->user_email = $user_email;    
    }


    public function build()
    {
        return $this->subject('New User Registered')->html(' <h1>Hello ' . $this->user_name . ',</h1><p>Your account ' . $this->user_email . ' has been successfully created.</p>');
    }
}
