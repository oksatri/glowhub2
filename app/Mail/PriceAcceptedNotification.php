<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PriceAcceptedNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Price Revision Accepted! - #' . $this->booking->id,
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.booking.price-accepted',
            with: [
                'booking' => $this->booking,
                'bookingId' => 'BK' . $this->booking->id,
                'customerName' => $this->booking->customer_name,
                'muaName' => $this->booking->mua->name ?? 'N/A',
                'serviceName' => $this->booking->service->service_name ?? 'N/A',
                'selectedDate' => $this->booking->selected_date->format('d M Y'),
                'selectedTime' => $this->booking->selected_time,
                'finalPrice' => $this->booking->revised_price,
            ]
        );
    }

    public function attachments()
    {
        return [];
    }
}
