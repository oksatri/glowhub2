<?php

namespace App\Http\Controllers\Mua;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Mua;
use App\Models\BookingPayment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingConfirmedNotification;
use App\Mail\BookingRejectedNotification;
use App\Mail\BookingPriceRevisedNotification;
use App\Mail\BookingInvoiceNotification;
use Illuminate\Support\Facades\Mail;

class BookingConfirmationController extends Controller
{
    public function __construct()
    {
        // Remove middleware from constructor to avoid issues
        // We'll handle auth checking manually in methods
    }

    /**
     * Display the booking confirmation page
     */
    public function show($id)
    {
        // Manual auth checking
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Manual role checking
        if ($user->role !== 'mua') {
            Log::error('BookingConfirmationController@show - User is not MUA:', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'required_role' => 'mua'
            ]);
            abort(403, 'Unauthorized action. Only MUA users can access this page.');
        }

        // Debug: Log user information
        Log::info('BookingConfirmationController@show - User Info:', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'booking_id' => $id
        ]);

        // Get MUA associated with this user
        $mua = Mua::where('user_id', $user->id)->first();

        Log::info('BookingConfirmationController@show - MUA Info:', [
            'mua_found' => $mua ? true : false,
            'mua_id' => $mua ? $mua->id : null,
            'mua_name' => $mua ? $mua->name : null
        ]);

        if (!$mua) {
            Log::error('MUA profile not found for user:', ['user_id' => $user->id, 'user_role' => $user->role]);
            abort(403, 'MUA profile not found');
        }

        // Get booking that belongs to this MUA
        $booking = Booking::with(['customer', 'service', 'mua'])
            ->where('id', $id)
            ->where('mua_id', $mua->id)
            ->first();

        Log::info('BookingConfirmationController@show - Booking Info:', [
            'booking_found' => $booking ? true : false,
            'booking_mua_id' => $booking ? $booking->mua_id : null,
            'expected_mua_id' => $mua->id,
            'booking_status' => $booking ? $booking->status : null
        ]);

        if (!$booking) {
            Log::error('Booking not found or does not belong to this MUA:', [
                'booking_id' => $id,
                'mua_id' => $mua->id
            ]);
            abort(403, 'Booking not found or access denied');
        }

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
        // Manual auth checking
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Manual role checking
        if ($user->role !== 'mua') {
            abort(403, 'Unauthorized action. Only MUA users can access this page.');
        }

        $mua = Mua::where('user_id', $user->id)->firstOrFail();

        $booking = Booking::where('id', $id)
            ->where('mua_id', $mua->id)
            ->firstOrFail();

        $booking->update([
            'status' => 'confirmed',
            'mua_note' => $request->input('mua_note') ?? null
        ]);

        // Create booking payment record
        $finalPrice = $booking->revised_price ?? $booking->service_price ?? 0;
        $bookingPayment = BookingPayment::create([
            'booking_id' => $booking->id,
            'amount' => $finalPrice,
            'status' => 'pending',
            'payment_reference' => 'INV-' . str_pad($booking->id, 8, '0', STR_PAD_LEFT) . '-' . date('Ymd')
        ]);

        // Get active payment methods
        $paymentMethods = PaymentMethod::active()->ordered()->get();

        // Send confirmation email to client
        try {
            Mail::to($booking->customer_email)->send(new BookingConfirmedNotification($booking));
        } catch (\Exception $e) {
            logger()->error('Failed to send confirmation email: ' . $e->getMessage());
        }

        // Send invoice email to client
        try {
            Mail::to($booking->customer_email)->send(new BookingInvoiceNotification($booking, $bookingPayment, $paymentMethods));
        } catch (\Exception $e) {
            logger()->error('Failed to send invoice email: ' . $e->getMessage());
        }

        return redirect()->route('mua.bookings.index')
            ->with('success', 'Booking confirmed successfully! Invoice has been sent to the client.');
    }

    /**
     * Reject booking
     */
    public function reject(Request $request, $id)
    {
        // Manual auth checking
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Manual role checking
        if ($user->role !== 'mua') {
            abort(403, 'Unauthorized action. Only MUA users can access this page.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

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
        // Manual auth checking
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Manual role checking
        if ($user->role !== 'mua') {
            abort(403, 'Unauthorized action. Only MUA users can access this page.');
        }

        $request->validate([
            'revised_price' => 'required|numeric|min:0',
            'price_note' => 'required|string|max:500'
        ]);

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
