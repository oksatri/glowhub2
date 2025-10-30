<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Service;
use App\Models\HeroSection;
use App\Models\HowItWork;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk dashboard
        $stats = [
            'contents' => Content::count(),
            'published_contents' => Content::published()->count(),
            'categories' => Category::count(),
            'testimonials' => Testimonial::count(),
            'services' => Service::count(),
            'hero_sections' => HeroSection::count(),
            'how_it_works' => HowItWork::count(),
        ];

        // Recent contents
        $recentContents = Content::with('category')
            ->latest()
            ->take(5)
            ->get();

        // Recent testimonials
        $recentTestimonials = Testimonial::latest()
            ->take(5)
            ->get();

        return view('templates.back.admin.dashboard.index', compact('stats', 'recentContents', 'recentTestimonials'));
    }
}
