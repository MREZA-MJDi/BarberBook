<nav
    class="fixed inset-x-0 bottom-0 z-40 border-t border-zinc-800 bg-zinc-950/95 px-2 pb-[env(safe-area-inset-bottom)] pt-2 backdrop-blur-xl lg:hidden"
>

    <div class="mx-auto flex max-w-lg items-center justify-around gap-1">


        {{-- Dashboard --}}

        <a
            href="{{ route('customer.dashboard') }}"
            class="flex min-w-0 flex-1 flex-col items-center justify-center gap-1 rounded-xl px-2 py-2.5 transition
            {{ request()->routeIs('customer.dashboard')
                ? 'bg-orange-500/10 text-orange-500'
                : 'text-zinc-500 hover:text-zinc-300' }}"
        >

            <x-lucide-house class="h-5 w-5" />

            <span class="truncate text-[10px] font-bold">
                خانه
            </span>

        </a>


        {{-- Bookings --}}

        <a
            href="{{ route('customer.bookings.index') }}"
            class="flex min-w-0 flex-1 flex-col items-center justify-center gap-1 rounded-xl px-2 py-2.5 transition
            {{ request()->routeIs('customer.bookings.*')
                ? 'bg-orange-500/10 text-orange-500'
                : 'text-zinc-500 hover:text-zinc-300' }}"
        >

            <x-lucide-calendar-days class="h-5 w-5" />

            <span class="truncate text-[10px] font-bold">
                نوبت‌ها
            </span>

        </a>


        {{-- Booking Tracking --}}

        <a
            href="{{ route('booking.track.form') }}"
            class="relative -mt-6 flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border-4 border-zinc-950 bg-orange-500 text-black shadow-lg shadow-orange-500/20 transition hover:bg-orange-400 active:scale-95"
            aria-label="پیگیری نوبت"
        >

            <x-lucide-search-check class="h-6 w-6" />

        </a>


        {{-- Notifications --}}

        <a
            href="{{ route('customer.notifications.index') }}"
            class="relative flex min-w-0 flex-1 flex-col items-center justify-center gap-1 rounded-xl px-2 py-2.5 transition
            {{ request()->routeIs('customer.notifications.*')
                ? 'bg-orange-500/10 text-orange-500'
                : 'text-zinc-500 hover:text-zinc-300' }}"
        >

            <div class="relative">

                <x-lucide-bell class="h-5 w-5" />

                @if(isset($notificationsCount) && $notificationsCount > 0)

                    <span
                        class="absolute -right-2 -top-2 flex h-4 min-w-4 items-center justify-center rounded-full bg-orange-500 px-1 text-[9px] font-black text-black"
                    >
                        {{ $notificationsCount > 9 ? '9+' : $notificationsCount }}
                    </span>

                @endif

            </div>

            <span class="truncate text-[10px] font-bold">
                اعلان‌ها
            </span>

        </a>


        {{-- Settings --}}

        <a
            href="{{ route('customer.settings.index') }}"
            class="flex min-w-0 flex-1 flex-col items-center justify-center gap-1 rounded-xl px-2 py-2.5 transition
            {{ request()->routeIs('customer.settings.*')
                ? 'bg-orange-500/10 text-orange-500'
                : 'text-zinc-500 hover:text-zinc-300' }}"
        >

            <x-lucide-user-round class="h-5 w-5" />

            <span class="truncate text-[10px] font-bold">
                حساب
            </span>

        </a>

    </div>

</nav>
