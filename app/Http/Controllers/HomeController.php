<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeroSection;
use App\Models\HowItWork;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Content;

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

        return view('home', compact(
            'heroSection',
            'howItWorksSteps',
            'featuredServices',
            'testimonials',
            'featuredContent'
        ));
    }
}
