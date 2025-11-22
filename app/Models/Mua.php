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
        'image'
    ];

    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'id','user_id');
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
        return $this->service_cities ? explode(',', $this->service_cities) : [];
    }

    public function setServiceCitiesAttribute($value)
    {
        $this->attributes['service_cities'] = is_array($value) ? implode(',', $value) : $value;
    }
}
