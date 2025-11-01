<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentDetail extends Model
{
    use HasFactory;

    protected $table = 'content_details';

    protected $fillable = [
        'category',
        'content_id',
        'icon',
        'image',
        'title',
        'description',
        'additional',
        'order',
    ];

    protected $casts = [
        'additional' => 'array',
        'order' => 'integer',
    ];

    /**
     * ContentDetail belongs to a ContentSection
     */
    public function content()
    {
        return $this->belongsTo(ContentSection::class, 'content_id');
    }
}
