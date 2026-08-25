{{-- resources/views/components/public/booking/booking-summary.blade.php --}}

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
    | Selected Service
    |--------------------------------------------------------------------------
    */

    $service =
        $selectedService ?? null;


    /*
    |--------------------------------------------------------------------------
    | Selected Date
    |--------------------------------------------------------------------------
    |
    | The parent booking component already sends:
    |
    | $selectedDate   => Carbon date
    | $jalaliDate     => Jalali string
    |
    */

    $date =
        $jalaliDate
        ?? request('date');


    /*
    |--------------------------------------------------------------------------
    | Normalize Date
    |--------------------------------------------------------------------------
    */

    if ($date instanceof \DateTimeInterface) {

        $date =
            \Morilog\Jalali\Jalalian::fromDateTime($date)
                ->format('Y/m/d');

    }

    $date =
        $date
        ? (string) $date
        : null;


    /*
    |--------------------------------------------------------------------------
    | Selected Time
    |--------------------------------------------------------------------------
    */

    $time =
        $selectedTime
        ?? request('booking_time');


    /*
    |--------------------------------------------------------------------------
    | Normalize Time
    |--------------------------------------------------------------------------
    */

    if ($time instanceof \DateTimeInterface) {

        $time =
            $time->format('H:i');

    } elseif ($time) {

        $time =
            substr(
                (string) $time,
                0,
                5
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Customer Data
    |--------------------------------------------------------------------------
    */

    $customerName =
        old(
            'customer_name',
            request('customer_name')
        );


    $customerPhone =
        old(
            'customer_phone',
            request('customer_phone')
        );


    $customerNote =
        old(
            'customer_note',
            request('customer_note')
        );


    /*
    |--------------------------------------------------------------------------
    | Service Data
    |--------------------------------------------------------------------------
    */

    $price =
        $service?->price ?? 0;


    $duration =
        $service?->duration;


    /*
    |--------------------------------------------------------------------------
    | Ready State
    |--------------------------------------------------------------------------
    */

    $isReady =
        (bool) (
            $service
            && $date
            && $time
            && $customerName
            && $customerPhone
        );

@endphp


<div
    class="
        rounded-[30px]
        border
        border-border
        bg-surface
        p-6
        sm:p-8
    "
>

    {{-- ================================================================
        Header
    ================================================================= --}}

    <div
        class="
            flex
            items-start
            justify-between
            gap-4
        "
    >

        <div>

            <span
                class="
                    text-xs
                    font-black
                    text-primary
                "
            >
                مرحله ۵
            </span>


            <h2
                class="
                    mt-2
                    text-xl
                    font-black
                    text-text
                "
            >
                خلاصه رزرو
            </h2>


            <p
                class="
                    mt-2
                    text-sm
                    leading-6
                    text-muted
                "
            >
                اطلاعات رزرو را قبل از ثبت نهایی بررسی کن.
            </p>

        </div>


        {{-- Ready Status --}}

        @if($isReady)

            <span
                class="
                    shrink-0
                    rounded-full
                    bg-emerald-500/10
                    px-3
                    py-1.5
                    text-xs
                    font-black
                    text-emerald-400
                "
            >
                آماده ثبت
            </span>

        @else

            <span
                class="
                    shrink-0
                    rounded-full
                    bg-amber-500/10
                    px-3
                    py-1.5
                    text-xs
                    font-black
                    text-amber-400
                "
            >
                ناقص
            </span>

        @endif

    </div>


    {{-- ================================================================
        Booking Summary
    ================================================================= --}}

    <div class="mt-8 space-y-5">


        {{-- Service --}}

        <div
            class="
                flex
                items-center
                justify-between
                gap-4
            "
        >

            <span
                class="
                    flex
                    items-center
                    gap-2
                    text-sm
                    text-muted
                "
            >

                <x-lucide-scissors
                    class="h-4 w-4"
                />

                خدمت

            </span>


            <strong
                class="
                    max-w-[60%]
                    text-left
                    text-sm
                    font-black
                    text-text
                "
            >

                {{ $service?->name ?? 'انتخاب نشده' }}

            </strong>

        </div>


        {{-- Date --}}

        <div
            class="
                flex
                items-center
                justify-between
                gap-4
            "
        >

            <span
                class="
                    flex
                    items-center
                    gap-2
                    text-sm
                    text-muted
                "
            >

                <x-lucide-calendar-days
                    class="h-4 w-4"
                />

                تاریخ

            </span>


            <strong
                class="
                    text-sm
                    font-black
                    text-text
                "
            >

                @if($date)

                    {{ $toPersianDigits($date) }}

                @else

                    انتخاب نشده

                @endif

            </strong>

        </div>


        {{-- Time --}}

        <div
            class="
                flex
                items-center
                justify-between
                gap-4
            "
        >

            <span
                class="
                    flex
                    items-center
                    gap-2
                    text-sm
                    text-muted
                "
            >

                <x-lucide-clock-3
                    class="h-4 w-4"
                />

                ساعت

            </span>


            <strong
                class="
                    text-sm
                    font-black
                    text-primary
                "
            >

                @if($time)

                    {{ $toPersianDigits($time) }}

                @else

                    انتخاب نشده

                @endif

            </strong>

        </div>


        {{-- Duration --}}

        <div
            class="
                flex
                items-center
                justify-between
                gap-4
            "
        >

            <span
                class="
                    flex
                    items-center
                    gap-2
                    text-sm
                    text-muted
                "
            >

                <x-lucide-timer
                    class="h-4 w-4"
                />

                مدت خدمت

            </span>


            <strong
                class="
                    text-sm
                    font-black
                    text-text
                "
            >

                @if($duration)

                    {{ $toPersianDigits($duration) }}
                    دقیقه

                @else

                    —

                @endif

            </strong>

        </div>


        {{-- Price --}}

        <div
            class="
                border-t
                border-border
                pt-5
            "
        >

            <div
                class="
                    flex
                    items-center
                    justify-between
                    gap-4
                "
            >

                <span
                    class="
                        flex
                        items-center
                        gap-2
                        text-sm
                        text-muted
                    "
                >

                    <x-lucide-wallet
                        class="h-4 w-4"
                    />

                    مبلغ

                </span>


                <strong
                    class="
                        text-2xl
                        font-black
                        text-primary
                    "
                >

                    {{ $toPersianDigits(
                        number_format((float) $price)
                    ) }}

                    <span
                        class="
                            text-sm
                            font-bold
                        "
                    >
                        تومان
                    </span>

                </strong>

            </div>

        </div>

    </div>


    {{-- ================================================================
        Customer Preview
    ================================================================= --}}

    @if(
        $customerName
        || $customerPhone
        || $customerNote
    )

        <div
            class="
                mt-6
                rounded-2xl
                border
                border-border
                bg-background
                p-4
            "
        >

            <div
                class="
                    mb-4
                    flex
                    items-center
                    gap-2
                "
            >

                <x-lucide-user-round
                    class="
                        h-4
                        w-4
                        text-primary
                    "
                />

                <p
                    class="
                        text-xs
                        font-black
                        text-muted
                    "
                >
                    اطلاعات مشتری
                </p>

            </div>


            <div class="space-y-3">


                {{-- Name --}}

                @if($customerName)

                    <div
                        class="
                            flex
                            items-center
                            justify-between
                            gap-4
                        "
                    >

                        <span class="text-sm text-muted">
                            نام
                        </span>


                        <strong
                            class="
                                max-w-[65%]
                                text-left
                                text-sm
                                font-black
                                text-text
                            "
                        >
                            {{ $customerName }}
                        </strong>

                    </div>

                @endif


                {{-- Phone --}}

                @if($customerPhone)

                    <div
                        class="
                            flex
                            items-center
                            justify-between
                            gap-4
                        "
                    >

                        <span class="text-sm text-muted">
                            موبایل
                        </span>


                        <strong
                            dir="ltr"
                            class="
                                text-left
                                text-sm
                                font-black
                                text-text
                            "
                        >
                            {{ $customerPhone }}
                        </strong>

                    </div>

                @endif


                {{-- Note --}}

                @if($customerNote)

                    <div
                        class="
                            border-t
                            border-border
                            pt-3
                        "
                    >

                        <p
                            class="
                                text-xs
                                font-bold
                                text-muted
                            "
                        >
                            توضیحات
                        </p>


                        <p
                            class="
                                mt-2
                                text-sm
                                leading-6
                                text-text
                            "
                        >
                            {{ $customerNote }}
                        </p>

                    </div>

                @endif

            </div>

        </div>

    @endif


    {{-- ================================================================
        Approval Notice
    ================================================================= --}}

    <div
        class="
            mt-6
            rounded-2xl
            border
            border-amber-500/20
            bg-amber-500/10
            p-4
        "
    >

        <div
            class="
                flex
                items-start
                gap-3
            "
        >

            <div
                class="
                    flex
                    h-8
                    w-8
                    shrink-0
                    items-center
                    justify-center
                    rounded-lg
                    bg-amber-500/10
                "
            >

                <x-lucide-info
                    class="
                        h-4
                        w-4
                        text-amber-400
                    "
                />

            </div>


            <div>

                <p
                    class="
                        text-sm
                        font-black
                        text-amber-400
                    "
                >
                    رزرو پس از ثبت نیاز به تأیید آرایشگر دارد.
                </p>


                <p
                    class="
                        mt-1
                        text-xs
                        leading-6
                        text-amber-300/70
                    "
                >
                    درخواست شما ابتدا با وضعیت
                    «در انتظار تأیید»
                    ثبت می‌شود و پس از بررسی آرایشگر،
                    نتیجه رزرو مشخص خواهد شد.
                </p>

            </div>

        </div>

    </div>


    {{-- ================================================================
        Validation State
    ================================================================= --}}

    @if(!$service)

        <div
            class="
                mt-4
                rounded-2xl
                border
                border-red-500/20
                bg-red-500/5
                px-4
                py-3
                text-sm
                font-bold
                text-red-400
            "
        >
            ابتدا یک خدمت انتخاب کن.
        </div>


    @elseif(!$date)

        <div
            class="
                mt-4
                rounded-2xl
                border
                border-amber-500/20
                bg-amber-500/5
                px-4
                py-3
                text-sm
                font-bold
                text-amber-400
            "
        >
            ابتدا یک تاریخ انتخاب کن.
        </div>


    @elseif(!$time)

        <div
            class="
                mt-4
                rounded-2xl
                border
                border-amber-500/20
                bg-amber-500/5
                px-4
                py-3
                text-sm
                font-bold
                text-amber-400
            "
        >
            ابتدا یک ساعت برای رزرو انتخاب کن.
        </div>


    @elseif(!$customerName || !$customerPhone)

        <div
            class="
                mt-4
                rounded-2xl
                border
                border-amber-500/20
                bg-amber-500/5
                px-4
                py-3
                text-sm
                font-bold
                text-amber-400
            "
        >
            نام و شماره موبایل خودت را وارد کن.
        </div>

    @endif


    {{-- ================================================================
        IMPORTANT
    ================================================================= --}}

    {{--
        Hidden booking_date / booking_time intentionally removed.

        Parent component:
        resources/views/components/salon/booking.blade.php

        already contains:

        booking_date => Gregorian date
        booking_time => selected time

        We MUST NOT send another booking_date here,
        especially not the Jalali date.
    --}}


</div>
