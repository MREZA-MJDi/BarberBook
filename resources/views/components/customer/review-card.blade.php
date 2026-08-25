{{-- resources/views/components/customer/review-card.blade.php --}}

@props([
'review',
'detailsUrl' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Rating
    |--------------------------------------------------------------------------
    */

    $rating = max(
        0,
        min(5, (int) ($review->rating ?? 0))
    );


    /*
    |--------------------------------------------------------------------------
    | Booking / Service / Salon
    |--------------------------------------------------------------------------
    */

    $booking = $review->booking;

    $service = $booking?->service;

    $salon = $review->salon ?? $booking?->salon;


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
    | Status
    |--------------------------------------------------------------------------
    */

    $statusMap = [
        'pending' => [
            'label' => 'در انتظار انتشار',
            'class' => 'border-amber-500/20 bg-amber-500/10 text-amber-400',
            'dot'   => 'bg-amber-400',
        ],

        'published' => [
            'label' => 'منتشر شده',
            'class' => 'border-emerald-500/20 bg-emerald-500/10 text-emerald-400',
            'dot'   => 'bg-emerald-400',
        ],

        'rejected' => [
            'label' => 'رد شده',
            'class' => 'border-red-500/20 bg-red-500/10 text-red-400',
            'dot'   => 'bg-red-400',
        ],
    ];

    $status = $statusMap[$review->status] ?? [
        'label' => 'نامشخص',
        'class' => 'border-slate-500/20 bg-slate-500/10 text-slate-400',
        'dot'   => 'bg-slate-400',
    ];


    /*
    |--------------------------------------------------------------------------
    | Booking Date / Time
    |--------------------------------------------------------------------------
    */

    $bookingDate = $booking?->booking_date
        ? \Carbon\Carbon::parse($booking->booking_date)
        : null;

    $bookingTime = $booking?->booking_time
        ? substr((string) $booking->booking_time, 0, 5)
        : null;
@endphp


<article
    {{ $attributes->merge([
        'class' => '
            overflow-hidden
            rounded-[28px]
            border
            border-border
            bg-surface
            transition
            duration-300
            hover:border-primary/30
        ',
    ]) }}
>

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

                <div class="flex items-center gap-3">

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
                        ★
                    </div>

                    <div class="min-w-0">

                        <h3
                            class="
                                truncate
                                text-sm
                                font-black
                                text-text
                            "
                        >
                            {{ $salon?->name ?? 'آرایشگاه' }}
                        </h3>

                        @if($service)

                            <p
                                class="
                                    mt-1
                                    truncate
                                    text-xs
                                    font-bold
                                    text-muted
                                "
                            >
                                {{ $service->name }}
                            </p>

                        @endif

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
            Rating
        ====================================================== --}}

        <div
            class="mt-5 flex items-center gap-1"
            aria-label="امتیاز {{ $rating }} از 5"
        >

            @for($i = 1; $i <= 5; $i++)

                <span
                    class="
                        text-lg
                        leading-none
                        {{ $i <= $rating ? 'text-primary' : 'text-text/15' }}
                        "
                >
                    ★
                </span>

            @endfor

            <span
                class="
                    mr-2
                    text-xs
                    font-black
                    text-muted
                "
            >
                {{ $toPersianDigits($rating) }} از ۵
            </span>

        </div>


        {{-- =====================================================
            Comment
        ====================================================== --}}

        @if($review->comment)

            <div
                class="
                    mt-5
                    rounded-2xl
                    border
                    border-border
                    bg-background
                    p-4
                "
            >

                <p
                    class="
                        text-sm
                        leading-8
                        text-text
                    "
                >
                    {{ $review->comment }}
                </p>

            </div>

        @else

            <p
                class="
                    mt-5
                    text-sm
                    italic
                    text-muted
                "
            >
                متنی برای این نظر ثبت نشده است.
            </p>

        @endif


        {{-- =====================================================
            Booking Information
        ====================================================== --}}

        @if($booking)

            <div
                class="
                    mt-5
                    grid
                    grid-cols-2
                    gap-3
                    sm:grid-cols-3
                "
            >

                {{-- Booking Date --}}
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
                        تاریخ نوبت
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


                {{-- Booking Time --}}
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


                {{-- Reference --}}
                <div
                    class="
                        col-span-2
                        rounded-2xl
                        border
                        border-border
                        bg-background
                        p-4
                        sm:col-span-1
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
                        {{ $booking->reference_code ?? '-' }}
                    </p>

                </div>

            </div>

        @endif


        {{-- =====================================================
            Footer
        ====================================================== --}}

        <div
            class="
                mt-6
                flex
                flex-col
                gap-3
                border-t
                border-border
                pt-5
                sm:flex-row
                sm:items-center
                sm:justify-between
            "
        >

            @if($review->created_at)

                <span
                    class="text-xs font-bold text-muted"
                >
                    ثبت شده
                    {{ $review->created_at->diffForHumans() }}
                </span>

            @else

                <span></span>

            @endif


            @if($detailsUrl)

                <a
                    href="{{ $detailsUrl }}"
                    class="
                        inline-flex
                        w-fit
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
                    مشاهده جزئیات
                </a>

            @endif

        </div>

    </div>

</article>
