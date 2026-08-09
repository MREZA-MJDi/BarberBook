{{-- resources/views/components/dashboard/topbar.blade.php --}}

@php

    $user = auth()->user();

    $salon = $user?->salon;

    $fullName = $user?->full_name ?? 'آرایشگر';

    $initial = mb_substr($fullName, 0, 1);

    $notifications = $topbarNotifications ?? collect();

    $notificationsCount = $topbarNotificationsCount ?? 0;

@endphp


{{-- =========================================================
    Topbar
========================================================== --}}

<header
    class="sticky top-0 z-40 border-b border-zinc-800 bg-zinc-950/95 backdrop-blur"
>

    <div
        class="flex min-h-[80px] items-center justify-between gap-6 px-4 sm:px-6 lg:px-8"
    >


        {{-- =====================================================
            Right Side
        ====================================================== --}}

        <div class="flex items-center gap-4">


            {{-- Mobile Menu --}}

            <button
                type="button"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-zinc-800 text-zinc-400 transition hover:border-orange-500/40 hover:text-orange-500 lg:hidden"
            >

                <x-lucide-menu class="h-5 w-5" />

            </button>


            {{-- Page Identity --}}

            <div>

                <h2 class="text-xl font-black text-white">
                    پنل مدیریت
                </h2>

                <p class="text-sm text-zinc-500">
                    {{ $salon?->name ?? 'مدیریت آرایشگاه و رزروها' }}
                </p>

            </div>

        </div>



        {{-- =====================================================
            Left Side
        ====================================================== --}}

        <div class="flex items-center gap-4">


            {{-- =================================================
                Notifications
            ================================================== --}}

            <div class="relative">

                <button
                    type="button"
                    class="relative flex h-11 w-11 items-center justify-center rounded-xl border border-zinc-800 bg-zinc-900 text-zinc-400 transition hover:border-orange-500/40 hover:text-orange-500"
                >

                    <x-lucide-bell class="h-5 w-5" />


                    @if($notificationsCount > 0)

                        <span
                            class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-orange-500 px-1 text-xs font-black text-black"
                        >

                            {{ $notificationsCount > 99 ? '99+' : $notificationsCount }}

                        </span>

                    @endif

                </button>

            </div>



            {{-- =================================================
                Profile
            ================================================== --}}

            <div
                class="hidden items-center gap-3 rounded-xl border border-zinc-800 bg-zinc-900 px-3 py-2 sm:flex"
            >


                {{-- User Info --}}

                <div class="text-left">

                    <p class="text-sm font-bold text-white">
                        {{ $fullName }}
                    </p>

                    <p class="text-xs text-zinc-500">
                        {{ $salon?->name ?? 'مدیریت سالن' }}
                    </p>

                </div>



                {{-- Avatar --}}

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-orange-500 font-black text-black"
                >

                    {{ $initial }}

                </div>


            </div>


        </div>


    </div>

</header>

