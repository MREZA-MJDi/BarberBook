{{-- resources/views/components/dashboard/topbar.blade.php --}}

@php

    use App\Models\Booking;

    $user = auth()->user();

    $salon = $user?->salon;

    $fullName = $user?->full_name ?? 'آرایشگر';

    $initial = mb_substr($fullName, 0, 1);


    /*
    |--------------------------------------------------------------------------
    | Recent Booking Notifications
    |--------------------------------------------------------------------------
    |
    | فعلاً Notification را از رزروهای pending خود سالن می‌گیریم.
    | بنابراین به محض ثبت رزرو جدید توسط مشتری، اینجا قابل نمایش است.
    |
    */

    $notifications = collect();

    if ($salon) {

        $notifications = Booking::query()
            ->where('salon_id', $salon->id)
            ->where('status', 'pending')
            ->latest('created_at')
            ->take(8)
            ->get()
            ->map(function (Booking $booking) {

                return [
                    'booking_id' => $booking->id,

                    'title' => 'رزرو جدید',

                    'message' =>
                        ($booking->customer_name ?? 'مشتری') .
                        ' یک نوبت جدید ثبت کرده است.',

                    'date' => $booking->booking_date
                        ? \Carbon\Carbon::parse($booking->booking_date)
                            ->locale('fa')
                            ->translatedFormat('j F')
                        : null,

                    'time' => $booking->booking_time
                        ? substr($booking->booking_time, 0, 5)
                        : null,

                    'created_at' => $booking->created_at
                        ? $booking->created_at
                            ->locale('fa')
                            ->diffForHumans()
                        : null,
                ];

            });

    }

    $notificationsCount = $notifications->count();

@endphp


{{-- =========================================================
    TOPBAR
========================================================== --}}

<header
    class="
        sticky
        top-0
        z-40
        border-b
        border-zinc-800
        bg-zinc-950/95
        backdrop-blur-xl
    "
