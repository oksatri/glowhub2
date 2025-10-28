<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Content;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\HeroSection;
use App\Models\HowItWork;

class BackendContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $beautyTips = Category::create([
            'name' => 'Beauty Tips',
            'slug' => 'beauty-tips',
            'description' => 'Tips dan trik kecantikan untuk tampil memukau',
            'icon' => 'fas fa-sparkles',
            'color' => '#ff6b6b',
            'is_active' => true,
            'sort_order' => 1
        ]);

        $makeupTutorial = Category::create([
            'name' => 'Makeup Tutorial',
            'slug' => 'makeup-tutorial',
            'description' => 'Tutorial makeup step by step untuk pemula dan professional',
            'icon' => 'fas fa-palette',
            'color' => '#4ecdc4',
            'is_active' => true,
            'sort_order' => 2
        ]);

        $skincare = Category::create([
            'name' => 'Skincare',
            'slug' => 'skincare',
            'description' => 'Perawatan kulit yang tepat untuk berbagai jenis kulit',
            'icon' => 'fas fa-leaf',
            'color' => '#45b7d1',
            'is_active' => true,
            'sort_order' => 3
        ]);

        // Create Contents
        Content::create([
            'title' => 'Tips Makeup Natural untuk Pemula',
            'slug' => 'tips-makeup-natural-pemula',
            'excerpt' => 'Panduan lengkap makeup natural yang cocok untuk pemula. Pelajari teknik dasar dan produk yang dibutuhkan.',
            'content' => '<p>Makeup natural adalah pilihan terbaik untuk tampilan sehari-hari yang fresh dan tidak berlebihan. Berikut adalah panduan lengkap untuk pemula:</p>
            
            <h3>Persiapan Kulit</h3>
            <p>Langkah pertama yang paling penting adalah mempersiapkan kulit dengan baik:</p>
            <ul>
                <li>Bersihkan wajah dengan cleanser yang sesuai dengan jenis kulit</li>
                <li>Gunakan toner untuk menyeimbangkan pH kulit</li>
                <li>Aplikasikan moisturizer untuk menjaga kelembaban</li>
                <li>Jangan lupa sunscreen untuk melindungi dari UV</li>
            </ul>
            
            <h3>Base Makeup</h3>
            <p>Untuk base makeup natural, gunakan:</p>
            <ul>
                <li>Primer untuk menghaluskan tekstur kulit</li>
                <li>Foundation atau BB cream dengan coverage ringan</li>
                <li>Concealer hanya di area yang membutuhkan</li>
                <li>Setting powder tipis-tipis</li>
            </ul>',
            'category_id' => $makeupTutorial->id,
            'type' => 'article',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
            'sort_order' => 1
        ]);

        Content::create([
            'title' => '5 Produk Skincare Wajib untuk Kulit Berminyak',
            'slug' => '5-produk-skincare-kulit-berminyak',
            'excerpt' => 'Rekomendasi 5 produk skincare yang wajib dimiliki untuk mengatasi masalah kulit berminyak dan berjerawat.',
            'content' => '<p>Kulit berminyak membutuhkan perawatan khusus untuk mengontrol produksi sebum dan mencegah timbulnya jerawat. Berikut 5 produk skincare yang wajib ada dalam rutinmu:</p>
            
            <h3>1. Gentle Cleanser</h3>
            <p>Pilih cleanser yang dapat membersihkan minyak berlebih tanpa membuat kulit kering. Hindari produk yang terlalu harsh.</p>
            
            <h3>2. BHA Exfoliant</h3>
            <p>Salicylic acid dapat membantu membersihkan pori-pori dari dalam dan mengurangi komedo.</p>
            
            <h3>3. Niacinamide Serum</h3>
            <p>Niacinamide efektif mengontrol produksi minyak dan memperkecil tampilan pori-pori.</p>',
            'category_id' => $skincare->id,
            'type' => 'article',
            'status' => 'published',
            'is_featured' => false,
            'published_at' => now(),
            'sort_order' => 2
        ]);

        // Create Services
        Service::create([
            'title' => 'Wedding Makeup',
            'slug' => 'wedding-makeup',
            'description' => 'Layanan makeup pengantin yang akan membuat hari spesial Anda semakin berkesan. Termasuk trial makeup dan touch up.',
            'icon' => 'fas fa-heart',
            'price_from' => 1500000,
            'price_to' => 3000000,
            'duration' => 180,
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 1,
            'features' => [
                'Trial makeup 1x',
                'Makeup pengantin lengkap',
                'Touch up selama acara',
                'Makeup untuk foto pre-wedding'
            ]
        ]);

        Service::create([
            'title' => 'Party Makeup',
            'slug' => 'party-makeup',
            'description' => 'Makeup untuk acara pesta, party, atau event khusus. Tampil glamour dan memukau di setiap kesempatan.',
            'icon' => 'fas fa-star',
            'price_from' => 300000,
            'price_to' => 800000,
            'duration' => 90,
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 2,
            'features' => [
                'Konsultasi gaya makeup',
                'Makeup sesuai dress code',
                'Setting spray tahan lama',
                'Mini touch up kit'
            ]
        ]);

        // Create Testimonials
        Testimonial::create([
            'name' => 'Sarah Johnson',
            'position' => 'Model',
            'company' => 'Elite Model Management',
            'message' => 'GlowHub sangat membantu saya menemukan makeup artist terbaik untuk setiap photoshoot. Sistem filter yang detail membuat saya bisa menemukan MUA yang sesuai dengan kebutuhan spesifik saya.',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 1
        ]);

        Testimonial::create([
            'name' => 'Rachel Adams',
            'position' => 'Bride',
            'message' => 'Terima kasih GlowHub! Saya menemukan MUA yang sempurna untuk hari pernikahan saya. Prosesnya mudah dan hasilnya memuaskan. Semua tamu memuji makeup saya!',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 2
        ]);

        Testimonial::create([
            'name' => 'Diana Chen',
            'position' => 'Content Creator',
            'message' => 'Sebagai content creator, saya butuh MUA yang bisa bekerja dengan lighting yang berbeda-beda. Melalui GlowHub, saya menemukan tim MUA profesional yang sangat paham kebutuhan saya.',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 3
        ]);

        // Create Hero Section
        HeroSection::create([
            'title' => 'Find Your Perfect Makeup Artist',
            'subtitle' => 'Professional Makeup Services at Your Fingertips',
            'description' => 'GlowHub menghubungkan Anda dengan makeup artist profesional terverifikasi di area Anda. Jelajahi profil, bandingkan harga, baca ulasan, dan booking MUA yang sempurna untuk acara spesial Anda.',
            'primary_button_text' => 'Browse MUAs',
            'primary_button_url' => '/mua-listing',
            'secondary_button_text' => 'How It Works',
            'secondary_button_url' => '#how-it-works',
            'is_active' => true,
            'page' => 'home',
            'background_options' => [
                'type' => 'gradient',
                'colors' => ['#ff6b6b', '#ff8a80']
            ]
        ]);

        // Create How It Works Steps
        HowItWork::create([
            'title' => 'Browse & Discover',
            'description' => 'Jelajahi ratusan profil makeup artist profesional di area Anda dengan sistem filter yang canggih.',
            'icon' => 'fas fa-search',
            'step_number' => '1',
            'is_active' => true,
            'sort_order' => 1
        ]);

        HowItWork::create([
            'title' => 'Compare & Choose',
            'description' => 'Bandingkan harga, gaya, dan ulasan untuk menemukan MUA yang paling sesuai dengan kebutuhan Anda.',
            'icon' => 'fas fa-balance-scale',
            'step_number' => '2',
            'is_active' => true,
            'sort_order' => 2
        ]);

        HowItWork::create([
            'title' => 'Book & Confirm',
            'description' => 'Booking langsung melalui platform dengan sistem pembayaran yang aman dan terpercaya.',
            'icon' => 'fas fa-calendar-check',
            'step_number' => '3',
            'is_active' => true,
            'sort_order' => 3
        ]);

        HowItWork::create([
            'title' => 'Enjoy Your Look',
            'description' => 'Nikmati hasil makeup profesional dan tampil percaya diri di acara spesial Anda.',
            'icon' => 'fas fa-heart',
            'step_number' => '4',
            'is_active' => true,
            'sort_order' => 4
        ]);
    }
}
