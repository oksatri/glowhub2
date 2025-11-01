<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSection extends Model
{
    use HasFactory;

    protected $table = 'contents';

    protected $fillable = [
        'title',
        'description',
        'section_type',
        'has_button',
        'buttons_count',
        'buttons',
        'image',
        'status',
        'order',
    ];

    protected $casts = [
        'has_button' => 'boolean',
        'buttons' => 'array',
        'buttons_count' => 'integer',
        'order' => 'integer',
    ];

    /**
     * ContentSection has many ContentDetail records
     */
    public function details()
    {
        return $this->hasMany(ContentDetail::class, 'content_id');
    }
}
