<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'instructions',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'instructions' => 'array',
        'is_active' => 'boolean'
    ];

    public function bookingPayments()
    {
        return $this->hasMany(BookingPayment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
