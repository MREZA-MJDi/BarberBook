@php

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


    $slots =
        is_array($availableSlots ?? null)
            ? $availableSlots
            : [];


    $selectedTime =
        $selectedTime
        ?? request('booking_time');


    if ($selectedTime) {

        if (
            $selectedTime
            instanceof \DateTimeInterface
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


    $selectedDateValue =
        $jalaliDate
        ?? request('date');


    $serviceId =
        $selectedService?->id
        ?? request('service_id');


    $salonSlug =
        $salon->slug;

@endphp


<div>

    {{-- Header --}}

    <div class="flex items-start justify-between gap-4">

        <div>

            <p class="text-[11px] font-black text-primary">
                مرحله ۲
            </p>

            <h3 class="mt-1 text-lg font-black text-text">
                انتخاب ساعت
            </h3>

            <p class="mt-1 text-xs leading-6 text-muted">
                فقط زمان‌های آزاد این سالن نمایش داده می‌شوند.
            </p>

        </div>


        @if($selectedService)

            <div
                class="
                    shrink-0
                    rounded-full
                    bg-primary/10
                    px-3
                    py-1.5
                    text-xs
                    font-black
                    text-primary
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
                mt-6
                rounded-2xl
                border
                border-dashed
                border-border
                bg-background
                p-8
                text-center
            "
        >

            <div class="text-3xl">
                ✂
            </div>

            <p class="mt-4 font-black text-text">
                ابتدا یک خدمت انتخاب کنید.
            </p>

            <p class="mt-2 text-sm leading-6 text-muted">
                برای نمایش ساعت‌های آزاد، ابتدا خدمت موردنظرتان را انتخاب کنید.
            </p>

        </div>


        {{-- =========================================================
            No Date
        ========================================================== --}}

    @elseif(!$selectedDateValue)

        <div
            class="
                mt-6
                rounded-2xl
                border
                border-dashed
                border-border
                bg-background
                p-8
                text-center
            "
        >

            <div class="text-3xl">
                📅
            </div>

            <p class="mt-4 font-black text-text">
                ابتدا تاریخ را انتخاب کنید.
            </p>

            <p class="mt-2 text-sm leading-6 text-muted">
                بعد از انتخاب تاریخ، ساعت‌های آزاد نمایش داده می‌شوند.
            </p>

        </div>


        {{-- =========================================================
            No Slots
        ========================================================== --}}

    @elseif(empty($slots))

        <div
            class="
                mt-6
                rounded-2xl
                border
                border-dashed
                border-border
                bg-background
                p-8
                text-center
            "
        >

            <div class="text-3xl">
                🕒
            </div>

            <p class="mt-4 font-black text-text">
                زمانی برای این تاریخ موجود نیست.
            </p>

            <p class="mt-2 text-sm leading-6 text-muted">
                ممکن است سالن در این روز تعطیل باشد یا زمان‌های آزاد تکمیل شده باشند.
            </p>

        </div>


        {{-- =========================================================
            Available Slots
        ========================================================== --}}

    @else

        <div
            class="
                mt-6
                grid
                grid-cols-3
                gap-3
                sm:grid-cols-4
            "
        >

            @foreach($slots as $time)

                @php

                    if (
                        $time
                        instanceof \DateTimeInterface
                    ) {

                        $timeValue =
                            $time->format('H:i');

                    } else {

                        $timeValue =
                            substr(
                                (string) $time,
                                0,
                                5
                            );

                    }


                    $isActive =
                        $selectedTime === $timeValue;


                    $timeUrl = route(
                        'salon.public',
                        array_filter([

                            'salon' =>
                                $salonSlug,

                            'date' =>
                                $selectedDateValue,

                            'service_id' =>
                                $serviceId,

                            'booking_time' =>
                                $timeValue,

                        ], fn ($value) =>
                            $value !== null
                            && $value !== ''
                        )
                    );

                @endphp


                <a
                    href="{{ $timeUrl }}#booking"
                    aria-label="انتخاب ساعت {{ $timeValue }}"
                    @class([

                        'flex items-center justify-center rounded-2xl border py-4 text-center text-sm font-black transition-all duration-200',

                        'scale-[1.03] border-primary bg-primary text-white shadow-lg shadow-primary/20'
                            => $isActive,

                        'border-border bg-background text-text hover:-translate-y-1 hover:border-primary hover:bg-primary/5'
                            => !$isActive,

                    ])
                >

                    {{ $toPersianDigits($timeValue) }}

                </a>

            @endforeach

        </div>


        {{-- Selected Time --}}

        @if($selectedTime)

            <div
                class="
                    mt-6
                    flex
                    items-center
                    justify-between
                    gap-4
                    rounded-2xl
                    border
                    border-primary/20
                    bg-primary/5
                    px-4
                    py-4
                "
            >

                <div>

                    <p class="text-xs font-bold text-muted">
                        ساعت انتخاب‌شده
                    </p>

                    <p class="mt-1 text-sm font-black text-text">
                        این زمان برای رزرو شما انتخاب شده است.
                    </p>

                </div>


                <div
                    class="
                        shrink-0
                        rounded-xl
                        bg-primary
                        px-4
                        py-2
                        text-sm
                        font-black
                        text-white
                    "
                >

                    {{ $toPersianDigits($selectedTime) }}

                </div>

            </div>

        @endif


        @if($selectedService)

            <div class="mt-4 text-xs text-muted">

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
