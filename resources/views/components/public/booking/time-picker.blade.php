{{-- resources/views/components/public/booking/time-picker.blade.php --}}

@php

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
    | Available Slots
    |--------------------------------------------------------------------------
    */

    $slots =
        is_array($availableSlots ?? null)
            ? $availableSlots
            : [];


    /*
    |--------------------------------------------------------------------------
    | Selected Time
    |--------------------------------------------------------------------------
    */

    $selectedTime =
        $selectedTime
        ?? request('booking_time');


    if ($selectedTime) {

        if (
            $selectedTime instanceof \DateTimeInterface
        ) {

            $selectedTime =
                $selectedTime->format('H:i');

        } else {

            $selectedTime =
                substr(
                    (string) $selectedTime,
                    0,
                    5
                );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Selected Date
    |--------------------------------------------------------------------------
    */

    $selectedDateValue =
        $jalaliDate
        ?? request('date');


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
    | Salon
    |--------------------------------------------------------------------------
    */

    $salonSlug =
        $salon->slug;


    /*
    |--------------------------------------------------------------------------
    | Time URL Builder
    |--------------------------------------------------------------------------
    */

    $timeUrl = function ($timeValue) use (
        $salonSlug,
        $selectedDateValue,
        $serviceId
    ) {

        return route(
            'salon.public',
            array_filter(
                [

                    'salon' =>
                        $salonSlug,

                    'date' =>
                        $selectedDateValue,

                    'service_id' =>
                        $serviceId,

                    'booking_time' =>
                        $timeValue,

                ],
                fn ($value) =>
                    $value !== null
                    && $value !== ''
            )
        );

    };

@endphp


<div>

    {{-- =========================================================
        Header
    ========================================================== --}}

    <div
        class="
            flex
            items-start
            justify-between
            gap-3
        "
    >

        <div class="min-w-0">

            <p class="text-[10px] font-black text-primary sm:text-[11px]">
                مرحله ۳
            </p>

            <h3
                class="
                    mt-1
                    text-base
                    font-black
                    text-text
                    sm:text-lg
                "
            >
                انتخاب ساعت
            </h3>

            <p
                class="
                    mt-1
                    text-[11px]
                    leading-5
                    text-muted
                    sm:text-xs
                    sm:leading-6
                "
            >
                فقط زمان‌های آزاد این سالن نمایش داده می‌شوند.
            </p>

        </div>


        @if($selectedService)

            <div
                class="
                    shrink-0
                    rounded-full
                    bg-primary/10
                    px-2.5
                    py-1.5
                    text-[10px]
                    font-black
                    text-primary
                    sm:px-3
                    sm:text-xs
                "
            >

                {{ $toPersianDigits(
                    $selectedService->duration
                ) }}

                دقیقه

            </div>

        @endif

    </div>


    {{-- =========================================================
        No Service
    ========================================================== --}}

    @if(!$selectedService)

        <div
            class="
                mt-5
                rounded-2xl
                border
                border-dashed
                border-border
                bg-background
                p-6
                text-center
                sm:mt-6
                sm:p-8
            "
        >

            <div class="text-2xl sm:text-3xl">
                ✂
            </div>

            <p
                class="
                    mt-3
                    text-sm
                    font-black
                    text-text
                    sm:mt-4
                "
            >
                ابتدا یک خدمت انتخاب کنید.
            </p>

            <p
                class="
                    mt-1.5
                    text-xs
                    leading-5
                    text-muted
                    sm:mt-2
                    sm:text-sm
                    sm:leading-6
                "
            >
                برای نمایش ساعت‌های آزاد، ابتدا خدمت موردنظرتان را انتخاب کنید.
            </p>

        </div>


        {{-- =========================================================
            No Date
        ========================================================== --}}

    @elseif(!$selectedDateValue)

        <div
            class="
                mt-5
                rounded-2xl
                border
                border-dashed
                border-border
                bg-background
                p-6
                text-center
                sm:mt-6
                sm:p-8
            "
        >

            <div class="text-2xl sm:text-3xl">
                📅
            </div>

            <p
                class="
                    mt-3
                    text-sm
                    font-black
                    text-text
                    sm:mt-4
                "
            >
                ابتدا تاریخ را انتخاب کنید.
            </p>

            <p
                class="
                    mt-1.5
                    text-xs
                    leading-5
                    text-muted
                    sm:mt-2
                    sm:text-sm
                    sm:leading-6
                "
            >
                بعد از انتخاب تاریخ، ساعت‌های آزاد نمایش داده می‌شوند.
            </p>

        </div>


        {{-- =========================================================
            No Slots
        ========================================================== --}}

    @elseif(empty($slots))

        <div
            class="
                mt-5
                rounded-2xl
                border
                border-dashed
                border-border
                bg-background
                p-6
                text-center
                sm:mt-6
                sm:p-8
            "
        >

            <div class="text-2xl sm:text-3xl">
                🕒
            </div>

            <p
                class="
                    mt-3
                    text-sm
                    font-black
                    text-text
                    sm:mt-4
                "
            >
                زمانی برای این تاریخ موجود نیست.
            </p>

            <p
                class="
                    mt-1.5
                    text-xs
                    leading-5
                    text-muted
                    sm:mt-2
                    sm:text-sm
                    sm:leading-6
                "
            >
                ممکن است سالن در این روز تعطیل باشد یا زمان‌های آزاد تکمیل شده باشند.
            </p>

        </div>


        {{-- =========================================================
            Available Slots
        ========================================================== --}}

    @else

        <div
            class="
                mt-5
                grid
                grid-cols-2
                gap-2.5
                sm:mt-6
                sm:grid-cols-3
                sm:gap-3
                lg:grid-cols-4
            "
        >

            @foreach($slots as $time)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | Normalize Time
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $time instanceof \DateTimeInterface
                    ) {

                        $timeValue =
                            $time->format('H:i');

                    } else {

                        $timeValue =
                            substr(
                                trim((string) $time),
                                0,
                                5
                            );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Selected State
                    |--------------------------------------------------------------------------
                    */

                    $isActive =
                        $selectedTime === $timeValue;


                    /*
                    |--------------------------------------------------------------------------
                    | URL
                    |--------------------------------------------------------------------------
                    */

                    $slotUrl =
                        $timeUrl($timeValue);

                @endphp


                <a
                    href="{{ $slotUrl }}#booking"
                    aria-label="انتخاب ساعت {{ $timeValue }}"
                    @class([

                        'flex min-h-12 items-center justify-center rounded-xl border px-3 py-3 text-sm font-black transition-all duration-200 active:scale-95 sm:min-h-13 sm:rounded-2xl sm:py-4',

                        'border-primary bg-primary text-white shadow-lg shadow-primary/20'
                            => $isActive,

                        'border-border bg-background text-text hover:-translate-y-0.5 hover:border-primary hover:bg-primary/5'
                            => !$isActive,

                    ])
                >

                    <span dir="ltr">
                        {{ $toPersianDigits($timeValue) }}
                    </span>

                </a>

            @endforeach

        </div>


        {{-- =====================================================
            Selected Time
        ====================================================== --}}

        @if($selectedTime)

            <div
                class="
                    mt-5
                    flex
                    items-center
                    justify-between
                    gap-3
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

                <div class="min-w-0">

                    <p
                        class="
                            text-[10px]
                            font-bold
                            text-muted
                            sm:text-xs
                        "
                    >
                        ساعت انتخاب‌شده
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
                        این زمان برای رزرو شما انتخاب شده است.
                    </p>

                </div>


                <div
                    dir="ltr"
                    class="
                        shrink-0
                        rounded-xl
                        bg-primary
                        px-3
                        py-2
                        text-xs
                        font-black
                        text-white
                        sm:px-4
                        sm:text-sm
                    "
                >

                    {{ $toPersianDigits($selectedTime) }}

                </div>

            </div>

        @endif


        {{-- =====================================================
            Service Duration
        ====================================================== --}}

        @if($selectedService)

            <div
                class="
                    mt-3
                    text-[11px]
                    text-muted
                    sm:mt-4
                    sm:text-xs
                "
            >

                مدت این خدمت:

                <strong class="font-black text-text">

                    {{ $toPersianDigits(
                        $selectedService->duration
                    ) }}

                    دقیقه

                </strong>

            </div>

        @endif

    @endif

</div>
