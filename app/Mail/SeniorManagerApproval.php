<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class SeniorManagerApproval extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $purchaseOrderRequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $purchaseOrderRequest)
    {
        $this->user = $user;
        $this->purchaseOrderRequest = $purchaseOrderRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject( 'Purchase order request from '. $this->user->name )
        ->view('emails.approval-requests.manager');
    }
}
