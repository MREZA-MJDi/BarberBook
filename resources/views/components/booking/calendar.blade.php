{{-- resources/views/components/booking/calendar.blade.php --}}

@php

    use Morilog\Jalali\Jalalian;

    /*
    |--------------------------------------------------------------------------
    | Selected Date
    |--------------------------------------------------------------------------
    */

    $currentDate =
        isset($selectedDate)
        && $selectedDate instanceof \Carbon\Carbon
            ? Jalalian::fromCarbon($selectedDate)
            : Jalalian::now();

    /*
    |--------------------------------------------------------------------------
    | Selected Jalali Date
    |--------------------------------------------------------------------------
    */

    $selectedJalaliDate =
        isset($jalaliDate) && $jalaliDate
            ? $jalaliDate
            : $currentDate->format('Y/m/d');

    /*
    |--------------------------------------------------------------------------
    | Current Year / Month
    |--------------------------------------------------------------------------
    */

    $currentYear =
        (int) $currentDate->format('Y');

    $currentMonth =
        (int) $currentDate->format('m');

    /*
    |--------------------------------------------------------------------------
    | Month Names
    |--------------------------------------------------------------------------
    */

    $monthNames = [
        1  => 'فروردین',
        2  => 'اردیبهشت',
        3  => 'خرداد',
        4  => 'تیر',
        5  => 'مرداد',
        6  => 'شهریور',
        7  => 'مهر',
        8  => 'آبان',
        9  => 'آذر',
        10 => 'دی',
        11 => 'بهمن',
        12 => 'اسفند',
    ];

    /*
    |--------------------------------------------------------------------------
    | Persian Digits
    |--------------------------------------------------------------------------
    */

    $toPersianDigits = function ($value) {
        return strtr((string) $value, [
            '0' => '۰',
            '1' => '۱',
            '2' => '۲',
            '3' => '۳',
            '4' => '۴',
            '5' => '۵',
            '6' => '۶',
            '7' => '۷',
            '8' => '۸',
            '9' => '۹',
        ]);
    };

    /*
    |--------------------------------------------------------------------------
    | Month Start
    |--------------------------------------------------------------------------
    */

    $monthStart = Jalalian::fromFormat(
        'Y/m/d',
        sprintf(
            '%04d/%02d/01',
            $currentYear,
            $currentMonth
        )
    );

    /*
    |--------------------------------------------------------------------------
    | Days In Month
    |--------------------------------------------------------------------------
    */

    $daysInMonth =
        $monthStart->getMonthDays();

    /*
    |--------------------------------------------------------------------------
    | First Day Of Week
    |--------------------------------------------------------------------------
    */

    $firstDayOfWeek =
        $monthStart->getDayOfWeek();

    /*
    |--------------------------------------------------------------------------
    | Previous / Next Month
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | Never mutate $monthStart.
    |
    */

    $previousMonthStart = Jalalian::fromFormat(
        'Y/m/d',
        sprintf(
            '%04d/%02d/01',
            $currentYear,
            $currentMonth
        )
    );

    $nextMonthStart = Jalalian::fromFormat(
        'Y/m/d',
        sprintf(
            '%04d/%02d/01',
            $currentYear,
            $currentMonth
        )
    );

    $previousMonth =
        $previousMonthStart
            ->subMonths(1)
            ->format('Y/m/d');

    $nextMonth =
        $nextMonthStart
            ->addMonths(1)
            ->format('Y/m/d');

    /*
    |--------------------------------------------------------------------------
    | Service
    |--------------------------------------------------------------------------
    */

    $serviceId =
        isset($selectedService)
            ? $selectedService?->id
            : request('service_id');

    /*
    |--------------------------------------------------------------------------
    | Selected Time
    |--------------------------------------------------------------------------
    */

    $bookingTime =
        request('booking_time');

    /*
    |--------------------------------------------------------------------------
    | Calendar URL
    |--------------------------------------------------------------------------
    */

    $calendarUrl = function ($date) use (
        $serviceId,
        $bookingTime
    ) {
        return route(
            'bookings.create',
            array_filter(
                [
                    'date' => $date,
                    'service_id' => $serviceId,
                    'booking_time' => $bookingTime,
                ],
                function ($value) {
                    return $value !== null
                        && $value !== '';
                }
            )
        );
    };

    /*
    |--------------------------------------------------------------------------
    | Today
    |--------------------------------------------------------------------------
    */

    $today =
        Jalalian::now();

    $todayJalali =
        $today->format('Y/m/d');

