<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Salon extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'qr_token',
        'phone',
        'address',
        'instagram',
        'description',
        'logo',
        'cover',
        'is_active',
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (Salon $salon) {

            if (blank($salon->slug)) {
                $salon->slug = 'salon-' . Str::lower(Str::random(8));
            }

            if (blank($salon->qr_token)) {

                do {
                    $token = 'BB-' . strtoupper(Str::random(8));
                } while (Salon::where('qr_token', $token)->exists());

                $salon->qr_token = $token;
            }
        });
    }
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * @return HasMany
     */
    public function workingHours(): HasMany
    {
        return $this->hasMany(WorkingHour::class);
    }

    /**
     * @return HasMany
     */
    public function dailyStatuses(): HasMany
    {
        return $this->hasMany(SalonDailyStatus::class);
    }}
