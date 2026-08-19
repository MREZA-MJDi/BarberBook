<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    /**
     * Can the user access the reviews dashboard?
     */
    public function viewAny(User $user): bool
    {
        return $user->salon !== null;
    }

    /**
     * Can the user view a specific review?
     *
     * Allowed:
     * - Review author
     * - Owner of the salon receiving the review
     */
    public function view(User $user, Review $review): bool
    {
        if ((int) $review->user_id === (int) $user->id) {
            return true;
        }

        return $user->salon !== null
            && (int) $review->salon_id === (int) $user->salon->id;
    }


    /*
    |--------------------------------------------------------------------------
    | Customer
    |--------------------------------------------------------------------------
    */

    /**
     * Can the user create a review for this booking?
     */
    public function create(User $user, Booking $booking): bool
    {
        if ($booking->status !== 'completed') {
            return false;
        }

        if ($booking->review()->exists()) {
            return false;
        }

        if (blank($user->phone) || blank($booking->customer_phone)) {
            return false;
        }

        return $this->normalizePhone($user->phone)
            === $this->normalizePhone($booking->customer_phone);
    }

    /**
     * Can the customer update their own review?
     */
    public function update(User $user, Review $review): bool
    {
        return (int) $review->user_id === (int) $user->id;
    }

    /**
     * Can the customer delete their own review?
     */
    public function delete(User $user, Review $review): bool
    {
        return (int) $review->user_id === (int) $user->id;
    }


    /*
    |--------------------------------------------------------------------------
    | Salon Owner Moderation
    |--------------------------------------------------------------------------
    */

    /**
     * Can the salon owner publish this review?
     */
    public function publish(User $user, Review $review): bool
    {
        return $user->salon !== null
            && (int) $review->salon_id === (int) $user->salon->id;
    }

    /**
     * Can the salon owner reject/hide this review?
     */
    public function reject(User $user, Review $review): bool
    {
        return $user->salon !== null
            && (int) $review->salon_id === (int) $user->salon->id;
    }


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Normalize phone numbers for comparison.
     */
    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone) ?? '';

        if (str_starts_with($phone, '0098')) {
            $phone = '0' . substr($phone, 4);
        }

        if (str_starts_with($phone, '98')) {
            $phone = '0' . substr($phone, 2);
        }

        return $phone;
    }
}
