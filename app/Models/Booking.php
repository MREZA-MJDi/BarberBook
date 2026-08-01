<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = [
        'salon_id',
        'service_id',
        'reference_code',
        'customer_name',
        'customer_phone',
        'booking_date',
        'booking_time',
        'customer_note',
        'barber_note',
        'status',
    ];

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {

            do {
                $code = 'BB-' . strtoupper(Str::random(8));
            } while (Booking::where('reference_code', $code)->exists());

            $booking->reference_code = $code;
        });
    }

    /**
     * @return BelongsTo
     */
    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
