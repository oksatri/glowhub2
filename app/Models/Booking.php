<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'mua_id',
        'mua_service_id',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_whatsapp',
        'customer_address',
        'distance_km',
        'selected_date',
        'selected_time',
        'services',
        'status',
        'admin_note',
        'mua_note',
        'revised_price',
        'price_note',
        'service_price'
    ];

    protected $casts = [
        'services' => 'array',
        'selected_date' => 'date',
        'distance_km' => 'decimal:2',
        'revised_price' => 'decimal:2',
        'service_price' => 'decimal:2'
    ];

    public function mua()
    {
        return $this->belongsTo(Mua::class);
    }

    public function service()
    {
        return $this->belongsTo(MuaService::class, 'mua_service_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
