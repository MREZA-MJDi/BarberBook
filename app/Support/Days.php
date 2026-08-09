<?php

namespace App\Support;

class Days
{
    /**
     * Get all week days.
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
     * Get day name by number.
     */
    public static function name(int $day): string
    {
        return self::all()[$day] ?? '';
    }

    /**
     * Get today's day number based on project convention.
     *
     * Project convention:
     * 0 = شنبه
     * 1 = یکشنبه
     * 2 = دوشنبه
     * 3 = سه‌شنبه
     * 4 = چهارشنبه
     * 5 = پنجشنبه
     * 6 = جمعه
     */
    public static function today(): int
    {
        return match (now()->dayOfWeek) {
            0 => 6, // Sunday → جمعه
            1 => 0, // Monday → شنبه
            2 => 1, // Tuesday → یکشنبه
            3 => 2, // Wednesday → دوشنبه
            4 => 3, // Thursday → سه‌شنبه
            5 => 4, // Friday → چهارشنبه
            6 => 5, // Saturday → پنجشنبه
        };
    }
}
