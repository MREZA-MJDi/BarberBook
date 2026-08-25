<?php

namespace App\Support;

use Carbon\CarbonInterface;

class Days
{
    /**
     * Get all week days.
     *
     * Project convention:
     *
     * 0 = شنبه
     * 1 = یکشنبه
     * 2 = دوشنبه
     * 3 = سه‌شنبه
     * 4 = چهارشنبه
     * 5 = پنجشنبه
     * 6 = جمعه
     */
    public static function all(): array
    {
        return [
            0 => 'شنبه',
            1 => 'یکشنبه',
            2 => 'دوشنبه',
            3 => 'سه‌شنبه',
            4 => 'چهارشنبه',
            5 => 'پنجشنبه',
            6 => 'جمعه',
        ];
    }

    /**
     * Get day name by project day number.
     */
    public static function name(int $day): string
    {
        return self::all()[$day] ?? '';
    }

    /**
     * Convert Carbon dayOfWeek to project day number.
     *
     * Carbon:
     *
     * 0 = Sunday
     * 1 = Monday
     * 2 = Tuesday
     * 3 = Wednesday
     * 4 = Thursday
     * 5 = Friday
     * 6 = Saturday
     *
     * Project:
     *
     * 0 = Saturday
     * 1 = Sunday
     * 2 = Monday
     * 3 = Tuesday
     * 4 = Wednesday
     * 5 = Thursday
     * 6 = Friday
     */
    public static function fromCarbon(
        CarbonInterface $date
    ): int {
        return match ($date->dayOfWeek) {

            0 => 1, // Sunday → یکشنبه

            1 => 2, // Monday → دوشنبه

            2 => 3, // Tuesday → سه‌شنبه

            3 => 4, // Wednesday → چهارشنبه

            4 => 5, // Thursday → پنجشنبه

            5 => 6, // Friday → جمعه

            6 => 0, // Saturday → شنبه

        };
    }

    /**
     * Get today's project day number.
     */
    public static function today(): int
    {
        return self::fromCarbon(now());
    }

    /**
     * Check whether a given project day is valid.
     */
    public static function exists(int $day): bool
    {
        return array_key_exists(
            $day,
            self::all()
        );
    }
}
