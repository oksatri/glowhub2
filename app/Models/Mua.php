<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mua extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'city',
        'service_cities',
        'rating',
        'max_distance',
        'operational_hours',
        'additional_charge',
        'link_map',
        'image',
        'availability_hours'
    ];

    protected $casts = [
        'additional_charge' => 'integer',
        'availability_hours' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function services()
    {
        return $this->hasMany(MuaService::class);
    }

    public function portfolios()
    {
        return $this->hasMany(MuaPortfolio::class);
    }

    public function rel_city()
    {
        return $this->belongsTo(RegRegency::class, 'city');
    }

    public function getServiceCitiesAttribute()
    {
        return $this->attributes['service_cities'] ? explode(',', $this->attributes['service_cities']) : [];
    }

    public function setServiceCitiesAttribute($value)
    {
        $this->attributes['service_cities'] = is_array($value) ? implode(',', $value) : $value;
    }

    public function addUnavailableSlot($date, $startTime, $endTime, $reason = null)
    {
        $availability = $this->availability_hours ?? [];
        $availability[] = [
            'id' => uniqid(),
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'reason' => $reason,
            'created_at' => now()->toISOString()
        ];
        $this->availability_hours = $availability;
        $this->save();
    }

    public function removeUnavailableSlot($slotId)
    {
        $availability = $this->availability_hours ?? [];
        $this->availability_hours = array_filter($availability, function($slot) use ($slotId) {
            return $slot['id'] !== $slotId;
        });
        $this->save();
    }

    public function isAvailableAt($date, $time)
    {
        if (!$this->availability_hours) {
            return true;
        }

        foreach ($this->availability_hours as $slot) {
            if ($slot['date'] === $date) {
                if ($time >= $slot['start_time'] && $time <= $slot['end_time']) {
                    return false;
                }
            }
        }

        return true;
    }
}
