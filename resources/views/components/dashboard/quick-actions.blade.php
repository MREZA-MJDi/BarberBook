{{-- =========================================================
Quick Actions
========================================================= --}}

<div>


    {{-- Header --}}

    <h3 class="text-lg font-black text-white">
        دسترسی سریع
    </h3>

    <p class="mt-1 text-sm text-zinc-400">
        کارهای پرکاربرد روزانه
    </p>


    {{-- =====================================================
        Actions
    ====================================================== --}}

    <div class="mt-5 space-y-3">


        {{-- =================================================
            Create Booking
        ================================================== --}}

        <a
            href="{{ route('bookings.create') }}"
            class="flex items-center justify-between rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3 transition hover:border-orange-500/40"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-500/10 text-orange-500"
                >
                    +
                </div>

                <span class="font-bold text-zinc-200">
                ثبت رزرو دستی
            </span>

            </div>

            <span class="text-zinc-500">
            ←
        </span>

        </a>



        {{-- =================================================
            Today Bookings
        ================================================== --}}

        <a
            href="{{ route('bookings.index', [
            'date' => \Morilog\Jalali\Jalalian::now()->format('Y/m/d'),
        ]) }}"
            class="flex items-center justify-between rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3 transition hover:border-orange-500/40"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-500/10 text-orange-500"
                >
                    📅
                </div>

                <span class="font-bold text-zinc-200">
                رزروهای امروز
            </span>

            </div>

            <span class="text-zinc-500">
            ←
        </span>

        </a>



        {{-- =================================================
            Customers
        ================================================== --}}

        <a
            href="#"
            class="flex items-center justify-between rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3 transition hover:border-orange-500/40"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-500/10 text-orange-500"
                >
                    👥
                </div>

                <span class="font-bold text-zinc-200">
                مشتری‌ها
            </span>

            </div>

            <span class="text-zinc-500">
            ←
        </span>

        </a>



        {{-- =================================================
            Working Hours
        ================================================== --}}

        <a
            href="#"
            class="flex items-center justify-between rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3 transition hover:border-orange-500/40"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-500/10 text-orange-500"
                >
                    🕒
                </div>

                <span class="font-bold text-zinc-200">
                ساعات کاری
            </span>

            </div>

            <span class="text-zinc-500">
            ←
        </span>

        </a>

    </div>


</div>
