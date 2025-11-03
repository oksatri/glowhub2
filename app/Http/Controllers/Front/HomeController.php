<?php

namespace App\Http\Controllers\Front;

use App\Models\Content;
use App\Models\Service;
use App\Models\HowItWork;
use App\Models\HeroSection;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Get hero section for home page
        $heroSection = HeroSection::first();

        // Get how it works steps
        $howItWorksSteps = HowItWork::orderBy('step_number')->get();

        // Get featured services
        $featuredServices = Service::where('is_active', true)->take(3)->get();

        // Get testimonials
        $testimonials = Testimonial::where('status', 'active')->take(3)->get();

        // Get featured content/articles
        $featuredContent = Content::where('status', 'published')->take(3)->get();

        return view('front.home');
    }
}
