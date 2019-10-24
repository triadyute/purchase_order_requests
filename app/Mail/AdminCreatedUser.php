<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class AdminCreatedUser extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $random_password;
    /**
     * Create a new message instance.
     *
     * @return void
     */


    public function __construct(User $user, $random_password)
    {
        $this->user = $user;
        $this->random_password = $random_password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return 
        $this->subject('Account created for ' . $this->user->name)
        ->view('emails.users.create');
    }
}
