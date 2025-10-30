<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HowItWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'image',
        'step_number',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    // Scope untuk steps aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope untuk urutan
    public function scopeOrdered($query)
    {
        return $query->orderBy('step_number', 'asc');
    }
}
