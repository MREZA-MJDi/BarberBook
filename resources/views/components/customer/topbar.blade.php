@php

    $user = auth()->user();

    $fullName = $user?->full_name ?? 'کاربر';

    $initial = mb_substr($fullName, 0, 1);

@endphp


<header
    class="sticky top-0 z-30 border-b border-zinc-800 bg-zinc-950/90 backdrop-blur-xl"
>

    <div
        class="flex min-h-[72px] items-center justify-between gap-4 px-4 sm:px-6 lg:px-8"
    >


        {{-- =====================================================
            Right Side
        ====================================================== --}}

        <div class="flex min-w-0 items-center gap-3">


            {{-- Mobile Menu Button --}}

            <button
                type="button"
                @click="mobileMenuOpen = true"
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-zinc-800 bg-zinc-900 text-zinc-400 transition hover:border-orange-500/40 hover:text-orange-500 lg:hidden"
                aria-label="باز کردن منوی کاربری"
            >

                <x-lucide-menu class="h-5 w-5" />

            </button>


            {{-- Page Title --}}

            <div class="min-w-0">

                <h1 class="truncate text-lg font-black text-white sm:text-xl">

                    @yield('page-title', 'داشبورد')

                </h1>

                <p class="hidden truncate text-xs text-zinc-500 sm:block">

                    @yield('page-description', 'مدیریت نوبت‌ها و اطلاعات حساب کاربری')

                </p>

            </div>

        </div>



        {{-- =====================================================
            Left Side
        ====================================================== --}}

        <div class="flex shrink-0 items-center gap-2 sm:gap-3">


            {{-- =================================================
                Notifications
            ================================================== --}}

            <a
                href="{{ route('customer.notifications.index') }}"
                class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-zinc-800 bg-zinc-900 text-zinc-400 transition hover:border-orange-500/40 hover:text-orange-500 sm:h-11 sm:w-11"
                aria-label="اعلان‌ها"
            >

                <x-lucide-bell class="h-5 w-5" />


                @if(isset($notificationsCount) && $notificationsCount > 0)

                    <span
                        class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-orange-500 px-1 text-[10px] font-black text-black"
                    >

                        {{ $notificationsCount > 99 ? '99+' : $notificationsCount }}

                    </span>

                @endif

            </a>



            {{-- =================================================
                Profile
            ================================================== --}}

            <a
                href="{{ route('customer.settings.index') }}"
                class="flex items-center gap-2 rounded-xl border border-zinc-800 bg-zinc-900 px-2 py-2 transition hover:border-orange-500/40 sm:gap-3 sm:px-3"
            >

                {{-- User Info --}}

                <div class="hidden text-left sm:block">

                    <p class="max-w-32 truncate text-sm font-bold text-white">

                        {{ $fullName }}

                    </p>

                    <p class="text-[11px] text-zinc-500">

                        حساب کاربری

                    </p>

                </div>


                {{-- Avatar --}}

                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-sm font-black text-black sm:h-10 sm:w-10"
                >

                    {{ $initial }}

                </div>

            </a>

        </div>

    </div>

</header>
