<div class="space-y-3">

    @forelse($notifications as $notification)

        @php

            /*
            |--------------------------------------------------------------------------
            | Notification Created At
            |--------------------------------------------------------------------------
            */

            $notificationCreatedAt = null;

            if (!empty($notification['created_at'])) {

                try {

                    $notificationDate =
                        \Carbon\Carbon::parse(
                            $notification['created_at']
                        );

                    $notificationCreatedAt =
                        \Morilog\Jalali\Jalalian::fromCarbon(
                            $notificationDate
                        )->format('Y/m/d H:i');

                } catch (\Throwable) {

                    $notificationCreatedAt =
                        $notification['created_at'];

                }
            }


            /*
            |--------------------------------------------------------------------------
            | Booking Date
            |--------------------------------------------------------------------------
            */

            $bookingJalaliDate = null;

            if (
                $notification['type'] === 'bookings' &&
                !empty($notification['date'])
            ) {

                try {

                    $bookingDate =
                        \Carbon\Carbon::parse(
                            $notification['date']
                        );

                    $bookingJalaliDate =
                        \Morilog\Jalali\Jalalian::fromCarbon(
                            $bookingDate
                        )->format('j %B Y');

                } catch (\Throwable) {

                    $bookingJalaliDate =
                        $notification['date'];

                }
            }

        @endphp


        <a
            href="{{ route('bookings.show', $notification['booking_id']) }}"
            class="
                group
                block
                rounded-2xl
                border
                border-zinc-800
                bg-zinc-950
                p-4
                transition
                duration-200
                hover:border-orange-500/40
                hover:bg-zinc-900/70
            "
        >

            <div class="flex items-start gap-4">

                {{-- =====================================================
                    Icon
                ====================================================== --}}

                <div
                    class="
                        flex
                        h-11
                        w-11
                        shrink-0
                        items-center
                        justify-center
                        rounded-xl
                        border
                        border-orange-500/20
                        bg-orange-500/10
                        text-orange-500
                        transition
                        group-hover:bg-orange-500/15
                    "
                >

                    @if($notification['type'] === 'bookings')

                        <x-lucide-calendar-days class="h-5 w-5" />

                    @elseif($notification['type'] === 'success')

                        <x-lucide-circle-check class="h-5 w-5" />

                    @else

                        <x-lucide-bell class="h-5 w-5" />

                    @endif

                </div>


                {{-- =====================================================
                    Content
                ====================================================== --}}

                <div class="min-w-0 flex-1">

                    <div
                        class="
                            flex
                            items-start
                            justify-between
                            gap-3
                        "
                    >

                        <div>

                            <h4 class="font-bold text-white">
                                {{ $notification['title'] }}
                            </h4>


                            <p
                                class="
                                    mt-1
                                    text-sm
                                    leading-6
                                    text-zinc-400
                                "
                            >
                                {{ $notification['message'] }}
                            </p>

                        </div>


                        {{-- Pending indicator --}}

                        <span
                            class="
                                mt-1
                                h-2
                                w-2
                                shrink-0
                                rounded-full
                                bg-orange-500
                                shadow-[0_0_10px_rgba(249,115,22,0.7)]
                            "
                        ></span>

                    </div>


                    {{-- =================================================
                        Booking Meta
                    ================================================== --}}

                    @if($notification['type'] === 'bookings')

                        <div
                            class="
                                mt-3
                                flex
                                flex-wrap
                                items-center
                                gap-x-4
                                gap-y-2
                            "
                        >

                            {{-- Booking Date --}}

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    gap-1.5
                                    text-xs
                                    text-zinc-500
                                "
                            >

                                <x-lucide-calendar
                                    class="h-3.5 w-3.5"
                                />

                                {{ $bookingJalaliDate }}

                            </span>


                            {{-- Booking Time --}}

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    gap-1.5
                                    text-xs
                                    font-bold
                                    text-orange-400
                                "
                            >

                                <x-lucide-clock
                                    class="h-3.5 w-3.5"
                                />

                                {{ $notification['time'] }}

                            </span>

                        </div>

                    @endif


                    {{-- =================================================
                        Footer
                    ================================================== --}}

                    <div
                        class="
                            mt-3
                            flex
                            items-center
                            justify-between
                            gap-3
                        "
                    >

                        <span class="text-[11px] text-zinc-600">

                            {{ $notificationCreatedAt }}

                        </span>


                        <span
                            class="
                                inline-flex
                                items-center
                                gap-1
                                text-[11px]
                                font-bold
                                text-zinc-600
                                transition
                                group-hover:text-orange-400
                            "
                        >

                            مشاهده رزرو

                            <x-lucide-arrow-left
                                class="
                                    h-3
                                    w-3
                                    transition-transform
                                    group-hover:-translate-x-0.5
                                "
                            />

                        </span>

                    </div>

                </div>

            </div>

        </a>


    @empty

        {{-- =========================================================
            Empty State
        ========================================================== --}}

        <div
            class="
                flex
                min-h-[180px]
                flex-col
                items-center
                justify-center
                rounded-2xl
                border
                border-dashed
                border-zinc-800
                bg-zinc-950
                p-6
                text-center
            "
        >

            <div
                class="
                    flex
                    h-12
                    w-12
                    items-center
                    justify-center
                    rounded-2xl
                    bg-zinc-900
                "
            >

                <x-lucide-bell-off
                    class="h-5 w-5 text-zinc-600"
                />

            </div>


            <p class="mt-4 text-sm font-bold text-zinc-400">
                اعلان جدیدی وجود ندارد.
            </p>


            <p class="mt-1 text-xs text-zinc-600">
                وقتی رزرو جدیدی ثبت شود، اینجا نمایش داده می‌شود.
            </p>

        </div>

    @endforelse

</div>
