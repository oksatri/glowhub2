<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_method_id',
        'amount',
        'status',
        'payment_reference',
        'payment_details',
        'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'paid_at' => 'datetime'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function markAsPaid($reference = null, $details = null)
    {
        $this->update([
            'status' => 'paid',
            'payment_reference' => $reference,
            'payment_details' => $details,
            'paid_at' => now()
        ]);

        // Update booking status
        $this->booking->update(['payment_status' => 'paid']);
    }

    public function generatePaymentReference()
    {
        return 'INV-' . str_pad($this->id, 8, '0', STR_PAD_LEFT) . '-' . date('Ymd');
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'failed' => 'Pembayaran Gagal',
            'cancelled' => 'Dibatalkan',
            default => 'Unknown'
        };
    }

    public function getStatusColor()
    {
        return match($this->status) {
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary',
            default => 'secondary'
        };
    }
}
