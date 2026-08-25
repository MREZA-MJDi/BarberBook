{{-- resources/views/components/customer/appointment-actions.blade.php --}}

@props([
'booking',
'detailsUrl' => null,
'reviewUrl' => null,
'trackUrl' => null,
])

@php
    $status = $booking->status;

    $canReview =
        $status === 'completed'
        && !$booking->review;

    $canTrack =
        in_array($status, [
            'pending',
            'approved',
            'completed',
            'rejected',
            'cancelled',
        ], true);
@endphp

<div
    {{ $attributes->merge([
        'class' => 'flex flex-wrap items-center gap-2',
    ]) }}
>

    {{-- =========================================================
        Details
    ========================================================== --}}

    @if($detailsUrl)

        <a
            href="{{ $detailsUrl }}"
            class="
                inline-flex
                items-center
                justify-center
                gap-2
                rounded-xl
                border
                border-border
                bg-background
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

            <svg
                class="h-4 w-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 5h6M9 9h6M9 13h4"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M7 3h8l3 3v15H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                />
            </svg>

            جزئیات نوبت

        </a>

    @endif


    {{-- =========================================================
        Track Booking
    ========================================================== --}}

    @if($trackUrl && $canTrack)

        <a
            href="{{ $trackUrl }}"
            class="
                inline-flex
                items-center
                justify-center
                gap-2
                rounded-xl
                border
                border-primary/20
                bg-primary/5
                px-4
                py-2.5
                text-xs
                font-black
                text-primary
                transition
                hover:border-primary
                hover:bg-primary/10
            "
        >

            <svg
                class="h-4 w-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <circle
                    cx="12"
                    cy="12"
                    r="8.5"
                />

                <path
                    stroke-linecap="round"
                    d="M12 7v5l3 2"
                />
            </svg>

            پیگیری نوبت

        </a>

    @endif


    {{-- =========================================================
        Review
    ========================================================== --}}

    @if($canReview && $reviewUrl)

        <a
            href="{{ $reviewUrl }}"
            class="
                inline-flex
                items-center
                justify-center
                gap-2
                rounded-xl
                bg-primary
                px-4
                py-2.5
                text-xs
                font-black
                text-white
                shadow-sm
                shadow-primary/20
                transition
                hover:bg-primary/90
                hover:-translate-y-0.5
            "
        >

            <svg
                class="h-4 w-4"
                viewBox="0 0 24 24"
                fill="currentColor"
            >
                <path
                    d="M12 2.75 14.8 8.4l6.2.9-4.5 4.38
                       1.06 6.2L12 16.93l-5.56 2.93
                       1.06-6.2L3 9.3l6.22-.9L12 2.75Z"
                />
            </svg>

            ثبت نظر

        </a>

    @endif


    {{-- =========================================================
        Status-specific Information
    ========================================================== --}}

    @if($status === 'pending')

        <span
            class="
                inline-flex
                items-center
                rounded-xl
                bg-amber-500/5
                px-3
                py-2.5
                text-[11px]
                font-bold
                text-amber-400/80
            "
        >
            منتظر تأیید سالن
        </span>

    @elseif($status === 'approved')

        <span
            class="
                inline-flex
                items-center
                rounded-xl
                bg-emerald-500/5
                px-3
                py-2.5
                text-[11px]
                font-bold
                text-emerald-400/80
            "
        >
            نوبت شما تأیید شده
        </span>

    @elseif($status === 'completed' && $booking->review)

        <span
            class="
                inline-flex
                items-center
                rounded-xl
                bg-primary/5
                px-3
                py-2.5
                text-[11px]
                font-bold
                text-primary/80
            "
        >
            نظر شما ثبت شده
        </span>

    @elseif($status === 'rejected')

        <span
            class="
                inline-flex
                items-center
                rounded-xl
                bg-red-500/5
                px-3
                py-2.5
                text-[11px]
                font-bold
                text-red-400/80
            "
        >
            درخواست رد شده
        </span>

    @elseif($status === 'cancelled')

        <span
            class="
                inline-flex
                items-center
                rounded-xl
                bg-slate-500/5
                px-3
                py-2.5
                text-[11px]
                font-bold
                text-slate-400/80
            "
        >
            نوبت لغو شده
        </span>

    @endif

</div>
