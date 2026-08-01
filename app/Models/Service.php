<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $fillable = [
        'salon_id',
        'name',
        'description',
        'duration',
        'price',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
        'duration' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
