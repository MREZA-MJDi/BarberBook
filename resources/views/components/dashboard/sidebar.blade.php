{{-- resources/views/components/dashboard/sidebar.blade.php --}}

<div
    x-data="{ open: false }"
    @sidebar-open.window="open = true"
    @sidebar-close.window="open = false"
    @sidebar-toggle.window="open = !open"
    @keydown.escape.window="open = false"
>

    {{-- =========================================================
        Mobile Overlay
    ========================================================== --}}

    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition-opacity ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="
            fixed
            inset-0
            z-[60]
            bg-black/60
            backdrop-blur-sm
            lg:hidden
        "
    ></div>


    {{-- =========================================================
        Mobile Sidebar
    ========================================================== --}}

    <aside
        x-show="open"
        x-cloak
        x-transition:enter="transform transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="
            fixed
            inset-y-0
            right-0
            z-[70]
            flex
            w-[min(88vw,20rem)]
            flex-col
            overflow-hidden
            border-l
            border-zinc-800
            bg-zinc-950
            shadow-2xl
            lg:hidden
        "
    >

        {{-- Header --}}

        <div
            class="
                flex
                h-20
                shrink-0
                items-center
                justify-between
                border-b
                border-zinc-800
                px-5
            "
        >

            <a
                href="{{ route('dashboard') }}"
                @click="open = false"
                class="flex min-w-0 items-center gap-3"
            >

                <div
                    class="
                        flex
                        h-11
                        w-11
                        shrink-0
                        items-center
                        justify-center
                        rounded-2xl
                        border
                        border-orange-500/20
                        bg-orange-500/10
                    "
                >
                    <span class="text-lg font-black text-orange-500">
                        B
                    </span>
                </div>

                <div class="min-w-0">

                    <h1 class="truncate text-base font-black text-white">
                        BarberBook
                    </h1>

                    <p class="text-[10px] text-zinc-500">
                        Barber Dashboard
                    </p>

                </div>

            </a>


            <button
                type="button"
                @click="open = false"
                class="
                    flex
                    h-10
                    w-10
                    shrink-0
                    items-center
                    justify-center
                    rounded-xl
                    border
                    border-zinc-800
                    bg-zinc-900
                    text-zinc-400
                    transition
                    hover:border-orange-500/40
                    hover:text-orange-500
                "
                aria-label="بستن منو"
            >
                <x-lucide-x class="h-5 w-5" />
            </button>

        </div>


        {{-- Navigation --}}

        <nav class="flex-1 space-y-1 overflow-y-auto p-4">

            <a
                href="{{ route('dashboard') }}"
                @click="open = false"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('dashboard')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-house class="h-5 w-5" />
                <span>داشبورد</span>
            </a>


            <a
                href="{{ route('bookings.index') }}"
                @click="open = false"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('bookings.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-calendar-days class="h-5 w-5" />
                <span>رزروها</span>
            </a>


            <a
                href="{{ route('services.index') }}"
                @click="open = false"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('services.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-scissors class="h-5 w-5" />
                <span>خدمات</span>
            </a>


            <a
                href="{{ route('working-hours.index') }}"
                @click="open = false"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('working-hours.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-clock-3 class="h-5 w-5" />
                <span>ساعات کاری</span>
            </a>


            <a
                href="{{ route('gallery.index') }}"
                @click="open = false"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('gallery.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-images class="h-5 w-5" />
                <span>گالری</span>
            </a>


            <a
                href="{{ route('qr.index') }}"
                @click="open = false"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('qr.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-qr-code class="h-5 w-5" />
                <span>QR رزرو</span>
            </a>


            <a
                href="{{ route('reviews.index') }}"
                @click="open = false"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('reviews.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-star class="h-5 w-5" />
                <span>نظرات</span>
            </a>


            <a
                href="{{ route('settings.index') }}"
                @click="open = false"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('settings.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-settings class="h-5 w-5" />
                <span>تنظیمات</span>
            </a>

        </nav>


        {{-- Footer --}}

        <div class="shrink-0 border-t border-zinc-800 p-4">

            <div class="mb-4 flex items-center gap-3">

                <div
                    class="
                        flex
                        h-11
                        w-11
                        shrink-0
                        items-center
                        justify-center
                        rounded-full
                        bg-orange-500
                        font-black
                        text-black
                    "
                >
                    {{ mb_substr(auth()->user()->full_name ?? 'B', 0, 1) }}
                </div>

                <div class="min-w-0">

                    <p class="truncate text-sm font-semibold text-white">
                        {{ auth()->user()->full_name ?? 'آرایشگر' }}
                    </p>

                    <p class="truncate text-[11px] text-zinc-500">
                        {{ auth()->user()->email ?? '' }}
                    </p>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    type="submit"
                    class="
                        flex
                        w-full
                        items-center
                        justify-center
                        gap-2
                        rounded-xl
                        border
                        border-red-500/20
                        bg-red-500/10
                        px-4
                        py-3
                        text-sm
                        font-medium
                        text-red-400
                        transition
                        hover:bg-red-500
                        hover:text-white
                    "
                >
                    <x-lucide-log-out class="h-5 w-5" />
                    خروج از حساب
                </button>

            </form>

        </div>

    </aside>


    {{-- =========================================================
        Desktop Sidebar
    ========================================================== --}}

    <aside
        class="
            fixed
            inset-y-0
            right-0
            z-50
            hidden
            w-72
            flex-col
            border-l
            border-zinc-800
            bg-zinc-950
            lg:flex
        "
    >

        {{-- Logo --}}

        <div
            class="
                flex
                h-20
                shrink-0
                items-center
                border-b
                border-zinc-800
                px-6
            "
        >

            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3"
            >

                <div
                    class="
                        flex
                        h-12
                        w-12
                        items-center
                        justify-center
                        rounded-2xl
                        border
                        border-orange-500/20
                        bg-orange-500/10
                    "
                >
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

            <a
                href="{{ route('dashboard') }}"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('dashboard')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-house class="h-5 w-5" />
                داشبورد
            </a>


            <a
                href="{{ route('bookings.index') }}"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('bookings.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-calendar-days class="h-5 w-5" />
                رزروها
            </a>


            <a
                href="{{ route('services.index') }}"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('services.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-scissors class="h-5 w-5" />
                خدمات
            </a>


            <a
                href="{{ route('working-hours.index') }}"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('working-hours.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-clock-3 class="h-5 w-5" />
                ساعات کاری
            </a>


            <a
                href="{{ route('gallery.index') }}"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('gallery.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-images class="h-5 w-5" />
                گالری
            </a>


            <a
                href="{{ route('qr.index') }}"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('qr.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-qr-code class="h-5 w-5" />
                QR رزرو
            </a>


            <a
                href="{{ route('reviews.index') }}"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('reviews.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-star class="h-5 w-5" />
                نظرات
            </a>


            <a
                href="{{ route('settings.index') }}"
                class="
                    flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('settings.*')
                        ? 'bg-orange-500 text-black'
                        : 'text-zinc-300 hover:bg-zinc-900 hover:text-white'
                    }}
                    "
            >
                <x-lucide-settings class="h-5 w-5" />
                تنظیمات
            </a>

        </nav>


        {{-- Footer --}}

        <div class="shrink-0 border-t border-zinc-800 p-5">

            <div class="mb-5 flex items-center gap-3">

                <div
                    class="
                        flex
                        h-12
                        w-12
                        shrink-0
                        items-center
                        justify-center
                        rounded-full
                        bg-orange-500
                        font-black
                        text-black
                    "
                >
                    {{ mb_substr(auth()->user()->full_name ?? 'B', 0, 1) }}
                </div>

                <div class="min-w-0">

                    <p class="truncate font-semibold text-white">
                        {{ auth()->user()->full_name ?? 'آرایشگر' }}
                    </p>

                    <p class="truncate text-xs text-zinc-500">
                        {{ auth()->user()->email ?? '' }}
                    </p>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="
                        flex
                        w-full
                        items-center
                        justify-center
                        gap-2
                        rounded-xl
                        border
                        border-red-500/20
                        bg-red-500/10
                        px-4
                        py-3
                        text-sm
                        font-medium
                        text-red-400
                        transition
                        hover:bg-red-500
                        hover:text-white
                    "
                >
                    <x-lucide-log-out class="h-5 w-5" />
                    خروج از حساب
                </button>

            </form>

        </div>

    </aside>

</div>
