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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewBookingNotification;
use App\Mail\BookingAdminNotification;
use App\Mail\BookingMuaNotification;
use App\Mail\BookingClientNotification;
use Illuminate\Support\Facades\Mail;

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
                'name' => $service->service_name, // Always show service name instead of MUA name
                'mua_name' => $mua->name ?? null, // Add separate field for MUA name if needed
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
        }, 'rel_city'])->findOrFail($id);

        // determine active service: by requested service_id or fallback to cheapest
        $serviceId = $request->get('service_id');
        $activeService = null;
        if ($serviceId) {
            $activeService = $mua->services->firstWhere('id', $serviceId);
        }
        if (! $activeService) {
            $activeService = $mua->services->sortBy('price')->first();
        }

        $muaData = [
            'id' => $mua->id,
            'name' => $activeService ? $activeService->service_name : $mua->name, // Show service name if available, otherwise MUA name
            'mua_name' => $mua->name, // Add separate MUA name field
            'service_name' => $activeService ? $activeService->service_name : null, // Add service name field
            'description' => $activeService ? $activeService->description : null,
            'location' => trim($mua && $mua->rel_city ? $mua->rel_city->name : ($mua->city ?? '')),
            'rating' => (float) ($mua->rating ?? 4.5),
            'price' => $activeService ? (int) $activeService->price : null,
            'image' => $mua->portfolios->first()->image ? asset('uploads/' . $mua->portfolios->first()->image) : asset('images/product-item1.jpg'),
            'max_distance' => $mua->max_distance,
            'operational_hours' => $mua->operational_hours,
            'additional_charge' => $mua->additional_charge,
            'link_map' => $mua->link_map,
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
        if ($activeService && !empty($activeService->features)) {
            $rawFeatures = $activeService->features;

            // if stored as JSON string and not yet cast, decode first
            if (is_string($rawFeatures)) {
                $decoded = json_decode($rawFeatures, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $rawFeatures = $decoded;
                } else {
                    $rawFeatures = [$rawFeatures];
                }
            }

            if (is_array($rawFeatures)) {
                foreach ($rawFeatures as $feature) {
                    // structured feature with min_price and max_price
                    if (is_array($feature) && isset($feature['name'])) {
                        $features[] = [
                            'name' => (string) $feature['name'],
                            'min_price' => isset($feature['min_price']) ? (int) $feature['min_price'] : null,
                            'max_price' => isset($feature['max_price']) ? (int) $feature['max_price'] : null,
                            'extra_price' => isset($feature['extra_price']) ? (int) $feature['extra_price'] : 0, // fallback for backward compatibility
                        ];
                        continue;
                    }

                    // plain string feature - try to parse price patterns
                    $featureText = is_string($feature) ? $feature : (string) ($feature['label'] ?? '');
                    if ($featureText === '') {
                        continue;
                    }

                    $name = $featureText;
                    $minPrice = null;
                    $maxPrice = null;
                    $extraPrice = 0;

                    // parse range patterns like "Rp. 100.000 - 200.000"
                    if (preg_match('/Rp\.?\s*([0-9\.]+)\s*[-–]\s*([0-9\.]+)/i', $featureText, $m)) {
                        $minPrice = (int) preg_replace('/[^0-9]/', '', $m[1] ?? '0');
                        $maxPrice = (int) preg_replace('/[^0-9]/', '', $m[2] ?? '0');
                        $name = trim(preg_replace('/Rp\.?\s*[0-9\.]+\s*[-–]\s*[0-9\.]+/i', '', $featureText));
                    }
                    // parse single price patterns like "+ Rp. 35.000" or "Rp. 35.000"
                    elseif (preg_match('/\+?\s*Rp\.?\s*([0-9\.]+)/i', $featureText, $m)) {
                        $extraPrice = (int) preg_replace('/[^0-9]/', '', $m[1] ?? '0');
                        $name = trim(preg_replace('/\+?\s*Rp\.?\s*[0-9\.]+/i', '', $featureText));
                    }

                    $features[] = [
                        'name' => $name,
                        'min_price' => $minPrice,
                        'max_price' => $maxPrice,
                        'extra_price' => $extraPrice, // fallback
                    ];
                }
            }
        }

        // Get existing bookings for this MUA to block dates and time slots
        $existingBookings = Booking::where('mua_id', $id)
            ->where('status', '!=', 'rejected')
            ->get(['selected_date', 'selected_time']);

        return view('front.mua-detail', [
            'mua' => $muaData,
            'portfolio' => $portfolio,
            'features' => $features,
            'activeService' => $activeService,
            'existingBookings' => $existingBookings,
        ]);
    }

    /**
     * Handle booking request
     */
    public function book(Request $request, $id)
    {
        try {
            // Validate booking data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'whatsapp' => 'required|string',
                'address' => 'required|string',
                'distance' => 'nullable|numeric',
                'selected_date' => 'required|date_format:Y-m-d',
                'selected_time' => 'required|string',
                'services' => 'nullable|array',
                'mua_service_id' => 'nullable|integer'
            ]);

            // Debug: Log received data
            Log::info('Booking request data:', [
                'selected_date' => $request->input('selected_date'),
                'selected_time' => $request->input('selected_time'),
                'services' => $request->input('services'),
                'mua_service_id' => $request->input('mua_service_id')
            ]);

            // Persist booking
            $service = \App\Models\MuaService::find($request->input('mua_service_id'));
            $basePrice = $service ? $service->price : 0;

            $booking = Booking::create([
                'mua_id' => $id,
                'mua_service_id' => $request->input('mua_service_id'),
                'customer_id' => Auth::check() ? Auth::id() : null,
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

            // Send email notifications to admin, MUA, and client
            Log::info('Starting email sending process for booking: ' . $booking->id);

            // Send to admin
            $admins = User::where('role', 'admin')->get();
            Log::info('Found admins: ' . $admins->count());

            foreach ($admins as $admin) {
                try {
                    Log::info('Attempting to send admin email to: ' . $admin->email);
                    Mail::to($admin->email)->send(new BookingAdminNotification($booking));
                    Log::info('Admin email sent successfully to: ' . $admin->email);
                } catch (\Exception $e) {
                    Log::error('Failed to send admin email: ' . $e->getMessage());
                    Log::error('Admin email details: ' . json_encode([
                        'admin_email' => $admin->email,
                        'booking_id' => $booking->id
                    ]));
                }
            }

            // Send to MUA
            if ($booking->mua && $booking->mua->user && $booking->mua->user->email) {
                try {
                    Log::info('Attempting to send MUA email to: ' . $booking->mua->user->email);
                    Mail::to($booking->mua->user->email)->send(new BookingMuaNotification($booking));
                    Log::info('MUA email sent successfully to: ' . $booking->mua->user->email);
                } catch (\Exception $e) {
                    Log::error('Failed to send MUA email: ' . $e->getMessage());
                    Log::error('MUA email details: ' . json_encode([
                        'mua_email' => $booking->mua->user->email,
                        'booking_id' => $booking->id
                    ]));
                }
            } else {
                Log::warning('No MUA email found for booking: ' . $booking->id);
            }

            // Send to client
            try {
                Log::info('Attempting to send client email to: ' . $booking->customer_email);
                Mail::to($booking->customer_email)->send(new BookingClientNotification($booking));
                Log::info('Client email sent successfully to: ' . $booking->customer_email);
            } catch (\Exception $e) {
                Log::error('Failed to send client email: ' . $e->getMessage());
                Log::error('Client email details: ' . json_encode([
                    'client_email' => $booking->customer_email,
                    'booking_id' => $booking->id
                ]));
            }

            // Also notify admins via Notification system and broadcast event
            try {
                Notification::send($admins, new NewBookingNotification($booking));
                event(new BookingCreated($booking));
                Log::info('Notifications and events sent successfully');
            } catch (\Exception $e) {
                Log::error('Failed to notify admins: ' . $e->getMessage());
            }

            Log::info('Email sending process completed for booking: ' . $booking->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Booking request submitted successfully! MUA will contact you soon.',
                'booking_id' => 'BK' . $booking->id
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            logger()->error('Booking creation failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Booking failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
