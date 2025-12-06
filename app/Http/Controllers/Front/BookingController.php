<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Mua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Check availability for a specific date
     */
    public function checkAvailability($muaId, Request $request)
    {
        $date = $request->input('date');
        
        if (!$date) {
            return response()->json([]);
        }
        
        // Get MUA data
        $mua = Mua::find($muaId);
        if (!$mua) {
            return response()->json([]);
        }
        
        $unavailableSlots = [];
        
        // Get unavailable slots from availability_hours
        if (!empty($mua->availability_hours)) {
            $availabilityHours = is_array($mua->availability_hours) ? 
                $mua->availability_hours : 
                json_decode($mua->availability_hours, true) ?? [];
            
            foreach ($availabilityHours as $slot) {
                $slotDate = \Carbon\Carbon::parse($slot['date']);
                if ($slotDate->format('Y-m-d') === $date) {
                    $unavailableSlots[] = [
                        'start' => $slot['start_time'],
                        'end' => $slot['end_time']
                    ];
                }
            }
        }
        
        // Get existing bookings for selected date
        $existingBookings = Booking::where('mua_id', $muaId)
            ->where('selected_date', $date)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->get();

        foreach ($existingBookings as $booking) {
            // Calculate blocked time range (1.5 hours before completion time)
            $completionTime = new \DateTime($booking->selected_time);
            $blockedStart = (clone $completionTime)->modify('-90 minutes');
            $blockedEnd = (clone $completionTime)->modify('+30 minutes');
            
            $unavailableSlots[] = [
                'start' => $blockedStart->format('H:i'),
                'end' => $blockedEnd->format('H:i')
            ];
        }
            
        return response()->json($unavailableSlots);
    }

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
