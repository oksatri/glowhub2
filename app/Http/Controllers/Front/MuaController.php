<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Booking;
use App\Models\RegRegency;
use App\Models\RegDistrict;
use App\Models\RegProvince;
use Illuminate\Http\Request;
use App\Events\BookingCreated;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewBookingNotification;

class MuaController extends Controller
{
    /**
     * Display a listing of MUAs
     */
    public function index(Request $request)
    {
    // Use real Mua records from database. Map them to the front-end shape expected by views.
    // Only load rel_city now; province/district are removed from filters.
    $query = \App\Models\Mua::with('services', 'rel_city');

        if ($q = @$request->event_type) {
            $query->where(function ($sub) use ($q) {
                $sub->orWhere('name', 'like', "%{$q}%");
                $sub->orWhere('specialty', 'like', "%{$q}%");
            });
        }
        // Filter only by city (regency)
        if (@$request->regency_id) {
            $query->where('city', $request->regency_id);
        }

        $perPage = 12;
        $muas = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        // Map to array shape used by existing front templates
        $items = $muas->map(function ($mua) {
            $firstService = $mua->services->first();
            return [
                'id' => $mua->id,
                'name' => $mua->name,
                'location' => trim($mua->rel_city->name ?? ''),
                'rating' => (float) ($mua->rating ?? 0),
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
            'events' => ['Wedding', '⁠⁠Engagement/Lamaran', 'Wedding Guest', 'Party', 'Graduation','Graduation Companion'],
            // only provide cities filtered to Jabodetabek-area provinces and Jawa Timur
            'cities' => RegRegency::whereIn('province_id', RegProvince::whereIn('name', ['DKI Jakarta', 'Banten', 'Jawa Barat', 'Jawa Timur'])->pluck('id'))->orderBy('name')->get()->map(function ($r) {
                return ['id' => $r->id, 'name' => $r->name];
            })->values()->toArray(),
            'times' => ['Pagi (02:00-11:00)', 'Siang (11:00-19:00)', 'Malam (19:00-22:00)']
        ];

        return view('front.mua-listing', compact('items', 'pagination', 'filterOptions', 'request'));
    }

    /**
     * Display MUA detail profile
     */
    public function show($id)
    {
        $mua = \App\Models\Mua::with(['services', 'portfolios' => function ($q) {
            $q->with('service');
        }, 'rel_city'])->find($id);
        if (! $mua) {
            abort(404, 'MUA not found');
        }

        $firstService = $mua->services->sortBy('price')->first();

        $muaArr = [
            'id' => $mua->id,
            'name' => $mua->name,
            'description' => $mua->description,
            'location' => trim($mua->rel_city->name ?? ''),
            'rating' => (float) ($mua->rating ?? 4.5),
            'price' => $firstService ? (int) $firstService->price : null,
            'image' => $mua->image ? asset('storage/' . $mua->image) : asset('images/product-item1.jpg'),
            'speciality' => $mua->specialty ?? '',
            'experience' => $mua->experience ?? '',
        ];

        $portfolio = $mua->portfolios->map(function ($p) {
            return [
                'image' => $p->image ? asset('storage/' . $p->image) : asset('images/product-item1.jpg'),
                'service_name' => $p->service->service_name ?? null,
            ];
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
