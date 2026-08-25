<aside
    class="fixed inset-y-0 right-0 z-50 hidden w-72 border-l border-zinc-800 bg-zinc-950 lg:flex lg:flex-col"
>

    {{-- =========================================================
        Header / Logo
    ========================================================== --}}

    <div class="flex h-20 shrink-0 items-center border-b border-zinc-800 px-6">

        <a
            href="{{ route('customer.dashboard') }}"
            class="flex items-center gap-3"
        >

            <div
                class="flex h-11 w-11 items-center justify-center rounded-2xl border border-orange-500/20 bg-orange-500/10"
            >

                <span class="text-xl font-black text-orange-500">
                    B
                </span>

            </div>

            <div class="min-w-0">

                <h1 class="text-base font-black text-white">
                    BarberBook
                </h1>

                <p class="mt-0.5 text-xs text-zinc-500">
                    پنل کاربری
                </p>

            </div>

        </a>

    </div>


    {{-- =========================================================
        Navigation
    ========================================================== --}}

    <nav class="flex-1 overflow-y-auto p-4">

        <div class="space-y-1.5">


            {{-- Dashboard --}}

            <a
                href="{{ route('customer.dashboard') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                {{ request()->routeIs('customer.dashboard')
                    ? 'bg-orange-500 text-black'
                    : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
            >

                <x-lucide-house class="h-5 w-5 shrink-0" />

                <span>
                    داشبورد
                </span>

            </a>


            {{-- Bookings --}}

            <a
                href="{{ route('customer.bookings.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                {{ request()->routeIs('customer.bookings.*')
                    ? 'bg-orange-500 text-black'
                    : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
            >

                <x-lucide-calendar-days class="h-5 w-5 shrink-0" />

                <span>
                    نوبت‌های من
                </span>

            </a>


            {{-- Reviews --}}

            <a
                href="{{ route('customer.reviews.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                {{ request()->routeIs('customer.reviews.*')
                    ? 'bg-orange-500 text-black'
                    : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
            >

                <x-lucide-star class="h-5 w-5 shrink-0" />

                <span>
                    نظرات من
                </span>

            </a>


            {{-- Notifications --}}

            <a
                href="{{ route('customer.notifications.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                {{ request()->routeIs('customer.notifications.*')
                    ? 'bg-orange-500 text-black'
                    : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
            >

                <x-lucide-bell class="h-5 w-5 shrink-0" />

                <span>
                    اعلان‌ها
                </span>

            </a>


            {{-- Settings --}}

            <a
                href="{{ route('customer.settings.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                {{ request()->routeIs('customer.settings.*')
                    ? 'bg-orange-500 text-black'
                    : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
            >

                <x-lucide-settings class="h-5 w-5 shrink-0" />

                <span>
                    تنظیمات
                </span>

            </a>

        </div>


        {{-- =====================================================
            Booking Tracking
        ====================================================== --}}

        <div class="mt-8">

            <p class="mb-3 px-4 text-[11px] font-bold text-zinc-600">
                دسترسی سریع
            </p>

            <a
                href="{{ route('booking.track.form') }}"
                class="flex items-center gap-3 rounded-xl border border-zinc-800 bg-zinc-900/50 px-4 py-3 text-sm font-semibold text-zinc-300 transition hover:border-orange-500/30 hover:bg-zinc-900 hover:text-orange-400"
            >

                <x-lucide-search-check class="h-5 w-5 shrink-0" />

                <span>
                    پیگیری نوبت
                </span>

            </a>

        </div>

    </nav>


    {{-- =========================================================
        User Footer
    ========================================================== --}}

    <div class="shrink-0 border-t border-zinc-800 p-4">

        <div class="mb-4 flex items-center gap-3">

            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-orange-500 font-black text-black"
            >

                {{ mb_substr(auth()->user()->full_name ?? 'ک', 0, 1) }}

            </div>

            <div class="min-w-0 flex-1">

                <p class="truncate text-sm font-bold text-white">

                    {{ auth()->user()->full_name ?? 'کاربر' }}

                </p>

                <p class="truncate text-xs text-zinc-500">

                    {{ auth()->user()->email ?? '' }}

                </p>

            </div>

        </div>


        {{-- Logout --}}

        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm font-semibold text-red-400 transition hover:bg-red-500 hover:text-white"
            >

                <x-lucide-log-out class="h-5 w-5" />

                خروج از حساب

            </button>

        </form>

    </div>

</aside>
