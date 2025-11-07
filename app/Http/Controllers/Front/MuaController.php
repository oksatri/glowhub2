<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MuaController extends Controller
{
    /**
     * Display a listing of MUAs
     */
    public function index(Request $request)
    {
        // Sample MUA data - in real application this would come from database
        $muas = collect([
            [
                'id' => 1,
                'name' => 'Sarah Martinez',
                'location' => 'Malang | Lowokwaru',
                'rating' => 4.8,
                'reviews_count' => 19,
                'price' => 270000,
                'image' => asset('images/product-item1.jpg'),
                'speciality' => 'Bridal'
            ],
            [
                'id' => 2,
                'name' => 'Maria Johnson',
                'location' => 'Malang | Klojen',
                'rating' => 5.0,
                'reviews_count' => 0,
                'price' => 250000,
                'image' => asset('images/product-item2.jpg'),
                'speciality' => 'Event'
            ],
            [
                'id' => 3,
                'name' => 'Emma Chen',
                'location' => 'Malang | Lowokwaru',
                'rating' => 4.3,
                'reviews_count' => 12,
                'price' => 290000,
                'image' => asset('images/product-item3.jpg'),
                'speciality' => 'Fashion'
            ],
            [
                'id' => 4,
                'name' => 'Jessica Liu',
                'location' => 'Malang | Lowokwaru',
                'rating' => 4.8,
                'reviews_count' => 4,
                'price' => 350000,
                'image' => asset('images/product-item4.jpg'),
                'speciality' => 'Editorial'
            ],
            [
                'id' => 5,
                'name' => 'Rachel Adams',
                'location' => 'Surabaya | Gubeng',
                'rating' => 4.9,
                'reviews_count' => 25,
                'price' => 320000,
                'image' => asset('images/product-item5.jpg'),
                'speciality' => 'Wedding'
            ],
            [
                'id' => 6,
                'name' => 'Linda Wong',
                'location' => 'Jakarta | Kemang',
                'rating' => 4.2,
                'reviews_count' => 8,
                'price' => 380000,
                'image' => asset('images/product-item6.jpg'),
                'speciality' => 'Party'
            ],
            [
                'id' => 7,
                'name' => 'Diana Sari',
                'location' => 'Bandung | Dago',
                'rating' => 5.0,
                'reviews_count' => 15,
                'price' => 450000,
                'image' => asset('images/product-item7.jpg'),
                'speciality' => 'Bridal'
            ],
            [
                'id' => 8,
                'name' => 'Sari Dewi',
                'location' => 'Yogya | Sleman',
                'rating' => 4.7,
                'reviews_count' => 11,
                'price' => 280000,
                'image' => asset('images/product-item8.jpg'),
                'speciality' => 'Event'
            ],
            // Add more MUAs for pagination demo
            [
                'id' => 9,
                'name' => 'Anya Putri',
                'location' => 'Jakarta | Senayan',
                'rating' => 4.6,
                'reviews_count' => 22,
                'price' => 420000,
                'image' => asset('images/product-item1.jpg'),
                'speciality' => 'Fashion'
            ],
            [
                'id' => 10,
                'name' => 'Maya Sinta',
                'location' => 'Surabaya | Tunjungan',
                'rating' => 4.9,
                'reviews_count' => 18,
                'price' => 390000,
                'image' => asset('images/product-item2.jpg'),
                'speciality' => 'Editorial'
            ]
        ]);

        // Pagination logic
        $perPage = 8; // Show 8 MUAs per page
        $currentPage = $request->get('page', 1);
        $total = $muas->count();
        $items = $muas->forPage($currentPage, $perPage);

        // Create pagination info
        $pagination = [
            'current_page' => $currentPage,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => ceil($total / $perPage),
            'has_more' => ($currentPage * $perPage) < $total
        ];

        // Filter options
        $filterOptions = [
            'events' => ['Wedding', 'Party', 'Corporate', 'Fashion', 'Editorial'],
            'cities' => ['Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Yogyakarta', 'Malang'],
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
        // Sample MUA data - in real application this would come from database
        $muas = collect([
            [
                'id' => 1,
                'name' => 'Alia',
                'location' => 'Malang | Lowokwaru',
                'rating' => 4.8,
                'reviews_count' => 19,
                'price' => 270000,
                'image' => asset('images/product-item1.jpg'),
                'speciality' => 'soft glam & bridesmaid look'
            ],
            [
                'id' => 2,
                'name' => 'Maria Johnson',
                'location' => 'Malang | Klojen',
                'rating' => 5.0,
                'reviews_count' => 15,
                'price' => 250000,
                'image' => asset('images/product-item2.jpg'),
                'speciality' => 'Event makeup'
            ],
            [
                'id' => 3,
                'name' => 'Emma Chen',
                'location' => 'Malang | Lowokwaru',
                'rating' => 4.3,
                'reviews_count' => 12,
                'price' => 290000,
                'image' => asset('images/product-item3.jpg'),
                'speciality' => 'Fashion makeup'
            ],
            [
                'id' => 4,
                'name' => 'Jessica Liu',
                'location' => 'Malang | Sukun',
                'rating' => 4.7,
                'reviews_count' => 28,
                'price' => 320000,
                'image' => asset('images/product-item4.jpg'),
                'speciality' => 'Bridal & party makeup'
            ]
        ]);

        $mua = $muas->where('id', $id)->first();

        if (!$mua) {
            abort(404, 'MUA not found');
        }

        // Add reviews key for compatibility
        $mua['reviews'] = $mua['reviews_count'];

        // Sample portfolio images
        $portfolio = [
            asset('images/product-item1.jpg'),
            asset('images/product-item2.jpg'),
            asset('images/product-item3.jpg'),
            asset('images/product-item4.jpg'),
            asset('images/product-item5.jpg'),
            asset('images/product-item6.jpg')
        ];

        return view('front.mua-detail', compact('mua', 'portfolio'));
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
            'services' => 'array'
        ]);

        // In real application, save booking to database
        // For now, just return success response

        return response()->json([
            'status' => 'success',
            'message' => 'Booking request submitted successfully! MUA will contact you soon.',
            'booking_id' => 'BK' . time()
        ]);
    }
}
