<?php

namespace App\Http\Controllers\Mua;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Mua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\BookingConfirmedNotification;
use App\Mail\BookingRejectedNotification;
use App\Mail\BookingPriceRevisedNotification;
use Illuminate\Support\Facades\Mail;

class BookingConfirmationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:mua');
    }

    /**
     * Display the booking confirmation page
     */
    public function show($id)
    {
        $user = Auth::user();

        // Get MUA associated with this user
        $mua = Mua::where('user_id', $user->id)->first();

        if (!$mua) {
            abort(403, 'MUA profile not found');
        }

        // Get booking that belongs to this MUA
        $booking = Booking::with(['customer', 'service', 'mua'])
            ->where('id', $id)
            ->where('mua_id', $mua->id)
            ->firstOrFail();

        // Calculate estimated total price
        $basePrice = $booking->service->price ?? 0;
        $additionalServices = $booking->services ?? [];
        $additionalPrice = 0;

        // Parse additional services pricing if available
        if (!empty($additionalServices)) {
            $features = $booking->service->features ?? [];
            if (is_string($features)) {
                $features = json_decode($features, true) ?? [];
            }

            foreach ($additionalServices as $serviceName) {
                foreach ($features as $feature) {
                    if (is_array($feature) && isset($feature['name'])) {
                        if (strtolower($feature['name']) === strtolower($serviceName)) {
                            $additionalPrice += $feature['extra_price'] ?? 0;
                            $additionalPrice += $feature['min_price'] ?? 0;
                        }
                    }
                }
            }
        }

        $estimatedPrice = $basePrice + $additionalPrice;

        return view('mua.bookings.confirm', compact('booking', 'estimatedPrice'));
    }

    /**
     * Confirm booking
     */
    public function confirm(Request $request, $id)
    {
        $user = Auth::user();
        $mua = Mua::where('user_id', $user->id)->firstOrFail();

        $booking = Booking::where('id', $id)
            ->where('mua_id', $mua->id)
            ->firstOrFail();

        $booking->update([
            'status' => 'confirmed',
            'mua_note' => $request->input('mua_note') ?? null
        ]);

        // Send confirmation email to client
        try {
            Mail::to($booking->customer_email)->send(new BookingConfirmedNotification($booking));
        } catch (\Exception $e) {
            logger()->error('Failed to send confirmation email: ' . $e->getMessage());
        }

        return redirect()->route('mua.bookings.index')
            ->with('success', 'Booking confirmed successfully!');
    }

    /**
     * Reject booking
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $user = Auth::user();
        $mua = Mua::where('user_id', $user->id)->firstOrFail();

        $booking = Booking::where('id', $id)
            ->where('mua_id', $mua->id)
            ->firstOrFail();

        $booking->update([
            'status' => 'rejected',
            'mua_note' => $request->input('rejection_reason')
        ]);

        // Send rejection email to client
        try {
            Mail::to($booking->customer_email)->send(new BookingRejectedNotification($booking));
        } catch (\Exception $e) {
            logger()->error('Failed to send rejection email: ' . $e->getMessage());
        }

        return redirect()->route('mua.bookings.index')
            ->with('success', 'Booking rejected successfully!');
    }

    /**
     * Revise booking price
     */
    public function revisePrice(Request $request, $id)
    {
        $request->validate([
            'revised_price' => 'required|numeric|min:0',
            'price_note' => 'required|string|max:500'
        ]);

        $user = Auth::user();
        $mua = Mua::where('user_id', $user->id)->firstOrFail();

        $booking = Booking::where('id', $id)
            ->where('mua_id', $mua->id)
            ->firstOrFail();

        $booking->update([
            'status' => 'price_revised',
            'revised_price' => $request->input('revised_price'),
            'price_note' => $request->input('price_note')
        ]);

        // Send price revision email to client
        try {
            Mail::to($booking->customer_email)->send(new BookingPriceRevisedNotification($booking));
        } catch (\Exception $e) {
            logger()->error('Failed to send price revision email: ' . $e->getMessage());
        }

        return redirect()->route('mua.bookings.index')
            ->with('success', 'Price revision sent to client!');
    }
}