>

    <div
        class="
            flex
            min-h-[72px]
            items-center
            justify-between
            gap-3
            px-4
            sm:min-h-[80px]
            sm:px-6
            lg:px-8
        "
    >

        {{-- =====================================================
            Right Side
        ====================================================== --}}

        <div
            class="
                flex
                min-w-0
                items-center
                gap-3
                sm:gap-4
            "
        >

            {{-- Mobile Menu --}}

            <button
                type="button"
                @click="$dispatch('sidebar-open')"
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
                    active:scale-95
                    lg:hidden
                "
                aria-label="باز کردن منوی داشبورد"
            >

                <x-lucide-menu class="h-5 w-5" />

            </button>


            {{-- Page Identity --}}

            <div class="min-w-0">

                <h2
                    class="
                        truncate
                        text-base
                        font-black
                        text-white
                        sm:text-xl
                    "
                >
                    پنل مدیریت
                </h2>

                <p
                    class="
                        mt-0.5
                        truncate
                        text-[11px]
                        text-zinc-500
                        sm:text-sm
                    "
                >
                    {{ $salon?->name ?? 'مدیریت آرایشگاه و رزروها' }}
                </p>

            </div>

        </div>


        {{-- =====================================================
            Left Side
        ====================================================== --}}

        <div
            class="
                flex
                shrink-0
                items-center
                gap-2
                sm:gap-3
            "
        >

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
                    class="
                        relative
                        flex
                        h-10
                        w-10
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
                        active:scale-95
                        sm:h-11
                        sm:w-11
                    "
                    aria-label="اعلان‌ها"
                >

                    <x-lucide-bell class="h-5 w-5" />


                    @if($notificationsCount > 0)

                        <span
                            class="
                                absolute
                                -right-1
                                -top-1
                                flex
                                h-5
                                min-w-5
                                items-center
                                justify-center
                                rounded-full
                                bg-orange-500
                                px-1
                                text-[10px]
                                font-black
                                text-black
                            "
                        >
                            {{ $notificationsCount > 99 ? '99+' : $notificationsCount }}
                        </span>

                    @endif

                </button>


                {{-- Notification Dropdown --}}

                <div
                    x-show="open"
                    x-cloak
                    x-transition
                    @click.outside="open = false"
                    class="
                        absolute
                        left-0
                        z-[100]
                        mt-3
                        w-[calc(100vw-2rem)]
                        max-w-[360px]
                        overflow-hidden
                        rounded-2xl
                        border
                        border-zinc-800
                        bg-zinc-950
                        shadow-2xl
                        sm:w-[360px]
                    "
                >

                    {{-- Header --}}

                    <div
                        class="
                            flex
                            items-center
                            justify-between
                            gap-3
                            border-b
                            border-zinc-800
                            px-4
                            py-4
                        "
                    >

                        <div>

                            <h3 class="text-sm font-black text-white">
                                اعلان‌ها
                            </h3>

                            <p class="mt-1 text-xs text-zinc-500">
                                رزروهای جدید سالن
                            </p>

                        </div>


                        @if($notificationsCount > 0)

                            <span
                                class="
                                    shrink-0
                                    text-xs
                                    font-bold
                                    text-orange-500
                                "
                            >
                                {{ $notificationsCount }} جدید
                            </span>

                        @endif

                    </div>


                    {{-- Notification List --}}

                    <div
                        class="
                            max-h-[60vh]
                            space-y-2
                            overflow-y-auto
                            p-3
                        "
                    >

                        @forelse($notifications as $notification)

                            <a
                                href="{{ route('bookings.show', $notification['booking_id']) }}"
                                @click="open = false"
                                class="
                                    group
                                    flex
                                    items-start
                                    gap-3
                                    rounded-xl
                                    border
                                    border-zinc-800
                                    bg-zinc-900/60
                                    p-3
                                    transition
                                    hover:border-orange-500/40
                                    hover:bg-zinc-900
                                "
                            >

                                {{-- Icon --}}

                                <div
                                    class="
                                        flex
                                        h-10
                                        w-10
                                        shrink-0
                                        items-center
                                        justify-center
                                        rounded-xl
                                        border
                                        border-orange-500/20
                                        bg-orange-500/10
                                        text-orange-500
                                    "
                                >

                                    <x-lucide-calendar-days class="h-5 w-5" />

                                </div>


                                {{-- Content --}}

                                <div class="min-w-0 flex-1">

                                    <div
                                        class="
                                            flex
                                            items-start
                                            justify-between
                                            gap-2
                                        "
                                    >

                                        <p
                                            class="
                                                truncate
                                                text-sm
                                                font-bold
                                                text-white
                                            "
                                        >
                                            {{ $notification['title'] }}
                                        </p>


                                        <span
                                            class="
                                                mt-1
                                                h-2
                                                w-2
                                                shrink-0
                                                rounded-full
                                                bg-orange-500
                                            "
                                        ></span>

                                    </div>


                                    <p
                                        class="
                                            mt-1
                                            text-xs
                                            leading-5
                                            text-zinc-400
                                        "
                                    >
                                        {{ $notification['message'] }}
                                    </p>


                                    @if(
                                        $notification['date'] ||
                                        $notification['time']
                                    )

                                        <div
                                            class="
                                                mt-2
                                                flex
                                                flex-wrap
                                                items-center
                                                gap-x-3
                                                gap-y-1
                                            "
                                        >

                                            @if($notification['date'])

                                                <span
                                                    class="
                                                        inline-flex
                                                        items-center
                                                        gap-1
                                                        text-[10px]
                                                        text-zinc-500
                                                    "
                                                >

                                                    <x-lucide-calendar
                                                        class="h-3.5 w-3.5"
                                                    />

                                                    {{ $notification['date'] }}

                                                </span>

                                            @endif


                                            @if($notification['time'])

                                                <span
                                                    class="
                                                        inline-flex
                                                        items-center
                                                        gap-1
                                                        text-[10px]
                                                        font-bold
                                                        text-orange-400
                                                    "
                                                >

                                                    <x-lucide-clock
                                                        class="h-3.5 w-3.5"
                                                    />

                                                    {{ $notification['time'] }}

                                                </span>

                                            @endif

                                        </div>

                                    @endif


                                    <div
                                        class="
                                            mt-2
                                            flex
                                            items-center
                                            justify-between
                                            gap-2
                                        "
                                    >

                                        @if($notification['created_at'])

                                            <span
                                                class="
                                                    truncate
                                                    text-[10px]
                                                    text-zinc-600
                                                "
                                            >
                                                {{ $notification['created_at'] }}
                                            </span>

                                        @endif


                                        <span
                                            class="
                                                flex
                                                shrink-0
                                                items-center
                                                gap-1
                                                text-[10px]
                                                font-bold
                                                text-zinc-600
                                                transition
                                                group-hover:text-orange-400
                                            "
                                        >

                                            مشاهده رزرو

                                            <x-lucide-arrow-left
                                                class="h-3 w-3"
                                            />

                                        </span>

                                    </div>

                                </div>

                            </a>

                        @empty

                            <div class="px-4 py-10 text-center">

                                <div
                                    class="
                                        mx-auto
                                        flex
                                        h-12
                                        w-12
                                        items-center
                                        justify-center
                                        rounded-2xl
                                        border
                                        border-zinc-800
                                        bg-zinc-900
                                        text-zinc-600
                                    "
                                >

                                    <x-lucide-bell-off class="h-5 w-5" />

                                </div>


                                <p
                                    class="
                                        mt-3
                                        text-sm
                                        font-semibold
                                        text-zinc-400
                                    "
                                >
                                    اعلان جدیدی وجود ندارد.
                                </p>


                                <p
                                    class="
                                        mt-1
                                        text-xs
                                        leading-5
                                        text-zinc-600
                                    "
                                >
                                    وقتی رزرو جدیدی ثبت شود اینجا نمایش داده می‌شود.
                                </p>

                            </div>

                        @endforelse

                    </div>


                    {{-- Footer --}}

                    <div class="border-t border-zinc-800 p-3">

                        <a
                            href="{{ route('bookings.index') }}"
                            @click="open = false"
                            class="
                                block
                                rounded-xl
                                py-2.5
                                text-center
                                text-xs
                                font-bold
                                text-orange-500
                                transition
                                hover:bg-orange-500/10
                            "
                        >
                            مشاهده رزروها
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

                <button
                    type="button"
                    @click="open = !open"
                    class="
                        flex
                        items-center
                        gap-3
                        rounded-xl
                        border
                        border-zinc-800
                        bg-zinc-900
                        px-3
                        py-2
                        text-right
                        transition
                        hover:border-orange-500/40
                    "
                >

                    <div class="text-left">

                        <p class="text-sm font-bold text-white">
                            {{ $fullName }}
                        </p>

                        <p class="text-xs text-zinc-500">
                            {{ $salon?->name ?? 'مدیریت سالن' }}
                        </p>

                    </div>


                    <div
                        class="
                            flex
                            h-11
                            w-11
                            shrink-0
                            items-center
                            justify-center
                            rounded-xl
                            bg-orange-500
                            font-black
                            text-black
                        "
                    >
                        {{ $initial }}
                    </div>


                    <x-lucide-chevron-down
                        class="h-4 w-4 text-zinc-500 transition"
                        x-bind:class="{ 'rotate-180': open }"
                    />

                </button>


                {{-- Profile Dropdown --}}

                <div
                    x-show="open"
                    x-cloak
                    x-transition
                    @click.outside="open = false"
                    class="
                        absolute
                        left-0
                        z-[100]
                        mt-3
                        w-64
                        overflow-hidden
                        rounded-2xl
                        border
                        border-zinc-800
                        bg-zinc-950
                        shadow-2xl
                    "
                >

                    <div class="border-b border-zinc-800 px-4 py-4">

                        <p class="text-sm font-bold text-white">
                            {{ $fullName }}
                        </p>

                        <p class="mt-1 text-xs text-zinc-500">
                            {{ $salon?->name ?? 'مدیریت سالن' }}
                        </p>

                    </div>


                    <div class="p-2">

                        <a
                            href="{{ route('profile.edit') }}"
                            class="
                                flex
                                items-center
                                gap-3
                                rounded-xl
                                px-3
                                py-3
                                text-sm
                                font-semibold
                                text-zinc-300
                                transition
                                hover:bg-zinc-900
                                hover:text-orange-500
                            "
                        >

                            <x-lucide-user-round class="h-4 w-4" />

                            پروفایل من

                        </a>


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
                                    gap-3
                                    rounded-xl
                                    px-3
                                    py-3
                                    text-sm
                                    font-semibold
                                    text-red-400
                                    transition
                                    hover:bg-red-500/10
                                    hover:text-red-300
                                "
                            >

                                <x-lucide-log-out class="h-4 w-4" />

                                خروج از حساب

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</header>
