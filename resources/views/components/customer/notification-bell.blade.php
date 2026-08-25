@props([
'notifications' => collect(),
'notificationsCount' => 0,
])

@php
    $notifications = $notifications instanceof \Illuminate\Support\Collection
        ? $notifications
        : collect($notifications);

    $notificationsCount = (int) $notificationsCount;
@endphp

<div
    x-data="{ open: false }"
    class="relative"
>

    {{-- Bell Button --}}

    <button
        type="button"
        @click="open = !open"
        class="relative flex h-11 w-11 items-center justify-center rounded-xl border border-zinc-800 bg-zinc-900 text-zinc-400 transition hover:border-orange-500/30 hover:text-orange-500"
        aria-label="اعلان‌ها"
    >

        <x-lucide-bell class="h-5 w-5" />

        @if($notificationsCount > 0)

            <span
                class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-orange-500 px-1 text-[10px] font-black text-black"
            >
                {{ $notificationsCount > 99 ? '99+' : $notificationsCount }}
            </span>

        @endif

    </button>


    {{-- Dropdown --}}

    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        @click.outside="open = false"
        class="absolute left-0 top-full z-50 mt-3 w-[calc(100vw-2rem)] max-w-sm overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-950 shadow-2xl shadow-black/40"
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
                    آخرین اطلاع‌رسانی‌ها
                </p>

            </div>


            @if($notificationsCount > 0)

                <span class="text-xs font-bold text-orange-500">

                    {{ $notificationsCount }} جدید

                </span>

            @endif

        </div>


        {{-- Notifications --}}

        <div class="max-h-[360px] overflow-y-auto p-3">

            @forelse($notifications as $notification)

                @php
                    $bookingId = data_get($notification, 'booking_id');
                    $title = data_get($notification, 'title', 'اعلان جدید');
                    $message = data_get($notification, 'message');
                    $createdAt = data_get($notification, 'created_at');
                @endphp

                @if($bookingId)

                    <a
                        href="{{ route('customer.bookings.show', $bookingId) }}"
                        @click="open = false"
                        class="group flex items-start gap-3 rounded-xl p-3 transition hover:bg-zinc-900"
                    >

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10 text-orange-500"
                        >

                            <x-lucide-calendar-days class="h-4 w-4" />

                        </div>


                        <div class="min-w-0 flex-1">

                            <div class="flex items-start justify-between gap-2">

                                <p class="text-sm font-bold text-white">
                                    {{ $title }}
                                </p>

                                <span
                                    class="mt-1 h-2 w-2 shrink-0 rounded-full bg-orange-500"
                                ></span>

                            </div>


                            @if($message)

                                <p class="mt-1 line-clamp-2 text-xs leading-5 text-zinc-500">
                                    {{ $message }}
                                </p>

                            @endif


                            @if($createdAt)

                                <p class="mt-2 text-[10px] text-zinc-600">
                                    {{ $createdAt }}
                                </p>

                            @endif

                        </div>

                    </a>

                @else

                    <div
                        class="flex items-start gap-3 rounded-xl p-3"
                    >

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-zinc-800 bg-zinc-900 text-zinc-500"
                        >

                            <x-lucide-bell class="h-4 w-4" />

                        </div>


                        <div class="min-w-0">

                            <p class="text-sm font-bold text-white">
                                {{ $title }}
                            </p>

                            @if($message)

                                <p class="mt-1 text-xs leading-5 text-zinc-500">
                                    {{ $message }}
                                </p>

                            @endif

                        </div>

                    </div>

                @endif

            @empty

                <div class="px-4 py-8 text-center">

                    <div
                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl border border-zinc-800 bg-zinc-900 text-zinc-600"
                    >

                        <x-lucide-bell-off class="h-5 w-5" />

                    </div>


                    <p class="mt-3 text-sm font-semibold text-zinc-400">
                        اعلان جدیدی ندارید
                    </p>


                    <p class="mt-1 text-xs leading-5 text-zinc-600">
                        اعلان‌های مربوط به نوبت‌ها اینجا نمایش داده می‌شوند.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- Footer --}}

        <div class="border-t border-zinc-800 p-3">

            <a
                href="{{ route('customer.notifications.index') }}"
                @click="open = false"
                class="block rounded-xl py-2.5 text-center text-xs font-bold text-orange-500 transition hover:bg-orange-500/10"
            >

                مشاهده همه اعلان‌ها

            </a>

        </div>

    </div>

</div>
