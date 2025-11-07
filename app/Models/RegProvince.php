<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegProvince extends Model
{
    protected $table = 'reg_provinces';

    // IDs are fixed-length chars (not auto-incrementing)
    public $incrementing = false;
    protected $keyType = 'string';

    // Source SQL doesn't include timestamps
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];

    public function regencies()
    {
        return $this->hasMany(RegRegency::class, 'province_id', 'id');
    }
}
