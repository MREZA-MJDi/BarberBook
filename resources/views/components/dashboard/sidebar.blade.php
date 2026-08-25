<aside
    class="fixed inset-y-0 right-0 z-50 hidden w-72 border-l border-zinc-800 bg-zinc-950 lg:flex lg:flex-col">

    {{-- Logo --}}
    <div class="flex h-20 items-center border-b border-zinc-800 px-6">

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">

            <div
                class="flex h-12 w-12 items-center justify-center rounded-2xl border border-orange-500/20 bg-orange-500/10">

                <span class="text-xl font-black text-orange-500">
                    B
                </span>

            </div>

            <div>

                <h1 class="text-lg font-black text-white">
                    BarberBook
                </h1>

                <p class="text-xs text-zinc-500">
                    Barber Dashboard
                </p>

            </div>

        </a>

    </div>

    {{-- Navigation --}}
    <nav class="flex-1 space-y-2 overflow-y-auto p-5">

        {{-- Dashboard --}}
        <a
            href="{{ route('dashboard') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('dashboard')
                ? 'bg-orange-500 text-black'
                : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
        >

            <x-lucide-house class="h-5 w-5" />

            <span>
                داشبورد
            </span>

        </a>

        {{-- Bookings --}}
        <a
            href="{{ route('bookings.index') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('bookings.*')
                ? 'bg-orange-500 text-black'
                : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
        >

            <x-lucide-calendar-days class="h-5 w-5" />

            <span>
                رزروها
            </span>

        </a>

        {{-- Services --}}
        <a
            href="{{ route('services.index') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('services.*')
                ? 'bg-orange-500 text-black'
                : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
        >

            <x-lucide-scissors class="h-5 w-5" />

            <span>
                خدمات
            </span>

        </a>

        {{-- Working Hours --}}
        <a
            href="{{ route('working-hours.index') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('working-hours.*')
                ? 'bg-orange-500 text-black'
                : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
        >

            <x-lucide-clock-3 class="h-5 w-5" />

            <span>
                ساعات کاری
            </span>

        </a>

        {{-- Gallery --}}
        <a
            href="{{ route('gallery.index') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('gallery.*')
                ? 'bg-orange-500 text-black'
                : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
        >

            <x-lucide-images class="h-5 w-5" />

            <span>
                گالری
            </span>

        </a>

        {{-- QR --}}
        <a
            href="{{ route('qr.index') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('qr.*')
                ? 'bg-orange-500 text-black'
                : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
        >

            <x-lucide-qr-code class="h-5 w-5" />

            <span>
                QR رزرو
            </span>

        </a>

        {{-- Reviews --}}
        <a
            href="{{ route('reviews.index') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('reviews.*')
                ? 'bg-orange-500 text-black'
                : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
        >

            <x-lucide-star class="h-5 w-5" />

            <span>
                نظرات
            </span>

        </a>

        {{-- Settings --}}
        <a
            href="{{ route('settings.index') }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
            {{ request()->routeIs('settings.*')
                ? 'bg-orange-500 text-black'
                : 'text-zinc-300 hover:bg-zinc-900 hover:text-white' }}"
        >

            <x-lucide-settings class="h-5 w-5" />

            <span>
                تنظیمات
            </span>

        </a>

    </nav>

    {{-- Footer --}}
    <div class="border-t border-zinc-800 p-5">

        <div class="mb-5 flex items-center gap-3">

            <div
                class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-500 font-black text-black"
            >

                {{ mb_substr(auth()->user()->full_name ?? 'B', 0, 1) }}

            </div>

            <div>

                <p class="font-semibold text-white">

                    {{ auth()->user()->full_name ?? 'آرایشگر' }}

                </p>

                <p class="text-xs text-zinc-500">

                    {{ auth()->user()->email ?? '' }}

                </p>

            </div>

        </div>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button
                type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm font-medium text-red-400 transition hover:bg-red-500 hover:text-white"
            >

                <x-lucide-log-out class="h-5 w-5" />

                خروج از حساب

            </button>

        </form>

    </div>

</aside>
