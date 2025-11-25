<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingInvoiceNotification extends Mailable
{
    use SerializesModels;

    public $booking;
    public $bookingPayment;
    public $paymentMethods;
    public $invoiceNumber;

    public function __construct($booking, $bookingPayment, $paymentMethods)
    {
        $this->booking = $booking;
        $this->bookingPayment = $bookingPayment;
        $this->paymentMethods = $paymentMethods;
        $this->invoiceNumber = 'INV-' . str_pad($booking->id, 8, '0', STR_PAD_LEFT) . '-' . date('Ymd');
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Invoice Tagihan - #' . $this->invoiceNumber . ' - GlowHub',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.booking.invoice',
            with: [
                'booking' => $this->booking,
                'bookingPayment' => $this->bookingPayment,
                'paymentMethods' => $this->paymentMethods,
                'invoiceNumber' => $this->invoiceNumber,
                'customerName' => $this->booking->customer_name,
                'muaName' => $this->booking->mua->name ?? 'N/A',
                'serviceName' => $this->booking->service->service_name ?? 'N/A',
                'selectedDate' => $this->booking->selected_date->format('d M Y'),
                'selectedTime' => $this->booking->selected_time,
                'finalPrice' => $this->booking->revised_price ?? $this->booking->service_price,
                'dueDate' => now()->addDays(1)->format('d M Y H:i'),
                'paymentReference' => $this->bookingPayment->generatePaymentReference()
            ]
        );
    }
}
