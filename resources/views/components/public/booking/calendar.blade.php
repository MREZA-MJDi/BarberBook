{{-- resources/views/components/public/booking/calendar.blade.php --}}

@php

    use Morilog\Jalali\Jalalian;

    /*
    |--------------------------------------------------------------------------
    | Resolve Selected Jalali Date
    |--------------------------------------------------------------------------
    */

    $selectedJalaliDate =
        $jalaliDate
        ?? request('date')
        ?? (
            isset($selectedDate) &&
            $selectedDate instanceof \Carbon\Carbon
                ? Jalalian::fromCarbon($selectedDate)->format('Y/m/d')
                : Jalalian::now()->format('Y/m/d')
        );


    /*
    |--------------------------------------------------------------------------
    | Normalize Jalali Date
    |--------------------------------------------------------------------------
    */

    try {

        $selectedJalalian =
            Jalalian::fromFormat(
                'Y/m/d',
                str_replace('-', '/', $selectedJalaliDate)
            );

    } catch (\Throwable $e) {

        $selectedJalalian =
            Jalalian::now();

        $selectedJalaliDate =
            $selectedJalalian->format('Y/m/d');

    }


    /*
    |--------------------------------------------------------------------------
    | Current Calendar Month
    |--------------------------------------------------------------------------
    |
    | The selected date is the source of truth.
    |
    */

    $currentYear =
        (int) $selectedJalalian->format('Y');

    $currentMonth =
        (int) $selectedJalalian->format('m');


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
    | Current Month Start
    |--------------------------------------------------------------------------
    */

    $monthStart =
        Jalalian::fromFormat(
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
    |
    | Morilog/Jalali uses:
    |
    | 0 = Saturday
    | 1 = Sunday
    | 2 = Monday
    | 3 = Tuesday
    | 4 = Wednesday
    | 5 = Thursday
    | 6 = Friday
    |
    | Which exactly matches our Persian calendar grid.
    |
    */

    $firstDayOfWeek =
        (int) $monthStart->getDayOfWeek();


    /*
    |--------------------------------------------------------------------------
    | Previous / Next Month
    |--------------------------------------------------------------------------
    */

    $previousMonth =
        $monthStart
            ->subMonths(1)
            ->format('Y/m/d');


    $nextMonth =
        $monthStart
            ->addMonths(1)
            ->format('Y/m/d');


    /*
    |--------------------------------------------------------------------------
    | Selected Service
    |--------------------------------------------------------------------------
    */

    $serviceId =
        $selectedService?->id
        ?? request('service_id');


    /*
    |--------------------------------------------------------------------------
    | Selected Booking Time
    |--------------------------------------------------------------------------
    */

    $bookingTime =
        $selectedTime
        ?? request('booking_time');


    /*
    |--------------------------------------------------------------------------
    | Salon Slug
    |--------------------------------------------------------------------------
    */

    $salonSlug =
        $salon->slug;


    /*
    |--------------------------------------------------------------------------
    | Calendar URL
    |--------------------------------------------------------------------------
    */

    $calendarUrl = function ($date) use (
        $salonSlug,
        $serviceId,
        $bookingTime
    ) {

        return route(
            'salon.public',
            array_filter(
                [

                    'salon' =>
                        $salonSlug,

                    'date' =>
                        $date,

                    'service_id' =>
                        $serviceId,

                    'booking_time' =>
                        $bookingTime,

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


    /*
    |--------------------------------------------------------------------------
    | Selected Date Object
    |--------------------------------------------------------------------------
    */

    $selectedDateObject =
        $selectedJalalian;


@endphp


<section
    class="
        rounded-[30px]
        border
        border-border
        bg-surface
        p-4
        sm:p-6
        lg:p-7
    "
    aria-label="تقویم انتخاب تاریخ"
>


    {{-- =========================================================
        Header
    ========================================================== --}}

    <div
        class="
            flex
            items-center
            justify-between
            gap-2
            sm:gap-3
        "
    >

        {{-- Previous Month --}}

        <a
            href="{{ $calendarUrl($previousMonth) }}#booking"
            aria-label="ماه قبل"
            class="
                flex
                h-10
                w-10
                shrink-0
                items-center
                justify-center
                rounded-xl
                border
                border-border
                bg-background
                text-lg
                font-black
                text-muted
                transition
                hover:border-primary
                hover:text-primary
                active:scale-95
            "
        >
            →
        </a>


        {{-- Current Month --}}

        <div class="min-w-0 text-center">

            <p
                class="
                    text-base
                    font-black
                    text-text
                    sm:text-lg
                "
            >

                {{ $monthNames[$currentMonth] }}

                {{ $toPersianDigits($currentYear) }}

            </p>

            <p
                class="
                    mt-1
                    text-[10px]
                    font-bold
                    text-muted
                    sm:text-xs
                "
            >
                تاریخ رزرو را انتخاب کنید
            </p>

        </div>


        {{-- Next Month --}}

        <a
            href="{{ $calendarUrl($nextMonth) }}#booking"
            aria-label="ماه بعد"
            class="
                flex
                h-10
                w-10
                shrink-0
                items-center
                justify-center
                rounded-xl
                border
                border-border
                bg-background
                text-lg
                font-black
                text-muted
                transition
                hover:border-primary
                hover:text-primary
                active:scale-95
            "
        >
            ←
        </a>

    </div>


    {{-- =========================================================
        Week Days
    ========================================================== --}}

    <div
        class="
            mt-5
            grid
            grid-cols-7
            gap-1
            sm:mt-6
            sm:gap-2
        "
    >

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
                class="
                    py-2
                    text-center
                    text-[9px]
                    font-black
                    text-muted
                    sm:text-[11px]
                    sm:text-xs
                "
            >
                {{ $day }}
            </div>

        @endforeach

    </div>


    {{-- =========================================================
        Days
    ========================================================== --}}

    <div
        class="
            grid
            grid-cols-7
            gap-1
            sm:gap-2
        "
    >

        {{-- Empty Cells --}}

        @for(
            $i = 0;
            $i < $firstDayOfWeek;
            $i++
        )

            <div
                class="
                    min-h-10
                    sm:min-h-11
                "
                aria-hidden="true"
            ></div>

        @endfor


        {{-- Month Days --}}

        @for(
            $day = 1;
            $day <= $daysInMonth;
            $day++
        )

            @php

                $dayDate =
                    Jalalian::fromFormat(
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


                /*
                |--------------------------------------------------------------------------
                | Past Date
                |--------------------------------------------------------------------------
                */

                $isPast =
                    $dayDate->getTimestamp()
                    <
                    $today->getTimestamp();

            @endphp


            @if($isPast)

                {{-- Past Date --}}

                <div
                    class="
                        flex
                        min-h-10
                        items-center
                        justify-center
                        rounded-xl
                        text-xs
                        font-bold
                        text-muted/30
                        sm:min-h-11
                        sm:text-sm
                    "
                    aria-disabled="true"
                >

                    {{ $toPersianDigits($day) }}

                </div>

            @else

                {{-- Available Date --}}

                <a
                    href="{{ $calendarUrl($dayValue) }}#booking"
                    aria-label="انتخاب تاریخ {{ $dayValue }}"
                    @class([

                        'group relative flex min-h-10 items-center justify-center rounded-xl border text-xs font-black transition-all duration-200 active:scale-95 sm:min-h-11 sm:text-sm',

                        'border-primary bg-primary text-white shadow-lg shadow-primary/20'
                            => $isSelected,

                        'border-transparent bg-background text-text hover:border-primary/50 hover:bg-primary/5'
                            => !$isSelected,

                    ])
                >

                    {{ $toPersianDigits($day) }}


                    @if($isToday && !$isSelected)

                        <span
                            class="
                                absolute
                                bottom-1
                                h-1
                                w-1
                                rounded-full
                                bg-primary
                                sm:bottom-1.5
                            "
                            aria-hidden="true"
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
        class="
            mt-5
            rounded-2xl
            border
            border-primary/20
            bg-primary/5
            px-3
            py-3.5
            sm:mt-6
            sm:px-4
            sm:py-4
        "
    >

        <div
            class="
                flex
                items-center
                justify-between
                gap-3
            "
        >

            <div class="min-w-0">

                <p class="text-[10px] font-bold text-muted sm:text-xs">
                    تاریخ انتخاب‌شده
                </p>

                <p
                    class="
                        mt-1
                        text-xs
                        font-black
                        text-text
                        sm:text-sm
                    "
                >
                    {{ $toPersianDigits($selectedJalaliDate) }}
                </p>

            </div>


            <div
                class="
                    flex
                    h-9
                    w-9
                    shrink-0
                    items-center
                    justify-center
                    rounded-xl
                    bg-primary/10
                    text-base
                    sm:h-10
                    sm:w-10
                    sm:text-lg
                "
                aria-hidden="true"
            >
                📅
            </div>

        </div>

    </div>


    {{-- =========================================================
        Today Button
    ========================================================== --}}

    @if($selectedJalaliDate !== $todayJalali)

        <a
            href="{{ $calendarUrl($todayJalali) }}#booking"
            class="
                mt-3
                inline-flex
                w-full
                items-center
                justify-center
                rounded-xl
                border
                border-border
                px-4
                py-3
                text-xs
                font-black
                text-muted
                transition
                hover:border-primary
                hover:text-primary
                active:scale-[0.99]
                sm:mt-4
                sm:text-sm
            "
        >
            برو به امروز
        </a>

    @endif


</section>