@endphp


{{-- =========================================================
    Calendar Header
========================================================== --}}

<div class="flex items-center justify-between gap-3">

    {{-- Previous Month --}}

    <a
        href="{{ $calendarUrl($previousMonth) }}"
        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-border bg-surface text-lg font-black text-muted transition hover:border-primary hover:text-primary"
        aria-label="ماه قبل"
    >
        →
    </a>


    {{-- Current Month --}}

    <div class="text-center">

        <p class="text-lg font-black text-text">
            {{ $monthNames[$currentMonth] }}
            {{ $toPersianDigits($currentYear) }}
        </p>

        <p class="mt-1 text-xs font-bold text-muted">
            تاریخ رزرو را انتخاب کنید
        </p>

    </div>


    {{-- Next Month --}}

    <a
        href="{{ $calendarUrl($nextMonth) }}"
        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-border bg-surface text-lg font-black text-muted transition hover:border-primary hover:text-primary"
        aria-label="ماه بعد"
    >
        ←
    </a>

</div>


{{-- =========================================================
    Week Days
========================================================== --}}

<div class="mt-6 grid grid-cols-7 gap-2">

    @foreach([
        'شنبه',
        'یکشنبه',
        'دوشنبه',
        'سه‌شنبه',
        'چهارشنبه',
        'پنجشنبه',
        'جمعه',
    ] as $day)

        <div
            class="py-2 text-center text-xs font-black text-muted"
        >
            {{ $day }}
        </div>

    @endforeach

</div>


{{-- =========================================================
    Days
========================================================== --}}

<div class="grid grid-cols-7 gap-2">

    {{-- Empty cells --}}

    @for(
        $i = 0;
        $i < $firstDayOfWeek;
        $i++
    )

        <div class="aspect-square"></div>

    @endfor


    {{-- Month Days --}}

    @for(
        $day = 1;
        $day <= $daysInMonth;
        $day++
    )

        @php

            $dayDate = Jalalian::fromFormat(
                'Y/m/d',
                sprintf(
                    '%04d/%02d/%02d',
                    $currentYear,
                    $currentMonth,
                    $day
                )
            );

            $dayValue =
                $dayDate->format('Y/m/d');

            $isSelected =
                $dayValue === $selectedJalaliDate;

            $isToday =
                $dayValue === $todayJalali;

            $isPast =
                $dayDate->getTimestamp()
                <
                $today->getTimestamp();

        @endphp


        @if($isPast)

            <div
                class="flex aspect-square items-center justify-center rounded-xl text-sm font-bold text-muted/30"
            >
                {{ $toPersianDigits($day) }}
            </div>

        @else

            <a
                href="{{ $calendarUrl($dayValue) }}"
                class="
                    group
                    relative
                    flex
                    aspect-square
                    items-center
                    justify-center
                    rounded-xl
                    border
                    text-sm
                    font-black
                    transition-all
                    duration-200

                    {{
                        $isSelected
                            ? 'border-primary bg-primary text-white shadow-lg shadow-primary/20'
                            : 'border-transparent bg-surface text-text hover:border-primary/50 hover:bg-primary/5'
                    }}
                    "
            >

                {{ $toPersianDigits($day) }}

                @if($isToday && !$isSelected)

                    <span
                        class="absolute bottom-1 h-1 w-1 rounded-full bg-primary"
                    ></span>

                @endif

            </a>

        @endif

    @endfor

</div>


{{-- =========================================================
    Selected Date
========================================================== --}}

<div
    class="mt-6 rounded-2xl border border-primary/20 bg-primary/5 px-4 py-4"
>

    <div class="flex items-center justify-between gap-4">

        <div>

            <p class="text-xs font-bold text-muted">
                تاریخ انتخاب‌شده
            </p>

            <p class="mt-1 text-sm font-black text-text">
                {{ $toPersianDigits($selectedJalaliDate) }}
            </p>

        </div>

        <div
            class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-lg"
        >
            📅
        </div>

    </div>

</div>


{{-- =========================================================
    Quick Today
========================================================== --}}

@if($selectedJalaliDate !== $todayJalali)

    <a
        href="{{ $calendarUrl($todayJalali) }}"
        class="mt-4 inline-flex w-full items-center justify-center rounded-xl border border-border px-4 py-3 text-sm font-black text-muted transition hover:border-primary hover:text-primary"
    >
        برو به امروز
    </a>

@endif
