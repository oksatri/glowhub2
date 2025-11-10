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

        $query = Booking::with(['mua', 'service', 'customer'])->orderByRaw("FIELD(status, 'pending','confirmed','rejected','completed')");
        $bookings = $query->paginate(20);

        return view('back.bookings.index', compact('bookings'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,rejected,completed',
            'admin_note' => 'nullable|string'
        ]);

        $booking->update([
            'status' => $validated['status'],
            'admin_note' => $validated['admin_note'] ?? $booking->admin_note
        ]);

        return redirect()->back()->with('success', 'Booking updated');
    }
}
