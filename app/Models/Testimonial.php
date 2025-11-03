<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'testimonials';

    protected $fillable = [
        'name',
        'role',
        'rating',
        'quote',
        'image',
        'status',
        'order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'order' => 'integer',
    ];
}
