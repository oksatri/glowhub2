<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class BookingCreated implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function broadcastOn()
    {
        return new Channel('bookings');
    }

    public function broadcastWith()
    {
        return [
            'booking_id' => $this->booking->id,
            'mua_id' => $this->booking->mua_id,
            'customer_name' => $this->booking->customer_name,
            'selected_date' => $this->booking->selected_date->toDateString(),
            'selected_time' => $this->booking->selected_time,
            'status' => $this->booking->status,
        ];
    }
}
