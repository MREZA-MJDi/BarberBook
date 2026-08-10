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


    <div class="flex min-h-[80px] items-center justify-between gap-6 px-4 sm:px-6 lg:px-8">


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

            <div
                class="relative"
                x-data="{ open: false }"
            >

                <button
                    type="button"
                    @click="open = !open"
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



                {{-- Notification Dropdown --}}

                <div
                    x-show="open"
                    x-transition
                    @click.outside="open = false"
                    style="display: none;"
                    class="absolute left-0 z-50 mt-3 w-[360px] overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-950 shadow-2xl"
                >

                    {{-- Header --}}

                    <div
                        class="flex items-center justify-between border-b border-zinc-800 px-4 py-4"
                    >

                        <div>

                            <h3 class="text-sm font-black text-white">
                                اعلان‌ها
                            </h3>

                            <p class="mt-1 text-xs text-zinc-500">
                                آخرین اعلان‌های سالن
                            </p>

                        </div>


                        @if($notificationsCount > 0)

                            <span class="text-xs font-bold text-orange-500">
                            {{ $notificationsCount }} جدید
                        </span>

                        @endif

                    </div>


                    {{-- Notification List --}}

                    <div class="max-h-[420px] space-y-2 overflow-y-auto p-3">

                        @forelse($notifications as $notification)

                            <div
                                class="flex items-start gap-3 rounded-xl border border-zinc-800 bg-zinc-900/60 p-3 transition hover:border-orange-500/30 hover:bg-zinc-900"
                            >

                                {{-- Icon --}}

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10 text-orange-500"
                                >

                                    @if(($notification['type'] ?? null) === 'success')

                                        <x-lucide-check class="h-5 w-5" />

                                    @else

                                        <x-lucide-calendar-days class="h-5 w-5" />

                                    @endif

                                </div>


                                {{-- Content --}}

                                <div class="min-w-0 flex-1">

                                    <p class="text-sm font-bold text-white">
                                        {{ $notification['title'] ?? 'اعلان جدید' }}
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-zinc-400">
                                        {{ $notification['message'] ?? '' }}
                                    </p>

                                    @if(!empty($notification['time']))

                                        <span class="mt-2 block text-[11px] text-zinc-600">
                                        {{ $notification['time'] }}
                                    </span>

                                    @endif

                                </div>

                            </div>

                        @empty

                            <div class="px-4 py-10 text-center">

                                <div
                                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl border border-zinc-800 bg-zinc-900 text-zinc-600"
                                >

                                    <x-lucide-bell-off class="h-5 w-5" />

                                </div>

                                <p class="mt-3 text-sm font-semibold text-zinc-400">
                                    اعلان جدیدی وجود ندارد.
                                </p>

                                <p class="mt-1 text-xs text-zinc-600">
                                    وقتی رزرو جدیدی ثبت شود اینجا نمایش داده می‌شود.
                                </p>

                            </div>

                        @endforelse

                    </div>


                    {{-- Footer --}}

                    <div class="border-t border-zinc-800 p-3">

                        <a
                            href="#"
                            class="block rounded-xl py-2.5 text-center text-xs font-bold text-orange-500 transition hover:bg-orange-500/10"
                        >
                            مشاهده همه اعلان‌ها
                        </a>

                    </div>

                </div>

            </div>



            {{-- =================================================
                Profile
            ================================================== --}}

            <div
                class="relative hidden sm:block"
                x-data="{ open: false }"
            >

                {{-- Profile Button --}}

                <button
                    type="button"
                    @click="open = !open"
                    class="flex items-center gap-3 rounded-xl border border-zinc-800 bg-zinc-900 px-3 py-2 text-right transition hover:border-orange-500/40"
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


                    {{-- Chevron --}}

                    <x-lucide-chevron-down
                        class="h-4 w-4 text-zinc-500 transition"
                        x-bind:class="{ 'rotate-180': open }"
                    />

                </button>


                {{-- Profile Dropdown --}}

                <div
                    x-show="open"
                    x-transition
                    @click.outside="open = false"
                    style="display: none;"
                    class="absolute left-0 z-50 mt-3 w-64 overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-950 shadow-2xl"
                >

                    {{-- User Summary --}}

                    <div class="border-b border-zinc-800 px-4 py-4">

                        <p class="text-sm font-bold text-white">
                            {{ $fullName }}
                        </p>

                        <p class="mt-1 text-xs text-zinc-500">
                            {{ $salon?->name ?? 'مدیریت سالن' }}
                        </p>

                    </div>


                    {{-- Profile Link --}}

                    <div class="p-2">

                        <a
                            href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-zinc-300 transition hover:bg-zinc-900 hover:text-orange-500"
                        >

                            <x-lucide-user-round class="h-4 w-4" />

                            <span>
                            پروفایل من
                        </span>

                        </a>


                        {{-- Logout --}}

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-red-400 transition hover:bg-red-500/10 hover:text-red-300"
                            >

                                <x-lucide-log-out class="h-4 w-4" />

                                <span>
                                خروج از حساب
                            </span>

                            </button>

                        </form>

                    </div>

                </div>

            </div>


        </div>

    </div>


</header>
