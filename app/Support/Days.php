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

}
