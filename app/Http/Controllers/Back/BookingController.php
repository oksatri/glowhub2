<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // mark current admin's booking notifications as read (so bell count updates)
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
        }

        // Use a portable CASE ordering instead of MySQL FIELD() which doesn't exist in PostgreSQL
        $orderExpr = "CASE WHEN status = 'pending' THEN 1 WHEN status = 'confirmed' THEN 2 WHEN status = 'rejected' THEN 3 WHEN status = 'completed' THEN 4 ELSE 5 END";

        $query = Booking::with(['mua', 'service', 'customer']);

        // Filters: q (search across customer/mua/service), status, date
        if ($q = $request->get('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('customer_name', 'like', "%{$q}%")
                    ->orWhereHas('mua', function ($qq) use ($q) {
                        $qq->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('service', function ($qq) use ($q) {
                        $qq->where('service_name', 'like', "%{$q}%");
                    });
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($date = $request->get('date')) {
            $query->whereDate('selected_date', $date);
        }

        $query->orderByRaw($orderExpr);

        $bookings = $query->paginate(20)->withQueryString();

        // pass current filters to view for form prefill
        $q = $request->get('q');
        $status = $request->get('status');
        $date = $request->get('date');

        return view('back.bookings.index', compact('bookings', 'q', 'status', 'date'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        // require admin_note when rejecting
        $rules = [
            'status' => 'required|in:pending,confirmed,rejected,completed',
            'admin_note' => 'nullable|string'
        ];
        if ($request->input('status') === 'rejected') {
            $rules['admin_note'] = 'required|string';
        }

        $validated = $request->validate($rules);

        // Prevent changing a completed booking
        if ($booking->status === 'completed' && ($validated['status'] ?? null) !== 'completed') {
            return redirect()->back()->with('error', 'Completed bookings cannot be modified.');
        }

        $booking->update([
            'status' => $validated['status'],
            'admin_note' => $validated['admin_note'] ?? $booking->admin_note
        ]);

        return redirect()->back()->with('success', 'Booking updated');
    }
}
