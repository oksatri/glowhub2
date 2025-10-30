<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon',
        'image',
        'price_from',
        'price_to',
        'duration',
        'is_active',
        'is_featured',
        'sort_order',
        'features'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'features' => 'array',
        'price_from' => 'decimal:2',
        'price_to' => 'decimal:2'
    ];

    // Scope untuk service aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk service featured (dummy implementation)
    public function scopeFeatured($query)
    {
        return $query; // Return all for now
    }

    // Scope untuk urutan
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Accessor untuk harga range
    public function getPriceRangeAttribute()
    {
        if ($this->price_from && $this->price_to) {
            return 'Rp ' . number_format($this->price_from, 0, ',', '.') . ' - Rp ' . number_format($this->price_to, 0, ',', '.');
        } elseif ($this->price_from) {
            return 'Mulai dari Rp ' . number_format($this->price_from, 0, ',', '.');
        }
        return 'Hubungi untuk harga';
    }
}
