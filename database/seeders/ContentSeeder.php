<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ContentSection;
use App\Models\ContentDetail;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean up existing seeded content (non-destructive for other tables)
        DB::table('content_details')->delete();
        DB::table('contents')->delete();

        // 1) Hero
        $hero = ContentSection::create([
            'slug' => 'hero',
            'excerpt' => 'GlowHub menghubungkan Anda dengan makeup artist profesional terverifikasi di area Anda.',
            'title' => 'Find Your Perfect Makeup Artist',
            'description' => 'GlowHub menghubungkan Anda dengan makeup artist profesional terverifikasi di area Anda. Jelajahi profil, bandingkan harga, baca ulasan, dan booking MUA yang sempurna untuk acara spesial Anda.',
            'section_type' => 'hero',
            'has_button' => true,
            'buttons_count' => 2,
            'buttons' => [
                ['text' => 'Browse MUAs', 'link' => '/mua-listing'],
                ['text' => 'How It Works', 'link' => '#how-it-works'],
            ],
            'image' => 'images/main-banner1.jpg',
            'status' => 'publish',
            'order' => 1,
        ]);

        // 2) How It Works (features)
        $how = ContentSection::create([
            'slug' => 'how-it-works',
            'title' => 'How GlowHub Works',
            'description' => 'Terhubung dengan makeup artist profesional dalam 4 langkah sederhana',
            'section_type' => 'content',
            'has_button' => false,
            'buttons_count' => 0,
            'buttons' => null,
            'status' => 'publish',
            'order' => 2,
        ]);

        $howFeatures = [
            ['icon' => 'fas fa-search', 'title' => '1. Explore MUA Portfolios', 'description' => 'Masukkan tanggal makeup dan jenis acaranya. Pilih style makeup yang paling cocok dengan vibe kamu!'],
            ['icon' => 'fas fa-paper-plane', 'title' => '2. Send Booking Request', 'description' => 'Isi detail acara, tanggal, dan informasi lainnya. Klik "Request" dan tunggu konfirmasi ketersediaan dan harga dari MUA.'],
            ['icon' => 'fas fa-check-circle', 'title' => '3. MUA Review & Confirm', 'description' => 'Request kamu akan direview oleh MUA untuk memastikan ketersediaan jadwal dan apakah terdapat penyesuaian dari estimasi harga.'],
            ['icon' => 'fas fa-lock', 'title' => '4. Secure Your Slot!', 'description' => 'Setelah request dikonfirmasi, kamu akan dihubungi via WA untuk melanjutkan pembayaran sesuai harga yang dikonfirmasi.'],
        ];

        foreach ($howFeatures as $i => $f) {
            ContentDetail::create([
                'category' => 'feature',
                'content_id' => $how->id,
                'icon' => $f['icon'],
                'title' => $f['title'],
                'description' => $f['description'],
                'order' => $i + 1,
            ]);
        }

        // 3) Discover Top-Rated MUAs (products)
        $discover = ContentSection::create([
            'slug' => 'discover-mua',
            'title' => 'Discover Top-Rated MUAs',
            'description' => 'Jelajahi makeup artist terverifikasi di dekat Anda. Semua profil mencakup portfolio, ulasan, dan harga yang transparan.',
            'section_type' => 'product',
            'has_button' => true,
            'buttons_count' => 1,
            'buttons' => [
                ['text' => 'View All Artists', 'link' => '/mua-listing'],
            ],
            'status' => 'publish',
            'order' => 3,
        ]);

        for ($x = 1; $x <= 6; $x++) {
            ContentDetail::create([
                'category' => 'product',
                'content_id' => $discover->id,
                'image' => "images/product-item{$x}.jpg",
                'title' => 'Sarah Martinez',
                'description' => 'Bridal • Malang | Lowokwaru',
                'order' => $x,
            ]);
        }

        // 4) Services (for MUA)
        $services = ContentSection::create([
            'slug' => 'services',
            'title' => 'Join GlowHub as a Makeup Artist',
            'description' => 'Kembangkan bisnis Anda dan terhubung dengan klien yang menghargai keahlian makeup profesional',
            'section_type' => 'content',
            'has_button' => true,
            'buttons_count' => 1,
            'buttons' => [
                ['text' => 'Join as MUA', 'link' => '#'],
            ],
            'status' => 'publish',
            'order' => 4,
        ]);

        $serviceItems = [
            ['icon' => 'fas fa-users', 'title' => 'Expand Your Clientele', 'description' => 'Jangkau ribuan klien potensial yang secara aktif mencari makeup artist profesional di area Anda.'],
            ['icon' => 'fas fa-calendar-alt', 'title' => 'Manage Your Schedule', 'description' => 'Sistem booking mudah dengan integrasi kalender. Tetapkan ketersediaan Anda dan biarkan klien booking langsung melalui platform.'],
            ['icon' => 'fas fa-credit-card', 'title' => 'Secure Payments', 'description' => 'Dapatkan pembayaran dengan aman dan tepat waktu. Sistem pembayaran aman kami menangani transaksi dan merilis dana setelah layanan selesai.'],
        ];

        foreach ($serviceItems as $i => $s) {
            ContentDetail::create([
                'category' => 'feature',
                'content_id' => $services->id,
                'icon' => $s['icon'],
                'title' => $s['title'],
                'description' => $s['description'],
                'order' => $i + 1,
            ]);
        }

        // 5) Testimonials
        $testimonials = ContentSection::create([
            'slug' => 'testimonials',
            'title' => 'Why Clients Love GlowHub',
            'description' => 'Pengalaman nyata dari pengguna platform kami',
            'section_type' => 'testimonials',
            'has_button' => false,
            'buttons_count' => 0,
            'buttons' => null,
            'status' => 'publish',
            'order' => 5,
        ]);

        $testItems = [
            ['title' => 'Emily Johnson', 'description' => '"GlowHub membuat pencarian MUA untuk pernikahan saya sangat mudah! Saya bisa membandingkan portfolio, membaca ulasan, dan booking langsung."', 'image' => 'images/default.png'],
            ['title' => 'Jessica Chen', 'description' => '"Saya suka bagaimana harga di GlowHub sangat transparan. Menemukan Maria melalui platform ini dan dia luar biasa untuk gala perusahaan saya."', 'image' => 'images/default.png'],
            ['title' => 'Rachel Adams', 'description' => '"Sebagai model, saya butuh MUA yang reliable untuk berbagai pemotretan. Sistem filter GlowHub membantu saya menemukan Emma yang spesialis editorial work."', 'image' => 'images/default.png'],
        ];

        foreach ($testItems as $i => $t) {
            ContentDetail::create([
                'category' => 'testimonial',
                'content_id' => $testimonials->id,
                'image' => $t['image'],
                'title' => $t['title'],
                'description' => $t['description'],
                'order' => $i + 1,
            ]);
        }

        // 6) Contact
        $contact = ContentSection::create([
            'slug' => 'contact',
            'title' => 'Need Help Finding the Right MUA?',
            'description' => 'Tim kami dapat membantu Anda menemukan makeup artist yang sempurna untuk acara Anda. Hubungi kami untuk rekomendasi yang personal!',
            'section_type' => 'contact',
            'has_button' => false,
            'buttons_count' => 0,
            'buttons' => null,
            'status' => 'publish',
            'order' => 6,
        ]);

        $contactItems = [
            ['icon' => 'fas fa-map-marker-alt', 'title' => 'Location', 'description' => "123 Beauty Street\nNew York, NY 10001"],
            ['icon' => 'fas fa-phone', 'title' => 'Phone', 'description' => '+1 (555) 123-4567'],
            ['icon' => 'fas fa-envelope', 'title' => 'Email', 'description' => 'support@glowhub.com'],
            ['icon' => 'fas fa-clock', 'title' => 'Hours', 'description' => "Monday - Friday: 9AM - 6PM\nWeekend: 10AM - 4PM"],
        ];

        foreach ($contactItems as $i => $c) {
            ContentDetail::create([
                'category' => 'contact',
                'content_id' => $contact->id,
                'icon' => $c['icon'],
                'title' => $c['title'],
                'description' => $c['description'],
                'order' => $i + 1,
            ]);
        }
    }
}
