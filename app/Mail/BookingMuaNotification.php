<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingMuaNotification extends Mailable implements ShouldQueue
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
            subject: 'New Booking Request - ' . $this->booking->customer_name,
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.booking.mua-notification',
            with: [
                'booking' => $this->booking,
                'customerName' => $this->booking->customer_name,
                'customerEmail' => $this->booking->customer_email,
                'customerWhatsapp' => $this->booking->customer_whatsapp,
                'customerAddress' => $this->booking->customer_address,
                'selectedDate' => $this->booking->selected_date->format('d M Y'),
                'selectedTime' => $this->booking->selected_time,
                'serviceName' => $this->booking->service->service_name ?? 'N/A',
                'services' => $this->booking->services,
                'estimatedPrice' => $this->booking->service->price ?? 0,
            ]
        );
    }

    public function attachments()
    {
        return [];
    }
}
