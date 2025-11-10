<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\NewBookingNotification;
use App\Events\BookingCreated;
use Illuminate\Support\Facades\Notification;

class MuaController extends Controller
{
    /**
     * Display a listing of MUAs
     */
    public function index(Request $request)
    {
        // Use real Mua records from database. Map them to the front-end shape expected by views.
        $query = \App\Models\Mua::with('services');

        if ($q = $request->get('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")->orWhere('specialty', 'like', "%{$q}%");
            });
        }

        $perPage = 12;
        $muas = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        // Map to array shape used by existing front templates
        $items = $muas->map(function ($mua) {
            $firstService = $mua->services->first();
            return [
                'id' => $mua->id,
                'name' => $mua->name,
                'location' => trim(implode(' | ', array_filter([$mua->city, $mua->district]))),
                'rating' => (float) ($mua->rating ?? 4.5),
                'reviews_count' => $mua->reviews_count ?? 0,
                'price' => $firstService ? (int) $firstService->price : null,
                'image' => $mua->image ? asset('storage/' . $mua->image) : asset('images/product-item1.jpg'),
                'speciality' => $mua->specialty ?? '',
            ];
        });

        $pagination = [
            'current_page' => $muas->currentPage(),
            'per_page' => $muas->perPage(),
            'total' => $muas->total(),
            'last_page' => $muas->lastPage(),
            'has_more' => $muas->hasMorePages(),
        ];

        $filterOptions = [
            'events' => ['Wedding', 'Party', 'Corporate', 'Fashion', 'Editorial'],
            'cities' => [],
            'dates' => ['Hari ini', 'Minggu ini', 'Bulan ini', 'Pilih tanggal'],
            'times' => ['Pagi (06:00-12:00)', 'Siang (12:00-18:00)', 'Malam (18:00-24:00)']
        ];

        return view('front.mua-listing', compact('items', 'pagination', 'filterOptions'));
    }

    /**
     * Display MUA detail profile
     */
    public function show($id)
    {
        $mua = \App\Models\Mua::with(['services', 'portfolios'])->find($id);
        if (! $mua) {
            abort(404, 'MUA not found');
        }

        $firstService = $mua->services->first();

        $muaArr = [
            'id' => $mua->id,
            'name' => $mua->name,
            'location' => trim(implode(' | ', array_filter([$mua->city, $mua->district]))),
            'rating' => (float) ($mua->rating ?? 4.5),
            'reviews' => $mua->reviews_count ?? 0,
            'price' => $firstService ? (int) $firstService->price : null,
            'image' => $mua->image ? asset('storage/' . $mua->image) : asset('images/product-item1.jpg'),
            'speciality' => $mua->specialty ?? '',
        ];

        $portfolio = $mua->portfolios->map(function ($p) {
            return $p->image ? asset('storage/' . $p->image) : asset('images/product-item1.jpg');
        })->toArray();

        $services = $mua->services->map(function ($s) {
            return [
                'id' => $s->id,
                'name' => $s->service_name ?? $s->name ?? 'Service',
                'price' => $s->price,
                'description' => $s->description,
            ];
        })->toArray();

        return view('front.mua-detail', ['mua' => $muaArr, 'portfolio' => $portfolio, 'services' => $services]);
    }

    /**
     * Handle booking request
     */
    public function book(Request $request, $id)
    {
        // Validate booking data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'whatsapp' => 'required|string',
            'address' => 'required|string',
            'distance' => 'nullable|numeric',
            'selected_date' => 'required|date',
            'selected_time' => 'required|string',
            'services' => 'nullable|array',
            'mua_service_id' => 'nullable|integer'
        ]);

        // Persist booking
        $booking = Booking::create([
            'mua_id' => $id,
            'mua_service_id' => $request->input('mua_service_id'),
            'customer_id' => auth()->check() ? auth()->id() : null,
            'customer_name' => $request->input('name'),
            'customer_email' => $request->input('email'),
            'customer_whatsapp' => $request->input('whatsapp'),
            'customer_address' => $request->input('address'),
            'distance_km' => $request->input('distance'),
            'selected_date' => $request->input('selected_date'),
            'selected_time' => $request->input('selected_time'),
            'services' => $request->input('services') ?: null,
            'status' => 'pending'
        ]);

        // Notify admins via Notification system and broadcast event
        try {
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new NewBookingNotification($booking));
            event(new BookingCreated($booking));
        } catch (\Exception $e) {
            // don't fail booking if notification fails; log later
            logger()->error('Failed to notify admins about booking: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Booking request submitted successfully! MUA will contact you soon.',
            'booking_id' => 'BK' . $booking->id
        ]);
    }
}
