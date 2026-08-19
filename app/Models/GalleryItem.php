<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryItem extends Model
{
    protected $fillable = [
        'salon_id',
        'image_path',
        'title',
        'alt_text',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }
}
