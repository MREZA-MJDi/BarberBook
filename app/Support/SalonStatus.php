<?php

namespace App\Support;

use App\Models\Salon;
use Carbon\Carbon;

class SalonStatus
{
    /**
     * Get current salon status.
     *
     * Possible statuses:
     * - open
     * - closed
     * - break
     * - inactive
     */
    public static function get(Salon $salon): array
    {
        /*
        |--------------------------------------------------------------------------
        | Salon inactive
        |--------------------------------------------------------------------------
        */

        if (! $salon->is_active) {
            return [
                'status' => 'inactive',
                'label' => 'غیرفعال',
                'is_open' => false,
                'is_break' => false,
                'is_closed' => true,
                'message' => 'سالن غیرفعال است',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Current Time
        |--------------------------------------------------------------------------
        */

        $now = Carbon::now();

        /*
        |--------------------------------------------------------------------------
        | Today's Manual Status
        |--------------------------------------------------------------------------
        */

        $dailyStatus = $salon->dailyStatuses()
            ->whereDate('date', $now->toDateString())
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Manually Closed Today
        |--------------------------------------------------------------------------
        */

        if (
            $dailyStatus &&
            (
                $dailyStatus->status === 'closed' ||
                $dailyStatus->is_closed_today
            )
        ) {
            return [
                'status' => 'closed',
                'label' => 'بسته',
                'is_open' => false,
                'is_break' => false,
                'is_closed' => true,
                'message' => 'امروز سالن تعطیل است',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Convert Carbon Day To Persian Week System
        |--------------------------------------------------------------------------
        |
        | Carbon:
        | Sunday = 0
        | Monday = 1
        | ...
        | Saturday = 6
        |
        | Our system:
        | Saturday = 0
        | Sunday = 1
        | ...
        | Friday = 6
        |
        */

        $carbonDay = $now->dayOfWeek;

        $dayOfWeek = ($carbonDay + 1) % 7;

        /*
        |--------------------------------------------------------------------------
        | Working Hours
        |--------------------------------------------------------------------------
        */

        $workingHour = $salon->workingHours()
            ->where('day_of_week', $dayOfWeek)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | No Working Hour
        |--------------------------------------------------------------------------
        */

        if (! $workingHour) {
            return [
                'status' => 'closed',
                'label' => 'بسته',
                'is_open' => false,
                'is_break' => false,
                'is_closed' => true,
                'message' => 'امروز ساعت کاری ثبت نشده است',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Closed Day
        |--------------------------------------------------------------------------
        */

        if ($workingHour->is_closed) {
            return [
                'status' => 'closed',
                'label' => 'بسته',
                'is_open' => false,
                'is_break' => false,
                'is_closed' => true,
                'message' => 'امروز سالن تعطیل است',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Missing Working Hours
        |--------------------------------------------------------------------------
        */

        if (
            ! $workingHour->start_time ||
            ! $workingHour->end_time
        ) {
            return [
                'status' => 'closed',
                'label' => 'بسته',
                'is_open' => false,
                'is_break' => false,
                'is_closed' => true,
                'message' => 'ساعت کاری کامل ثبت نشده است',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Today's Working Time
        |--------------------------------------------------------------------------
        */

        $start = Carbon::today()
            ->setTimeFromTimeString($workingHour->start_time);

        $end = Carbon::today()
            ->setTimeFromTimeString($workingHour->end_time);

        /*
        |--------------------------------------------------------------------------
        | Break
        |--------------------------------------------------------------------------
        */

        if (
            $workingHour->break_start &&
            $workingHour->break_end
        ) {
            $breakStart = Carbon::today()
                ->setTimeFromTimeString(
                    $workingHour->break_start
                );

            $breakEnd = Carbon::today()
                ->setTimeFromTimeString(
                    $workingHour->break_end
                );

            if ($now->betweenIncluded($breakStart, $breakEnd)) {
                return [
                    'status' => 'break',
                    'label' => 'استراحت',
                    'is_open' => false,
                    'is_break' => true,
                    'is_closed' => false,
                    'message' => 'سالن در زمان استراحت است',
                    'start_time' => $workingHour->start_time,
                    'end_time' => $workingHour->end_time,
                    'break_start' => $workingHour->break_start,
                    'break_end' => $workingHour->break_end,
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Before Opening
        |--------------------------------------------------------------------------
        */

        if ($now->lt($start)) {
            return [
                'status' => 'closed',
                'label' => 'بسته',
                'is_open' => false,
                'is_break' => false,
                'is_closed' => true,
                'message' => 'سالن هنوز باز نشده است',
                'start_time' => $workingHour->start_time,
                'end_time' => $workingHour->end_time,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | After Closing
        |--------------------------------------------------------------------------
        */

        if ($now->gt($end)) {
            return [
                'status' => 'closed',
                'label' => 'بسته',
                'is_open' => false,
                'is_break' => false,
                'is_closed' => true,
                'message' => 'ساعت کاری سالن به پایان رسیده است',
                'start_time' => $workingHour->start_time,
                'end_time' => $workingHour->end_time,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Open
        |--------------------------------------------------------------------------
        */

        return [
            'status' => 'open',
            'label' => 'باز',
            'is_open' => true,
            'is_break' => false,
            'is_closed' => false,
            'message' => 'سالن در حال فعالیت است',
            'start_time' => $workingHour->start_time,
            'end_time' => $workingHour->end_time,
        ];
    }
}
