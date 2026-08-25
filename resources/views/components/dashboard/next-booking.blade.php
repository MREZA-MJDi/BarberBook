@props([
'booking' => null,
])


{{-- =========================================================
    Header
========================================================= --}}

<div class="flex items-center justify-between">

    <div>

        <div class="flex items-center gap-2">

            <span class="h-2 w-2 rounded-full bg-orange-500"></span>

            <h2 class="text-lg font-black text-white">
                رزرو بعدی
            </h2>

        </div>


        <p class="mt-1 text-sm text-zinc-500">
            نزدیک‌ترین مشتری آینده شما
        </p>

    </div>


    <div
        class="
            flex
            h-11
            w-11
            items-center
            justify-center
            rounded-2xl
            border
            border-orange-500/20
            bg-orange-500/10
        "
    >

        <x-lucide-calendar-clock
            class="h-5 w-5 text-orange-500"
        />

    </div>

</div>


{{-- =========================================================
    Booking
========================================================= --}}

@if($booking)

    @php

        /*
        |--------------------------------------------------------------------------
        | Gregorian Booking Date
        |--------------------------------------------------------------------------
        */

        $bookingDate = \Carbon\Carbon::parse(
            $booking->booking_date
        )->startOfDay();


        /*
        |--------------------------------------------------------------------------
        | Today
        |--------------------------------------------------------------------------
        */

        $today = now()->startOfDay();


        /*
        |--------------------------------------------------------------------------
        | Jalali Date
        |--------------------------------------------------------------------------
        */

        $jalaliBookingDate =
            \Morilog\Jalali\Jalalian::fromCarbon(
                $bookingDate
            );


        /*
        |--------------------------------------------------------------------------
        | Booking Day Label
        |--------------------------------------------------------------------------
        */

        if ($bookingDate->isSameDay($today)) {

            $bookingDay = 'امروز';

        } elseif ($bookingDate->isTomorrow()) {

            $bookingDay = 'فردا';

        } else {

            $bookingDay =
                $jalaliBookingDate->format(
                    '%A، j %B'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Full Jalali Date
        |--------------------------------------------------------------------------
        */

        $fullJalaliDate =
            $jalaliBookingDate->format(
                'j %B Y'
            );


        /*
        |--------------------------------------------------------------------------
        | Booking Time
        |--------------------------------------------------------------------------
        */

        $bookingTime =
            \Carbon\Carbon::parse(
                $booking->booking_time
            )->format('H:i');

    @endphp


    <div
        class="
            group
            mt-6
            overflow-hidden
            rounded-2xl
            border
            border-zinc-800
            bg-zinc-950
            transition
            hover:border-orange-500/20
        "
    >

        {{-- =====================================================
            Top Accent
        ====================================================== --}}

        <div
            class="
                h-1
                bg-gradient-to-r
                from-orange-500
                via-orange-400
                to-transparent
            "
        ></div>


        <div class="p-5">


            {{-- =================================================
                Customer
            ================================================== --}}

            <div
                class="
                    flex
                    items-center
                    justify-between
                    gap-4
                "
            >

                <div
                    class="
                        flex
                        min-w-0
                        items-center
                        gap-4
                    "
                >

                    {{-- Avatar --}}

                    <div
                        class="
                            flex
                            h-13
                            w-13
                            shrink-0
                            items-center
                            justify-center
                            rounded-2xl
                            bg-orange-500/10
                            text-lg
                            font-black
                            text-orange-500
                            ring-1
                            ring-orange-500/10
                        "
                    >
                        {{ mb_substr($booking->customer_name, 0, 1) }}
                    </div>


                    {{-- Customer Info --}}

                    <div class="min-w-0">

                        <h3
                            class="
                                truncate
                                font-bold
                                text-white
                            "
                        >
                            {{ $booking->customer_name }}
                        </h3>


                        <p
                            class="
                                mt-1
                                flex
                                items-center
                                gap-1.5
                                text-sm
                                text-zinc-500
                            "
                        >

                            <x-lucide-scissors
                                class="h-3.5 w-3.5"
                            />

                            <span class="truncate">
                                {{ $booking->service?->name ?? 'بدون خدمت' }}
                            </span>

                        </p>

                    </div>

                </div>


                {{-- =================================================
                    Time
                ================================================== --}}

                <div class="shrink-0 text-left">

                    <p
                        class="
                            text-2xl
                            font-black
                            tracking-tight
                            text-white
                        "
                    >
                        {{ $bookingTime }}
                    </p>


                    <p
                        class="
                            mt-1
                            text-xs
                            font-bold
                            text-orange-500
                        "
                    >
                        {{ $bookingDay }}
                    </p>

                </div>

            </div>


            {{-- =================================================
                Divider
            ================================================== --}}

            <div class="my-5 border-t border-zinc-800"></div>


            {{-- =================================================
                Meta
            ================================================== --}}

            <div
                class="
                    flex
                    items-center
                    justify-between
                    gap-3
                "
            >

                {{-- Status --}}

                <div>

                    @if($booking->status === 'pending')

                        <span
                            class="
                                inline-flex
                                items-center
                                gap-1.5
                                rounded-full
                                bg-orange-500/10
                                px-3
                                py-1.5
                                text-xs
                                font-bold
                                text-orange-400
                            "
                        >

                            <span
                                class="
                                    h-1.5
                                    w-1.5
                                    rounded-full
                                    bg-orange-400
                                "
                            ></span>

                            در انتظار تایید

                        </span>


                    @elseif($booking->status === 'approved')

                        <span
                            class="
                                inline-flex
                                items-center
                                gap-1.5
                                rounded-full
                                bg-green-500/10
                                px-3
                                py-1.5
                                text-xs
                                font-bold
                                text-green-400
                            "
                        >

                            <span
                                class="
                                    h-1.5
                                    w-1.5
                                    rounded-full
                                    bg-green-400
                                "
                            ></span>

                            تایید شده

                        </span>


                    @elseif($booking->status === 'completed')

                        <span
                            class="
                                inline-flex
                                items-center
                                gap-1.5
                                rounded-full
                                bg-blue-500/10
                                px-3
                                py-1.5
                                text-xs
                                font-bold
                                text-blue-400
                            "
                        >

                            <span
                                class="
                                    h-1.5
                                    w-1.5
                                    rounded-full
                                    bg-blue-400
                                "
                            ></span>

                            تکمیل شده

                        </span>


                    @elseif($booking->status === 'rejected')

                        <span
                            class="
                                inline-flex
                                items-center
                                gap-1.5
                                rounded-full
                                bg-red-500/10
                                px-3
                                py-1.5
                                text-xs
                                font-bold
                                text-red-400
                            "
                        >

                            <span
                                class="
                                    h-1.5
                                    w-1.5
                                    rounded-full
                                    bg-red-400
                                "
                            ></span>

                            رد شده

                        </span>


                    @else

                        <span
                            class="
                                rounded-full
                                bg-zinc-500/10
                                px-3
                                py-1.5
                                text-xs
                                font-bold
                                text-zinc-400
                            "
                        >
                            {{ $booking->status }}
                        </span>

                    @endif

                </div>


                {{-- Jalali Date --}}

                <div
                    class="
                        flex
                        items-center
                        gap-1.5
                        text-xs
                        text-zinc-500
                    "
                >

                    <x-lucide-calendar-days
                        class="h-3.5 w-3.5"
                    />

                    <span>
                        {{ $fullJalaliDate }}
                    </span>

                </div>

            </div>


            {{-- =================================================
                Actions
            ================================================== --}}

            @if($booking->status === 'pending')

                <div
                    class="
                        mt-5
                        grid
                        grid-cols-2
                        gap-3
                    "
                >

                    {{-- Approve --}}

                    <form
                        action="{{ route('bookings.approve', $booking) }}"
                        method="POST"
                    >

                        @csrf

                        @method('PATCH')

                        <button
                            type="submit"
                            class="
                                flex
                                w-full
                                items-center
                                justify-center
                                gap-2
                                rounded-xl
                                bg-green-500/10
                                py-3
                                text-sm
                                font-bold
                                text-green-400
                                transition
                                hover:bg-green-500/20
                            "
                        >

                            <x-lucide-check
                                class="h-4 w-4"
                            />

                            تایید رزرو

                        </button>

                    </form>


                    {{-- Reject --}}

                    <form
                        action="{{ route('bookings.reject', $booking) }}"
                        method="POST"
                    >

                        @csrf

                        @method('PATCH')

                        <button
                            type="submit"
                            class="
                                flex
                                w-full
                                items-center
                                justify-center
                                gap-2
                                rounded-xl
                                bg-red-500/10
                                py-3
                                text-sm
                                font-bold
                                text-red-400
                                transition
                                hover:bg-red-500/20
                            "
                        >

                            <x-lucide-x
                                class="h-4 w-4"
                            />

                            رد رزرو

                        </button>

                    </form>

                </div>

            @endif

        </div>

    </div>


@else

    {{-- =========================================================
        Empty State
    ========================================================== --}}

    <div
        class="
            mt-6
            flex
            min-h-[230px]
            flex-col
            items-center
            justify-center
            rounded-2xl
            border
            border-dashed
            border-zinc-800
            bg-zinc-950/70
            p-6
            text-center
        "
    >

        <div
            class="
                flex
                h-16
                w-16
                items-center
                justify-center
                rounded-2xl
                bg-zinc-900
                ring-1
                ring-zinc-800
            "
        >

            <x-lucide-calendar-check
                class="h-7 w-7 text-zinc-600"
            />

        </div>


        <h3 class="mt-5 font-bold text-white">
            برنامه خالی است
        </h3>


        <p
            class="
                mt-2
                max-w-xs
                text-sm
                leading-6
                text-zinc-500
            "
        >
            در حال حاضر هیچ رزرو آینده‌ای برای سالن ثبت نشده است.
        </p>

    </div>

@endif
