<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalonDailyStatus extends Model
{
    protected $fillable = [
        'salon_id',
        'date',
        'status',
        'is_closed_today',
        'closed_date',
    ];

    protected $casts = [
        'date' => 'date',
        'is_closed_today' => 'boolean',
        'closed_date' => 'date',
    ];

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }
}
