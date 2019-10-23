<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\PurchaseOrderRequest;
use App\User;

class SeniorManagerApproval extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $purchase_order_request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $purchase_order_request)
    {
        $this->user =$user;
        $this->purchase_order_request = $purchase_order_request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject( 'Purchase order request from '. $this->user->name )
        ->view('emails.approval-requests.senior-manager');
    }
}
