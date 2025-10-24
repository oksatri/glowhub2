<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                'image' => 'images/mua1.jpg',
                'speciality' => 'Bridal'
            ],
            [
                'id' => 2,
                'name' => 'Maria Johnson',
                'location' => 'Malang | Klojen',
                'rating' => 5.0,
                'reviews_count' => 0,
                'price' => 250000,
                'image' => 'images/mua2.jpg',
                'speciality' => 'Event'
            ],
            [
                'id' => 3,
                'name' => 'Emma Chen',
                'location' => 'Malang | Lowokwaru',
                'rating' => 4.3,
                'reviews_count' => 12,
                'price' => 290000,
                'image' => 'images/mua3.jpg',
                'speciality' => 'Fashion'
            ],
            [
                'id' => 4,
                'name' => 'Jessica Liu',
                'location' => 'Malang | Lowokwaru',
                'rating' => 4.8,
                'reviews_count' => 4,
                'price' => 350000,
                'image' => 'images/mua4.jpg',
                'speciality' => 'Editorial'
            ],
            [
                'id' => 5,
                'name' => 'Rachel Adams',
                'location' => 'Surabaya | Gubeng',
                'rating' => 4.9,
                'reviews_count' => 25,
                'price' => 320000,
                'image' => 'images/mua1.jpg',
                'speciality' => 'Wedding'
            ],
            [
                'id' => 6,
                'name' => 'Linda Wong',
                'location' => 'Jakarta | Kemang',
                'rating' => 4.2,
                'reviews_count' => 8,
                'price' => 380000,
                'image' => 'images/mua2.jpg',
                'speciality' => 'Party'
            ],
            [
                'id' => 7,
                'name' => 'Diana Sari',
                'location' => 'Bandung | Dago',
                'rating' => 5.0,
                'reviews_count' => 15,
                'price' => 450000,
                'image' => 'images/mua3.jpg',
                'speciality' => 'Bridal'
            ],
            [
                'id' => 8,
                'name' => 'Sari Dewi',
                'location' => 'Yogya | Sleman',
                'rating' => 4.7,
                'reviews_count' => 11,
                'price' => 280000,
                'image' => 'images/mua4.jpg',
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
                'image' => 'images/mua1.jpg',
                'speciality' => 'Fashion'
            ],
            [
                'id' => 10,
                'name' => 'Maya Sinta',
                'location' => 'Surabaya | Tunjungan',
                'rating' => 4.9,
                'reviews_count' => 18,
                'price' => 390000,
                'image' => 'images/mua2.jpg',
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

        return view('mua-listing', compact('items', 'pagination', 'filterOptions'));
    }
}
