<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuaPortfolio extends Model
{
    use HasFactory;

    protected $table = 'mua_portfolios';

    protected $fillable = ['mua_id', 'mua_service_id', 'image', 'description'];

    public function mua()
    {
        return $this->belongsTo(Mua::class);
    }

    public function service()
    {
        return $this->belongsTo(MuaService::class, 'mua_service_id');
    }
}
