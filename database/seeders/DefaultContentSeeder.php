<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Content;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\HeroSection;
use App\Models\HowItWork;

class DefaultContentSeeder extends Seeder
{
    public function run()
    {
        // Create Categories
        $categories = [
            ['name' => 'Wedding Makeup', 'slug' => 'wedding-makeup', 'description' => 'Professional wedding makeup services'],
            ['name' => 'Party Makeup', 'slug' => 'party-makeup', 'description' => 'Glamorous party makeup'],
            ['name' => 'Natural Makeup', 'slug' => 'natural-makeup', 'description' => 'Everyday natural look'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Content
        Content::create([
            'title' => 'Welcome to GlowHub',
            'slug' => 'welcome-to-glowhub',
            'content' => '<p>Your premier destination for professional makeup artists.</p>',
            'excerpt' => 'Find the best makeup artists for your special occasions.',
            'category_id' => 1,
            'status' => 'published'
        ]);

        // Create Services
        $services = [
            [
                'title' => 'Bridal Makeup',
                'slug' => 'bridal-makeup',
                'description' => 'Complete bridal makeup package for your special day.',
                'price_from' => 1500000,
                'icon' => 'fas fa-ring',
                'features' => json_encode(['Trial makeup', 'Wedding day makeup', 'Touch-up kit']),
                'is_active' => true
            ],
            [
                'title' => 'Party Makeup',
                'slug' => 'party-makeup',
                'description' => 'Glamorous makeup for parties and special events.',
                'price_from' => 800000,
                'icon' => 'fas fa-cocktail',
                'features' => json_encode(['Professional makeup', 'Hair styling', 'False lashes']),
                'is_active' => true
            ],
            [
                'title' => 'Natural Look',
                'slug' => 'natural-look',
                'description' => 'Subtle and natural makeup for everyday occasions.',
                'price_from' => 500000,
                'icon' => 'fas fa-leaf',
                'features' => json_encode(['Natural base', 'Subtle colors', 'Long-lasting']),
                'is_active' => true
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Create Testimonials
        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'content' => 'Amazing service! The makeup artist was professional and made me look stunning for my wedding.',
                'rating' => 5,
                'status' => 'active'
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria@example.com',
                'content' => 'I love the natural look they created for me. Highly recommend!',
                'rating' => 5,
                'status' => 'active'
            ],
            [
                'name' => 'Lisa Wong',
                'email' => 'lisa@example.com',
                'content' => 'Professional service and beautiful results. Will definitely book again.',
                'rating' => 4,
                'status' => 'active'
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        // Create Hero Section
        HeroSection::create([
            'title' => 'Find Your Perfect Makeup Artist',
            'subtitle' => 'Professional Beauty Services',
            'description' => 'Connect with verified professional makeup artists in your area. Browse profiles, compare prices, read reviews, and book the perfect MUA for your special occasion.',
            'button_text' => 'Browse Artists',
            'button_url' => '/mua-listing'
        ]);

        // Create How It Works Steps
        $steps = [
            [
                'title' => 'Browse Artists',
                'description' => 'Explore our curated list of professional makeup artists in your area.',
                'step_number' => 1,
                'icon' => 'fas fa-search'
            ],
            [
                'title' => 'Compare & Review',
                'description' => 'Compare prices, read reviews, and check portfolios to find your perfect match.',
                'step_number' => 2,
                'icon' => 'fas fa-star'
            ],
            [
                'title' => 'Book & Enjoy',
                'description' => 'Book your chosen artist and enjoy professional makeup services for your special day.',
                'step_number' => 3,
                'icon' => 'fas fa-calendar-check'
            ]
        ];

        foreach ($steps as $step) {
            HowItWork::create($step);
        }

        $this->command->info('Default content seederhas been created successfully!');
    }
}
