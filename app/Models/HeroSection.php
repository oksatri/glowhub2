<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'background_image',
        'button_text',
        'button_url',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    // Scope untuk hero section aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
