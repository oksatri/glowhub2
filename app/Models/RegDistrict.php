<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegDistrict extends Model
{
    protected $table = 'reg_districts';

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'regency_id',
        'name',
    ];

    public function regency()
    {
        return $this->belongsTo(RegRegency::class, 'regency_id', 'id');
    }

    public function villages()
    {
        return $this->hasMany(RegVillage::class, 'district_id', 'id');
    }
}
