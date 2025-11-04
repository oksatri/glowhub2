<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $table = 'site_settings';

    protected $fillable = [
        'site_name',
        'site_tagline',
        'contact_email',
        'contact_phone',
        'address',
        'logo',
        'favicon',
        'footer_text',
        'social_links',
        'meta_title',
        'meta_description',
        'maintenance_mode',
        'analytics_code',
        'primary_color',
        'contact_hours',
        'support_whatsapp',
        'enable_registration',
    ];

    protected $casts = [
        'social_links' => 'array',
        'maintenance_mode' => 'boolean',
        'enable_registration' => 'boolean',
    ];
}
