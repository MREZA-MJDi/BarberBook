<x-layouts.dashboard>

    @php

        /*
        |--------------------------------------------------------------------------
        | Booking Date
        |--------------------------------------------------------------------------
        */

        $bookingJalaliDate = null;

        if ($booking->booking_date) {

            try {

                $bookingJalaliDate =
                    \Morilog\Jalali\Jalalian::fromCarbon(
                        \Carbon\Carbon::parse(
                            $booking->booking_date
                        )
                    );

            } catch (\Throwable) {

                $bookingJalaliDate = null;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Booking Time
        |--------------------------------------------------------------------------
        */

        $bookingTime = null;

        if ($booking->booking_time) {

            try {

                $bookingTime =
                    \Carbon\Carbon::parse(
                        $booking->booking_time
                    )->format('H:i');

            } catch (\Throwable) {

                $bookingTime =
                    $booking->booking_time;

            }

        }

    @endphp


    {{-- =========================================================
        Header
    ========================================================== --}}

    <div
        class="
            mb-8
            flex
            items-center
            justify-between
            gap-4
        "
    >

        <div>

            <h1
                class="
                    text-3xl
                    font-black
                    text-white
                "
            >
                جزئیات رزرو
            </h1>


            <p
                class="
                    mt-2
                    text-zinc-400
                "
            >
                مشاهده اطلاعات مشتری و مدیریت وضعیت رزرو
            </p>

        </div>


        <a
            href="{{ route('bookings.index') }}"
            class="
                inline-flex
                shrink-0
                items-center
                justify-center
                rounded-xl
                border
                border-zinc-800
                px-5
                py-3
                text-sm
                font-bold
                text-zinc-300
                transition
                hover:border-orange-500
                hover:text-orange-500
            "
        >
            بازگشت به رزروها
        </a>

    </div>


    {{-- =========================================================
        Main Layout
    ========================================================== --}}

    <div
        class="
            grid
            grid-cols-1
            gap-6
            lg:grid-cols-3
        "
    >


        {{-- =====================================================
            Main Info
        ====================================================== --}}

        <div
            class="
                space-y-6
                lg:col-span-2
            "
        >


            {{-- =================================================
                Customer
            ================================================== --}}

            <div
                class="
                    rounded-2xl
                    border
                    border-zinc-800
                    bg-zinc-900
                    p-6
                "
            >

                <div
                    class="
                        flex
                        items-center
                        gap-4
                    "
                >

                    {{-- Avatar --}}

                    <div
                        class="
                            flex
                            h-14
                            w-14
                            shrink-0
                            items-center
                            justify-center
                            rounded-2xl
                            border
                            border-orange-500/20
                            bg-orange-500/10
                            text-xl
                            font-black
                            text-orange-500
                        "
                    >

                        {{ mb_substr(
                            $booking->customer_name,
                            0,
                            1
                        ) }}

                    </div>


                    {{-- Customer Info --}}

                    <div class="min-w-0">

                        <h2
                            class="
                                truncate
                                text-xl
                                font-black
                                text-white
                            "
                        >

                            {{ $booking->customer_name }}

                        </h2>


                        <p
                            dir="ltr"
                            class="
                                mt-1
                                text-right
                                text-sm
                                text-zinc-500
                            "
                        >

                            {{ $booking->customer_phone }}

                        </p>

                    </div>

                </div>

            </div>


            {{-- =================================================
                Booking Info
            ================================================== --}}

            <div
                class="
                    rounded-2xl
                    border
                    border-zinc-800
                    bg-zinc-900
                    p-6
                "
            >

                <h3
                    class="
                        mb-6
                        text-lg
                        font-black
                        text-white
                    "
                >
                    اطلاعات رزرو
                </h3>


                <div
                    class="
                        grid
                        grid-cols-1
                        gap-5
                        md:grid-cols-2
                    "
                >


                    {{-- Service --}}

                    <div>

                        <p class="text-sm text-zinc-500">
                            سرویس
                        </p>


                        <p
                            class="
                                mt-1
                                font-bold
                                text-white
                            "
                        >
                            {{ $booking->service?->name ?? '-' }}
                        </p>

                    </div>


                    {{-- Reference --}}

                    <div>

                        <p class="text-sm text-zinc-500">
                            کد پیگیری
                        </p>


                        <p
                            dir="ltr"
                            class="
                                mt-1
                                font-bold
                                text-white
                            "
                        >
                            {{ $booking->reference_code }}
                        </p>

                    </div>


                    {{-- Jalali Date --}}

                    <div>

                        <p class="text-sm text-zinc-500">
                            تاریخ
                        </p>


                        <p
                            class="
                                mt-1
                                font-bold
                                text-white
                            "
                        >

                            @if($bookingJalaliDate)

                                {{ $bookingJalaliDate->format('j %B Y') }}

                            @else

                                -

                            @endif

                        </p>

                    </div>


                    {{-- Time --}}

                    <div>

                        <p class="text-sm text-zinc-500">
                            ساعت
                        </p>


                        <p
                            class="
                                mt-1
                                font-bold
                                text-white
                            "
                        >

                            {{ $bookingTime ?? '-' }}

                        </p>

                    </div>


                    {{-- Final Price --}}

                    <div>

                        <p class="text-sm text-zinc-500">
                            مبلغ نهایی
                        </p>


                        <p
                            class="
                                mt-1
                                font-bold
                                text-white
                            "
                        >

                            {{ number_format(
                                $booking->final_price ?? 0
                            ) }}

                            تومان

                        </p>

                    </div>


                    {{-- Duration --}}

                    <div>

                        <p class="text-sm text-zinc-500">
                            مدت زمان
                        </p>


                        <p
                            class="
                                mt-1
                                font-bold
                                text-white
                            "
                        >

                            {{ $booking->duration_minutes ?? 0 }}

                            دقیقه

                        </p>

                    </div>


                    {{-- Approved At --}}

                    @if($booking->approved_at)

                        @php

                            $approvedAt =
                                \Morilog\Jalali\Jalalian::fromCarbon(
                                    \Carbon\Carbon::parse(
                                        $booking->approved_at
                                    )
                                );

                        @endphp


                        <div>

                            <p class="text-sm text-zinc-500">
                                زمان تأیید
                            </p>


                            <p
                                class="
                                    mt-1
                                    font-bold
                                    text-white
                                "
                            >

                                {{ $approvedAt->format('j %B Y') }}

                                -

                                {{ \Carbon\Carbon::parse(
                                    $booking->approved_at
                                )->format('H:i') }}

                            </p>

                        </div>

                    @endif


                    {{-- Completed At --}}

                    @if($booking->completed_at)

                        @php

                            $completedAt =
                                \Morilog\Jalali\Jalalian::fromCarbon(
                                    \Carbon\Carbon::parse(
                                        $booking->completed_at
                                    )
                                );

                        @endphp


                        <div>

                            <p class="text-sm text-zinc-500">
                                زمان تکمیل
                            </p>


                            <p
                                class="
                                    mt-1
                                    font-bold
                                    text-white
                                "
                            >

                                {{ $completedAt->format('j %B Y') }}

                                -

                                {{ \Carbon\Carbon::parse(
                                    $booking->completed_at
                                )->format('H:i') }}

                            </p>

                        </div>

                    @endif

                </div>

            </div>


            {{-- =================================================
                Notes
            ================================================== --}}

            <div
                class="
                    rounded-2xl
                    border
                    border-zinc-800
                    bg-zinc-900
                    p-6
                "
            >

                <h3
                    class="
                        mb-4
                        text-lg
                        font-black
                        text-white
                    "
                >
                    یادداشت‌ها
                </h3>


                <div class="space-y-4">


                    {{-- Customer Note --}}

                    <div>

                        <p class="text-sm text-zinc-500">
                            یادداشت مشتری
                        </p>


                        <p
                            class="
                                mt-2
                                whitespace-pre-line
                                text-sm
                                leading-6
                                text-zinc-300
                            "
                        >

                            {{ $booking->customer_note ?? 'بدون یادداشت' }}

                        </p>

                    </div>


                    {{-- Barber Note --}}

                    <div>

                        <p class="text-sm text-zinc-500">
                            پیام آرایشگر
                        </p>


                        <p
                            class="
                                mt-2
                                whitespace-pre-line
                                text-sm
                                leading-6
                                text-zinc-300
                            "
                        >

                            {{ $booking->barber_note ?? 'بدون پیام' }}

                        </p>

                    </div>

                </div>

            </div>


        </div>


        {{-- =====================================================
            Sidebar
        ====================================================== --}}

        <div class="space-y-6">


            {{-- =================================================
                Status
            ================================================== --}}

            <div
                class="
                    rounded-2xl
                    border
                    border-zinc-800
                    bg-zinc-900
                    p-6
                "
            >

                <p
                    class="
                        mb-3
                        text-sm
                        text-zinc-500
                    "
                >
                    وضعیت رزرو
                </p>


                <x-dashboard.bookings.status
                    :status="$booking->status"
                />

            </div>


            {{-- =================================================
                Actions
            ================================================== --}}

            <div
                class="
                    rounded-2xl
                    border
                    border-zinc-800
                    bg-zinc-900
                    p-6
                "
            >

                <h3
                    class="
                        mb-5
                        text-lg
                        font-black
                        text-white
                    "
                >
                    عملیات
                </h3>


                <x-dashboard.bookings.actions
                    :booking="$booking"
                />

            </div>

        </div>

    </div>

</x-layouts.dashboard>
