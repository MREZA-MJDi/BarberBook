{{-- resources/views/components/customer/appointment-card.blade.php --}}

@props([
'booking',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    $statusMap = [
        'pending' => [
            'label' => 'در انتظار تأیید',
            'class' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
            'dot'   => 'bg-amber-400',
        ],

        'approved' => [
            'label' => 'تأیید شده',
            'class' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            'dot'   => 'bg-emerald-400',
        ],

        'completed' => [
            'label' => 'انجام شده',
            'class' => 'bg-primary/10 text-primary border-primary/20',
            'dot'   => 'bg-primary',
        ],

        'rejected' => [
            'label' => 'رد شده',
            'class' => 'bg-red-500/10 text-red-400 border-red-500/20',
            'dot'   => 'bg-red-400',
        ],

        'cancelled' => [
            'label' => 'لغو شده',
            'class' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
            'dot'   => 'bg-slate-400',
        ],
    ];

    $status = $statusMap[$booking->status] ?? [
        'label' => 'نامشخص',
        'class' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
        'dot'   => 'bg-slate-400',
    ];


    /*
    |--------------------------------------------------------------------------
    | Review State
    |--------------------------------------------------------------------------
    */

    $canReview =
        $booking->status === 'completed'
        && !$booking->review;


    /*
    |--------------------------------------------------------------------------
    | Date
    |--------------------------------------------------------------------------
    */

    $bookingDate = $booking->booking_date
        ? \Carbon\Carbon::parse($booking->booking_date)
        : null;


    /*
    |--------------------------------------------------------------------------
    | Time
    |--------------------------------------------------------------------------
    */

    $bookingTime = $booking->booking_time
        ? substr((string) $booking->booking_time, 0, 5)
        : null;


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
@endphp


<article
    {{ $attributes->merge([
        'class' => '
            group
            overflow-hidden
            rounded-[28px]
            border
            border-border
            bg-surface
            transition
            duration-300
            hover:border-primary/30
            hover:shadow-[0_20px_60px_rgba(0,0,0,.08)]
        ',
    ]) }}
>

    {{-- =========================================================
        Top Accent
    ========================================================== --}}

    <div
        class="h-1 w-full bg-gradient-to-l from-primary/80 via-primary/30 to-transparent"
    ></div>


    <div class="p-5 sm:p-6">

        {{-- =====================================================
            Header
        ====================================================== --}}

        <div
            class="
                flex
                flex-col
                gap-4
                sm:flex-row
                sm:items-start
                sm:justify-between
            "
        >

            <div class="min-w-0">

                {{-- Salon --}}
                <div class="flex min-w-0 items-center gap-3">

                    <div
                        class="
                            flex
                            h-11
                            w-11
                            shrink-0
                            items-center
                            justify-center
                            rounded-2xl
                            bg-primary/10
                            text-lg
                            text-primary
                        "
                    >
                        ✂️
                    </div>

                    <div class="min-w-0">

                        <h3
                            class="
                                truncate
                                text-base
                                font-black
                                text-text
                            "
                        >
                            {{ $booking->salon?->name ?? 'آرایشگاه' }}
                        </h3>

                        <p class="mt-1 text-xs text-muted">
                            رزرو نوبت
                        </p>

                    </div>

                </div>

            </div>


            {{-- Status --}}
            <span
                class="
                    inline-flex
                    w-fit
                    shrink-0
                    items-center
                    gap-2
                    rounded-full
                    border
                    px-3
                    py-1.5
                    text-xs
                    font-black
                    {{ $status['class'] }}
                    "
            >

                <span
                    class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"
                ></span>

                {{ $status['label'] }}

            </span>

        </div>


        {{-- =====================================================
            Service
        ====================================================== --}}

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

            <div class="flex items-center justify-between gap-4">

                <div class="min-w-0">

                    <p class="text-xs font-bold text-muted">
                        خدمت
                    </p>

                    <p
                        class="
                            mt-1
                            truncate
                            text-base
                            font-black
                            text-text
                        "
                    >
                        {{ $booking->service?->name ?? 'خدمت رزرو شده' }}
                    </p>

                </div>


                @if($booking->duration_minutes)

                    <div
                        class="
                            shrink-0
                            rounded-xl
                            bg-primary/10
                            px-3
                            py-2
                            text-xs
                            font-black
                            text-primary
                        "
                    >
                        {{ $toPersianDigits($booking->duration_minutes) }}
                        دقیقه
                    </div>

                @endif

            </div>

        </div>


        {{-- =====================================================
            Booking Details
        ====================================================== --}}

        <div
            class="
                mt-5
                grid
                grid-cols-2
                gap-3
                sm:grid-cols-4
            "
        >

            {{-- Date --}}
            <div
                class="
                    rounded-2xl
                    border
                    border-border
                    bg-background
                    p-4
                "
            >

                <p class="text-[11px] font-bold text-muted">
                    تاریخ
                </p>

                <p
                    class="
                        mt-1.5
                        text-sm
                        font-black
                        text-text
                    "
                >
                    @if($bookingDate)

                        {{ $toPersianDigits($bookingDate->format('Y/m/d')) }}

                    @else

                        -

                    @endif
                </p>

            </div>


            {{-- Time --}}
            <div
                class="
                    rounded-2xl
                    border
                    border-border
                    bg-background
                    p-4
                "
            >

                <p class="text-[11px] font-bold text-muted">
                    ساعت
                </p>

                <p
                    dir="ltr"
                    class="
                        mt-1.5
                        text-right
                        text-sm
                        font-black
                        text-primary
                    "
                >
                    {{ $bookingTime ?? '-' }}
                </p>

            </div>


            {{-- Price --}}
            <div
                class="
                    rounded-2xl
                    border
                    border-border
                    bg-background
                    p-4
                "
            >

                <p class="text-[11px] font-bold text-muted">
                    مبلغ
                </p>

                <p
                    class="
                        mt-1.5
                        text-sm
                        font-black
                        text-text
                    "
                >
                    @if($booking->final_price !== null)

                        {{ $toPersianDigits(number_format($booking->final_price)) }}

                        <span class="text-[10px] text-muted">
                            تومان
                        </span>

                    @else

                        -

                    @endif
                </p>

            </div>


            {{-- Reference --}}
            <div
                class="
                    rounded-2xl
                    border
                    border-border
                    bg-background
                    p-4
                "
            >

                <p class="text-[11px] font-bold text-muted">
                    کد پیگیری
                </p>

                <p
                    dir="ltr"
                    class="
                        mt-1.5
                        truncate
                        text-left
                        font-mono
                        text-xs
                        font-black
                        text-text
                    "
                >
                    {{ $booking->reference_code }}
                </p>

            </div>

        </div>


        {{-- =====================================================
            Status Message
        ====================================================== --}}

        @if($booking->status === 'pending')

            <div
                class="
                    mt-5
                    rounded-2xl
                    border
                    border-amber-500/20
                    bg-amber-500/5
                    px-4
                    py-3
                "
            >

                <p class="text-xs font-bold leading-6 text-amber-400">
                    درخواست شما ثبت شده و منتظر تأیید سالن است.
                </p>

            </div>

        @elseif($booking->status === 'approved')

            <div
                class="
                    mt-5
                    rounded-2xl
                    border
                    border-emerald-500/20
                    bg-emerald-500/5
                    px-4
                    py-3
                "
            >

                <p class="text-xs font-bold leading-6 text-emerald-400">
                    نوبت شما تأیید شده است.
                </p>

            </div>

        @elseif($booking->status === 'completed' && !$booking->review)

            <div
                class="
                    mt-5
                    rounded-2xl
                    border
                    border-primary/20
                    bg-primary/5
                    px-4
                    py-3
                "
            >

                <p class="text-xs font-bold leading-6 text-primary">
                    نوبت شما انجام شده است. می‌توانید تجربه خود را ثبت کنید.
                </p>

            </div>

        @endif


        {{-- =====================================================
            Actions
        ====================================================== --}}

        <div
            class="
                mt-6
                flex
                flex-col
                gap-3
                sm:flex-row
                sm:items-center
                sm:justify-between
            "
        >

            <div class="text-xs text-muted">

                @if($booking->created_at)

                    ثبت شده
                    {{ $booking->created_at->diffForHumans() }}

                @endif

            </div>


            <div class="flex flex-wrap gap-2">

                {{-- Details --}}
                @isset($detailsUrl)

                    <a
                        href="{{ $detailsUrl }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-xl
                            border
                            border-border
                            px-4
                            py-2.5
                            text-xs
                            font-black
                            text-text
                            transition
                            hover:border-primary
                            hover:text-primary
                        "
                    >
                        جزئیات نوبت
                    </a>

                @endisset


                {{-- Review --}}
                @if($canReview && isset($reviewUrl))

                    <a
                        href="{{ $reviewUrl }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-xl
                            bg-primary
                            px-4
                            py-2.5
                            text-xs
                            font-black
                            text-white
                            transition
                            hover:bg-primary/90
                        "
                    >
                        ثبت نظر
                    </a>

                @endif

            </div>

        </div>

    </div>

</article>
