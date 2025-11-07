<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuaService extends Model
{
    use HasFactory;

    protected $table = 'mua_services';

    protected $fillable = ['mua_id', 'service_name', 'description', 'features', 'price'];

    protected $casts = [
        'features' => 'array',
    ];

    public function mua()
    {
        return $this->belongsTo(Mua::class);
    }

    public function portfolios()
    {
        return $this->hasMany(MuaPortfolio::class);
    }
}
