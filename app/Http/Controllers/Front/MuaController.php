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
     * Display a listing of MUAs (service-based cards)
     */
    public function index(Request $request)
    {
        // Base listing on MuaService so each card represents a concrete service,
        // similar to the home page featured services.
        $query = \App\Models\MuaService::with(['mua.rel_city', 'portfolios']);

        // Filter by event type -> match categori_service on services
        if ($q = @$request->event_type) {
            $query->where('categori_service', 'like', "%{$q}%");
        }

        // Filter by city (regency) via related MUA
        if (@$request->regency_id) {
            $regencyId = $request->regency_id;
            $query->whereHas('mua', function ($sub) use ($regencyId) {
                $sub->where('city', $regencyId);
            });
        }

        $perPage = 12;
        $services = $query->orderBy('price')->paginate($perPage)->withQueryString();

        // Map to array shape used by existing front templates
        $items = $services->map(function ($service) {
            $mua = $service->mua;

            // choose one portfolio image for this service (fallback to MUA image or default)
            $portfolioImage = null;
            if ($service->portfolios && $service->portfolios->count() > 0) {
                $portfolioImage = $service->portfolios->first()->image;
            } elseif ($mua && $mua->portfolios && $mua->portfolios->count() > 0) {
                $portfolioImage = $mua->portfolios->first()->image;
            }

            $imageUrl = $portfolioImage
                ? asset('uploads/' . $portfolioImage)
                : ($mua && $mua->image
                    ? asset('uploads/' . $mua->image)
                    : asset('images/product-item1.jpg'));

            return [
                // keep id as MUA id for detail route
                'id' => $mua ? $mua->id : null,
                'service_id' => $service->id,
                'name' => $mua->name ?? $service->service_name,
                'location' => $mua ? trim(optional($mua->rel_city)->name ?: ($mua->city ?? '')) : '',
                'rating' => $mua ? (float) ($mua->rating ?? 0) : 0,
                'reviews_count' => $mua->reviews_count ?? 0,
                'price' => (int) ($service->price ?? 0),
                'category' => $service->categori_service ?? null,
                'image' => $imageUrl,
                'max_distance' => $mua->max_distance ?? null,
                'operational_hours' => $mua->operational_hours ?? null,
                'additional_charge' => $mua->additional_charge ?? null,
            ];
        });

        $pagination = [
            'current_page' => $services->currentPage(),
            'per_page' => $services->perPage(),
            'total' => $services->total(),
            'last_page' => $services->lastPage(),
            'has_more' => $services->hasMorePages(),
        ];

        $filterOptions = [
            'events' => [
                'Akad',
                'Wedding (Resepsi)',
                'Prewedding',
                '⁠⁠Engagement/Lamaran',
                'Wedding Guest',
                'Party',
                'Bridesmaid',
                'Graduation',
                'Graduation Companion',
                'Maternity Shoot',
                'Photoshoot',
                'Family Makeup',
                'Event',
            ],
            // only provide cities filtered to Jabodetabek-area provinces and Jawa Timur
            // Note: province names in the Wilayah SQL are uppercase (e.g. 'DKI JAKARTA'),
            // so match those names and group regencies by their province_id for the frontend.
            'cities' => RegRegency::whereIn('province_id', RegProvince::whereIn('name', ['DKI JAKARTA', 'BANTEN', 'JAWA BARAT', 'JAWA TIMUR'])->pluck('id'))
                ->orderBy('name')
                ->get()
                ->groupBy('province_id')
                ->map(function ($group) {
                    return $group->map(function ($r) {
                        return ['id' => $r->id, 'name' => $r->name];
                    })->values()->toArray();
                })->toArray(),
            'times' => ['Pagi (02:00-11:00)', 'Siang (11:00-19:00)', 'Malam (19:00-22:00)']
        ];

        return view('front.mua-listing', compact('items', 'pagination', 'filterOptions', 'request'));
    }

    /**
     * Display MUA detail profile for a specific service (if provided).
     */
    public function show(Request $request, $id)
    {
        $mua = \App\Models\Mua::with(['services', 'portfolios' => function ($q) {
            $q->with('service');
        }, 'rel_city'])->find($id);
        if (! $mua) {
            abort(404, 'MUA not found');
        }

        // determine active service: by requested service_id or fallback to cheapest
        $serviceId = $request->get('service_id');
        $activeService = null;
        if ($serviceId) {
            $activeService = $mua->services->firstWhere('id', $serviceId);
        }
        if (! $activeService) {
            $activeService = $mua->services->sortBy('price')->first();
        }

        $muaArr = [
            'id' => $mua->id,
            'name' => $mua->name,
            'description' => $mua->description,
            'location' => trim($mua->rel_city->name ?? ''),
            'rating' => (float) ($mua->rating ?? 4.5),
            'price' => $activeService ? (int) $activeService->price : null,
            'image' => $mua->image ? asset('uploads/' . $mua->image) : asset('images/product-item1.jpg'),
            'max_distance' => $mua->max_distance,
            'operational_hours' => $mua->operational_hours,
            'additional_charge' => $mua->additional_charge,
        ];

        // portfolios limited to the active service (if any)
        $portfolioQuery = $mua->portfolios;
        if ($activeService) {
            $portfolioQuery = $portfolioQuery->where('mua_service_id', $activeService->id);
        }

        $portfolio = $portfolioQuery->map(function ($p) {
            return [
                'image' => $p->image ? asset('uploads/' . $p->image) : asset('images/product-item1.jpg'),
                'service_name' => $p->service->service_name ?? null,
            ];
        })->toArray();

        // features inside the active service become selectable options on the form
        $features = [];
        if ($activeService && is_array($activeService->features)) {
            foreach ($activeService->features as $feature) {
                $name = $feature;
                $extra = 0;

                // parse patterns like "+ Rp. 35.000" from the feature text
                if (preg_match('/\+\s*Rp\.?\s*([0-9\.]+)/i', $feature, $m)) {
                    $num = preg_replace('/[^0-9]/', '', $m[1] ?? '0');
                    $extra = (int) $num;
                    // remove the pricing part from the display name
                    $name = trim(preg_replace('/\(.*Rp.*\)/i', '', $feature));
                }

                $features[] = [
                    'name' => $name,
                    'extra_price' => $extra,
                ];
            }
        }

        return view('front.mua-detail', [
            'mua' => $muaArr,
            'portfolio' => $portfolio,
            'features' => $features,
            'activeService' => $activeService,
        ]);
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
