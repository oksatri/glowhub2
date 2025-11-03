<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use Illuminate\Support\Str;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Emily Johnson',
                'role' => 'Bride',
                'rating' => 5,
                'quote' => 'GlowHub membuat pencarian MUA untuk pernikahan saya sangat mudah! Saya bisa membandingkan portfolio, membaca ulasan, dan booking langsung. Sarah sempurna dan makeup saya flawless sepanjang hari.',
                'image' => 'images/testimonials/emily.jpg',
                'status' => 'publish',
                'order' => 1,
            ],
            [
                'name' => 'Jessica Chen',
                'role' => 'Corporate Event',
                'rating' => 5,
                'quote' => 'Saya suka bagaimana harga di GlowHub sangat transparan. Menemukan Maria melalui platform ini dan dia luar biasa untuk gala perusahaan saya. Proses booking sangat lancar!',
                'image' => 'images/testimonials/jessica.jpg',
                'status' => 'publish',
                'order' => 2,
            ],
            [
                'name' => 'Rachel Adams',
                'role' => 'Model',
                'rating' => 5,
                'quote' => 'Sebagai model, saya butuh MUA yang reliable untuk berbagai pemotretan. Sistem filter GlowHub membantu saya menemukan Emma yang spesialis editorial work. Perfect match setiap waktu!',
                'image' => 'images/testimonials/rachel.jpg',
                'status' => 'publish',
                'order' => 3,
            ],
        ];

        foreach ($items as $data) {
            // Use name as unique key to make seeder idempotent
            Testimonial::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
