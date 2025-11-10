<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewBookingNotification extends Notification
{
    use Queueable;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'mua_id' => $this->booking->mua_id,
            'mua_service_id' => $this->booking->mua_service_id,
            'customer_name' => $this->booking->customer_name ?? optional($this->booking->customer)->name,
            'selected_date' => $this->booking->selected_date->toDateString(),
            'selected_time' => $this->booking->selected_time,
            'status' => $this->booking->status,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => $this->toDatabase($notifiable)
        ]);
    }
}
