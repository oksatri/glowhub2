<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'site_name' => 'GlowHub',
            'site_tagline' => 'Find the perfect MUA for every occasion',
            'contact_email' => 'support@glowhub.com',
            'contact_phone' => '+1 (555) 123-4567',
            'address' => "123 Beauty Street\nNew York, NY 10001",
            'logo' => null,
            'footer_text' => '© ' . date('Y') . ' GlowHub. All rights reserved.',
            'social_links' => [
                'facebook' => 'https://facebook.com/glowhub',
                'instagram' => 'https://instagram.com/glowhub',
            ],
            'meta_title' => 'GlowHub - Makeup Artists & Booking',
            'meta_description' => 'Find and book professional makeup artists for weddings, events, and editorial work.',
            'maintenance_mode' => false,
            'analytics_code' => null,
            'primary_color' => '#E879F9',
            'contact_hours' => "Monday - Friday: 9AM - 6PM\nWeekend: 10AM - 4PM",
            'support_whatsapp' => '+1 (555) 987-6543',
            'enable_registration' => true,
        ];

        // single row settings, idempotent
        SiteSetting::updateOrCreate(['id' => 1], $data);
    }
}
