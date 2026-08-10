<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\SalonDailyStatus;
use App\Models\WorkingHour;
use App\Support\Days;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class BookingAvailabilityService
{
    /**
     * Check whether the salon is closed for a specific date.
     */
    public function isSalonClosed(
        int $salonId,
        CarbonInterface|string $date
    ): bool {
        $date = Carbon::parse($date)->startOfDay();

        /*
        |--------------------------------------------------------------------------
        | Explicit Daily Status
        |--------------------------------------------------------------------------
        */

        $dailyStatus = SalonDailyStatus::query()
            ->where('salon_id', $salonId)
            ->whereDate('date', $date)
            ->first();

        if ($dailyStatus) {

            if ($dailyStatus->is_closed_today) {
                return true;
            }

            if (
                $dailyStatus->closed_date &&
                $dailyStatus->closed_date->isSameDay($date)
            ) {
                return true;
            }

            if (
                is_string($dailyStatus->status) &&
                in_array(
                    strtolower($dailyStatus->status),
                    ['closed', 'close'],
                    true
                )
            ) {
                return true;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Weekly Working Hours
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Database convention:
        |
        | 0 = Saturday
        | 1 = Sunday
        | 2 = Monday
        | 3 = Tuesday
        | 4 = Wednesday
        | 5 = Thursday
        | 6 = Friday
        |
        | Carbon uses:
        |
        | 0 = Sunday
        | ...
        | 6 = Saturday
        |
        | So we MUST use Days::fromCarbon().
        |
        */

        $dayOfWeek = Days::fromCarbon($date);

        $workingHour = WorkingHour::query()
            ->where('salon_id', $salonId)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | No Working Hour = Closed
        |--------------------------------------------------------------------------
        */

        if (!$workingHour) {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Weekly Closed
        |--------------------------------------------------------------------------
        */

        if ($workingHour->is_closed) {
            return true;
        }

        return false;
    }

    /**
     * Get working hour for a specific date.
     */
    public function getWorkingHour(
        int $salonId,
        CarbonInterface|string $date
    ): ?WorkingHour {
        $date = Carbon::parse($date)->startOfDay();

        $dayOfWeek = Days::fromCarbon($date);

        return WorkingHour::query()
            ->where('salon_id', $salonId)
            ->where('day_of_week', $dayOfWeek)
            ->first();
    }

    /**
     * Check whether a specific time is inside working hours.
     */
    public function isWithinWorkingHours(
        int $salonId,
        CarbonInterface|string $date,
        string $time,
        ?int $durationMinutes = 60
    ): bool {
        $date = Carbon::parse($date)->startOfDay();

        /*
        |--------------------------------------------------------------------------
        | Salon Closed
        |--------------------------------------------------------------------------
        */

        if ($this->isSalonClosed($salonId, $date)) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Working Hour
        |--------------------------------------------------------------------------
        */

        $workingHour = $this->getWorkingHour(
            $salonId,
            $date
        );

        if (
            !$workingHour ||
            $workingHour->is_closed ||
            !$workingHour->start_time ||
            !$workingHour->end_time
        ) {
            return false;
        }

        $durationMinutes = $durationMinutes ?: 60;

        /*
        |--------------------------------------------------------------------------
        | Opening / Closing
        |--------------------------------------------------------------------------
        */

        $dateString = $date->format('Y-m-d');

        $start = Carbon::parse(
            $dateString . ' ' . $workingHour->start_time
        );

        $end = Carbon::parse(
            $dateString . ' ' . $workingHour->end_time
        );

        $bookingStart = Carbon::parse(
            $dateString . ' ' . $time
        );

        $bookingEnd = $bookingStart
            ->copy()
            ->addMinutes($durationMinutes);

        /*
        |--------------------------------------------------------------------------
        | Before Opening
        |--------------------------------------------------------------------------
        */

        if ($bookingStart->lt($start)) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | After Closing
        |--------------------------------------------------------------------------
        */

        if ($bookingEnd->gt($end)) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Break Time
        |--------------------------------------------------------------------------
        */

        if (
            $workingHour->break_start &&
            $workingHour->break_end
        ) {

            $breakStart = Carbon::parse(
                $dateString . ' ' . $workingHour->break_start
            );

            $breakEnd = Carbon::parse(
                $dateString . ' ' . $workingHour->break_end
            );

            /*
            |--------------------------------------------------------------------------
            | Booking Overlaps Break
            |--------------------------------------------------------------------------
            */

            if (
                $bookingStart->lt($breakEnd) &&
                $bookingEnd->gt($breakStart)
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check whether a booking conflicts with another active booking.
     */
    public function hasBookingConflict(
        int $salonId,
        CarbonInterface|string $date,
        string $time,
        ?int $durationMinutes = 60,
        ?int $ignoreBookingId = null
    ): bool {
        $date = Carbon::parse($date)->startOfDay();

        $durationMinutes = $durationMinutes ?: 60;

        $dateString = $date->format('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | New Booking Range
        |--------------------------------------------------------------------------
        */

        $newStart = Carbon::parse(
            $dateString . ' ' . $time
        );

        $newEnd = $newStart
            ->copy()
            ->addMinutes($durationMinutes);

        /*
        |--------------------------------------------------------------------------
        | Existing Active Bookings
        |--------------------------------------------------------------------------
        */

        $query = Booking::query()
            ->where('salon_id', $salonId)
            ->whereDate('booking_date', $date)
            ->whereIn('status', [
                'pending',
                'approved',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Ignore Current Booking
        |--------------------------------------------------------------------------
        */

        if ($ignoreBookingId !== null) {
            $query->where(
                'id',
                '!=',
                $ignoreBookingId
            );
        }

        $existingBookings = $query->get();

        /*
        |--------------------------------------------------------------------------
        | Overlap Detection
        |--------------------------------------------------------------------------
        */

        foreach ($existingBookings as $booking) {

            $existingStart = Carbon::parse(
                $dateString . ' ' . $booking->booking_time
            );

            $existingEnd = $existingStart
                ->copy()
                ->addMinutes(
                    $booking->duration_minutes ?: 60
                );

            /*
            |--------------------------------------------------------------------------
            | Overlap Formula
            |--------------------------------------------------------------------------
            |
            | New Start < Existing End
            | AND
            | New End > Existing Start
            |
            */

            if (
                $newStart->lt($existingEnd) &&
                $newEnd->gt($existingStart)
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check whether a time slot can be booked.
     */
    public function isAvailable(
        int $salonId,
        CarbonInterface|string $date,
        string $time,
        ?int $durationMinutes = 60,
        ?int $ignoreBookingId = null
    ): bool {
        /*
        |--------------------------------------------------------------------------
        | Working Hours + Break
        |--------------------------------------------------------------------------
        */

        if (
            !$this->isWithinWorkingHours(
                $salonId,
                $date,
                $time,
                $durationMinutes
            )
        ) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Booking Conflict
        |--------------------------------------------------------------------------
        */

        if (
            $this->hasBookingConflict(
                $salonId,
                $date,
                $time,
                $durationMinutes,
                $ignoreBookingId
            )
        ) {
            return false;
        }

        return true;
    }

    /**
     * Return available time slots for a specific date.
     */
    public function getAvailableSlots(
        int $salonId,
        CarbonInterface|string $date,
        int $durationMinutes = 60,
        int $intervalMinutes = 30
    ): array {
        $date = Carbon::parse($date)->startOfDay();

        /*
        |--------------------------------------------------------------------------
        | Closed Salon
        |--------------------------------------------------------------------------
        */

        if ($this->isSalonClosed($salonId, $date)) {
            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | Working Hour
        |--------------------------------------------------------------------------
        */

        $workingHour = $this->getWorkingHour(
            $salonId,
            $date
        );

        if (
            !$workingHour ||
            $workingHour->is_closed ||
            !$workingHour->start_time ||
            !$workingHour->end_time
        ) {
            return [];
        }

        $durationMinutes = $durationMinutes ?: 60;

        $intervalMinutes = $intervalMinutes > 0
            ? $intervalMinutes
            : 30;

        $dateString = $date->format('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | Working Range
        |--------------------------------------------------------------------------
        */

        $start = Carbon::parse(
            $dateString . ' ' . $workingHour->start_time
        );

        $end = Carbon::parse(
            $dateString . ' ' . $workingHour->end_time
        );

        $slots = [];

        /*
        |--------------------------------------------------------------------------
        | Generate Slots
        |--------------------------------------------------------------------------
        */

        for (
            $current = $start->copy();

            $current
                ->copy()
                ->addMinutes($durationMinutes)
                ->lte($end);

            $current->addMinutes($intervalMinutes)
        ) {

            $time = $current->format('H:i');

            if (
                $this->isAvailable(
                    $salonId,
                    $date,
                    $time,
                    $durationMinutes
                )
            ) {
                $slots[] = $time;
            }
        }

        return $slots;
    }

    /**
     * Get availability information for a specific date.
     */
    public function getDateAvailability(
        int $salonId,
        CarbonInterface|string $date,
        ?int $durationMinutes = 60
    ): array {
        $date = Carbon::parse($date)->startOfDay();

        /*
        |--------------------------------------------------------------------------
        | Closed
        |--------------------------------------------------------------------------
        */

        if ($this->isSalonClosed($salonId, $date)) {
            return [
                'available' => false,
                'closed' => true,
                'message' => 'سالن در این روز تعطیل است.',
                'slots' => [],
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Available Slots
        |--------------------------------------------------------------------------
        */

        $slots = $this->getAvailableSlots(
            $salonId,
            $date,
            $durationMinutes ?: 60
        );

        return [
            'available' => count($slots) > 0,
            'closed' => false,
            'message' => count($slots) > 0
                ? null
                : 'در این روز زمان خالی وجود ندارد.',
            'slots' => $slots,
        ];
    }
}
