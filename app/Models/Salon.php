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
     * Generate salon slug automatically.
     *
     * QR token is intentionally NOT generated here.
     * QR token must be generated manually from the dashboard.
     */
    protected static function booted(): void
    {
        static::creating(function (Salon $salon) {

            if (blank($salon->slug)) {
                $salon->slug = 'salon-' . Str::lower(Str::random(8));
            }

        });
    }

    /**
     * Salon owner.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Salon services.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Salon bookings.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Salon working hours.
     */
    public function workingHours(): HasMany
    {
        return $this->hasMany(WorkingHour::class);
    }

    /**
     * Salon reviews.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Salon daily statuses.
     */
    public function dailyStatuses(): HasMany
    {
        return $this->hasMany(SalonDailyStatus::class);
    }

    public function galleryItems(): HasMany
    {
        return $this->hasMany(GalleryItem::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
