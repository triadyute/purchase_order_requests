<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\User;
use App\PurchaseOrderRequest;

class RequestReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $purchaseOrderRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, PurchaseOrderRequest $purchaseOrderRequest)
    {
        $this->user = $user;
        $this->purchaseOrderRequest = $purchaseOrderRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'New PO request from ' . $this->user->name,
            'url' => '/purchase-order-request'.'/'.$this->purchaseOrderRequest->id,
            'id' => $this->purchaseOrderRequest->id
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'data' =>[
                'message' =>'New PO request from ' . $this->user->name,
                'url' => '/purchase-order-request'.'/'.$this->purchaseOrderRequest->id,
                'id' => $this->purchaseOrderRequest->id
                    ]
               ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
