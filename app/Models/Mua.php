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
        'specialty',
        'rating',
        'experience',
        'link_map',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
}
