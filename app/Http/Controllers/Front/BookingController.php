<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Accept price revision
     */
    public function acceptPriceRevision($id)
    {
        $booking = Booking::findOrFail($id);

        // Only allow if status is price_revised
        if ($booking->status !== 'price_revised') {
            return redirect()->back()->with('error', 'Invalid booking status');
        }

        // Update booking status to confirmed and set final price
        $booking->update([
            'status' => 'confirmed',
            'service_price' => $booking->revised_price // Update the service price to revised price
        ]);

        // Send confirmation email to MUA and admin
        try {
            // Send to MUA
            if ($booking->mua && $booking->mua->user && $booking->mua->user->email) {
                \Mail::to($booking->mua->user->email)->send(new \App\Mail\PriceAcceptedNotification($booking));
            }

            // Send to admin
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                \Mail::to($admin->email)->send(new \App\Mail\PriceAcceptedNotification($booking));
            }
        } catch (\Exception $e) {
            logger()->error('Failed to send price acceptance notifications: ' . $e->getMessage());
        }

        return view('front.booking.price-accepted', compact('booking'));
    }

    /**
     * Reject price revision
     */
    public function rejectPriceRevision($id)
    {
        $booking = Booking::findOrFail($id);

        // Only allow if status is price_revised
        if ($booking->status !== 'price_revised') {
            return redirect()->back()->with('error', 'Invalid booking status');
        }

        // Update booking status back to pending for MUA to review again
        $booking->update([
            'status' => 'pending',
            'revised_price' => null,
            'price_note' => null
        ]);

        // Send rejection email to MUA
        try {
            if ($booking->mua && $booking->mua->user && $booking->mua->user->email) {
                \Mail::to($booking->mua->user->email)->send(new \App\Mail\PriceRejectedNotification($booking));
            }
        } catch (\Exception $e) {
            logger()->error('Failed to send price rejection notification: ' . $e->getMessage());
        }

        return view('front.booking.price-rejected', compact('booking'));
    }

    public function showInvoice($id)
    {
        $booking = \App\Models\Booking::with(['mua', 'service', 'bookingPayment.paymentMethod'])->findOrFail($id);

        // Get active payment methods
        $paymentMethods = \App\Models\PaymentMethod::active()->ordered()->get();

        // Generate invoice number
        $invoiceNumber = 'INV-' . str_pad($booking->id, 8, '0', STR_PAD_LEFT) . '-' . date('Ymd');

        return view('front.booking.invoice', compact('booking', 'paymentMethods', 'invoiceNumber'));
    }
}
