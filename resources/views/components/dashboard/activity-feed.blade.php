@props([
'activities' => collect(),
])


{{-- =========================================================
    Recent Activities
========================================================= --}}

<div>

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>

            <h2 class="text-lg font-black tracking-tight text-white">
                فعالیت‌های اخیر
            </h2>

            <p class="mt-1 text-sm text-zinc-500">
                آخرین اتفاقات سالن
            </p>

        </div>


        {{-- Notification Icon --}}
        <div
            class="flex h-10 w-10 items-center justify-center rounded-xl
                   border border-orange-500/20
                   bg-orange-500/10"
        >

            <x-lucide-bell
                class="h-5 w-5 text-orange-500"
            />

        </div>

    </div>



    {{-- =====================================================
        Activities List
    ====================================================== --}}

    <div class="mt-6">

        @forelse($activities as $activity)

            @php

                $status = $activity->status;

                /*
                |--------------------------------------------------------------------------
                | Activity UI
                |--------------------------------------------------------------------------
                */

                $activityUi = match ($status) {

                    'pending' => [
                        'icon' => 'calendar-plus',
                        'iconBg' => 'bg-orange-500/10',
                        'iconColor' => 'text-orange-500',
                        'lineColor' => 'bg-orange-500/20',
                        'badge' => 'در انتظار',
                        'badgeBg' => 'bg-orange-500/10',
                        'badgeColor' => 'text-orange-400',
                    ],

                    'approved' => [
                        'icon' => 'circle-check',
                        'iconBg' => 'bg-green-500/10',
                        'iconColor' => 'text-green-500',
                        'lineColor' => 'bg-green-500/20',
                        'badge' => 'تایید شده',
                        'badgeBg' => 'bg-green-500/10',
                        'badgeColor' => 'text-green-400',
                    ],

                    'completed' => [
                        'icon' => 'check-check',
                        'iconBg' => 'bg-blue-500/10',
                        'iconColor' => 'text-blue-500',
                        'lineColor' => 'bg-blue-500/20',
                        'badge' => 'تکمیل شده',
                        'badgeBg' => 'bg-blue-500/10',
                        'badgeColor' => 'text-blue-400',
                    ],

                    'rejected' => [
                        'icon' => 'x',
                        'iconBg' => 'bg-red-500/10',
                        'iconColor' => 'text-red-500',
                        'lineColor' => 'bg-red-500/20',
                        'badge' => 'رد شده',
                        'badgeBg' => 'bg-red-500/10',
                        'badgeColor' => 'text-red-400',
                    ],

                    default => [
                        'icon' => 'activity',
                        'iconBg' => 'bg-zinc-800',
                        'iconColor' => 'text-zinc-400',
                        'lineColor' => 'bg-zinc-800',
                        'badge' => 'به‌روزرسانی',
                        'badgeBg' => 'bg-zinc-800',
                        'badgeColor' => 'text-zinc-400',
                    ],

                };


                /*
                |--------------------------------------------------------------------------
                | Activity Message
                |--------------------------------------------------------------------------
                */

                $message = match ($status) {

                    'pending' =>
                        $activity->customer_name . ' یک رزرو جدید ثبت کرد',

                    'approved' =>
                        'رزرو ' . $activity->customer_name . ' تایید شد',

                    'completed' =>
                        'رزرو ' . $activity->customer_name . ' تکمیل شد',

                    'rejected' =>
                        'رزرو ' . $activity->customer_name . ' رد شد',

                    default =>
                        'رزرو ' . $activity->customer_name . ' به‌روزرسانی شد',

                };

            @endphp



            {{-- =================================================
                Activity Item
            ================================================== --}}

            <a
                href="{{ route('bookings.show', $activity) }}"
                class="group relative flex gap-4 rounded-2xl
                       px-3 py-3
                       transition duration-200
                       hover:bg-zinc-900/70"
            >

                {{-- Timeline --}}
                @if(!$loop->last)

                    <div
                        class="absolute right-[27px] top-[48px]
                               h-[calc(100%-24px)]
                               w-px
                               {{ $activityUi['lineColor'] }}"
                    ></div>

                @endif



                {{-- =================================================
                    Activity Icon
                ================================================== --}}

                <div class="relative z-10 shrink-0">

                    <div
                        class="flex h-11 w-11 items-center justify-center
                               rounded-xl
                               border border-white/5
                               {{ $activityUi['iconBg'] }}
                            transition duration-200
                            group-hover:scale-105"
                    >

                        @switch($activityUi['icon'])

                            @case('calendar-plus')

                            <x-lucide-calendar-plus
                                class="h-5 w-5 {{ $activityUi['iconColor'] }}"
                            />

                            @break


                            @case('circle-check')

                            <x-lucide-circle-check
                                class="h-5 w-5 {{ $activityUi['iconColor'] }}"
                            />

                            @break


                            @case('check-check')

                            <x-lucide-check-check
                                class="h-5 w-5 {{ $activityUi['iconColor'] }}"
                            />

                            @break


                            @case('x')

                            <x-lucide-x
                                class="h-5 w-5 {{ $activityUi['iconColor'] }}"
                            />

                            @break


                            @default

                            <x-lucide-activity
                                class="h-5 w-5 {{ $activityUi['iconColor'] }}"
                            />

                        @endswitch

                    </div>

                </div>



                {{-- =================================================
                    Activity Content
                ================================================== --}}

                <div class="min-w-0 flex-1 pt-0.5">

                    {{-- Top Row --}}
                    <div class="flex items-start justify-between gap-3">

                        <p
                            class="text-sm font-bold leading-6 text-zinc-200
                                   transition group-hover:text-white"
                        >
                            {{ $message }}
                        </p>


                        {{-- Status Badge --}}
                        <span
                            class="hidden shrink-0 rounded-lg px-2 py-1
                                   text-[10px] font-bold
                                   sm:inline-flex
                                   {{ $activityUi['badgeBg'] }}
                            {{ $activityUi['badgeColor'] }}"
                        >
                            {{ $activityUi['badge'] }}
                        </span>

                    </div>



                    {{-- Bottom Row --}}
                    <div
                        class="mt-1.5 flex items-center gap-2"
                    >

                        <x-lucide-clock
                            class="h-3.5 w-3.5 text-zinc-600"
                        />

                        <span class="text-xs font-medium text-zinc-500">
                            {{ $activity->updated_at?->diffForHumans() }}
                        </span>

                    </div>



                    {{-- Mobile Badge --}}
                    <span
                        class="mt-2 inline-flex rounded-lg px-2 py-1
                               text-[10px] font-bold
                               sm:hidden
                               {{ $activityUi['badgeBg'] }}
                        {{ $activityUi['badgeColor'] }}"
                    >
                        {{ $activityUi['badge'] }}
                    </span>

                </div>

            </a>


        @empty


            {{-- =================================================
                Empty State
            ================================================== --}}

            <div
                class="rounded-2xl border border-dashed
                       border-zinc-800
                       bg-zinc-950/50
                       px-6 py-10 text-center"
            >

                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center
                           rounded-2xl
                           bg-zinc-900"
                >

                    <x-lucide-bell-off
                        class="h-6 w-6 text-zinc-700"
                    />

                </div>


                <p class="mt-4 text-sm font-bold text-zinc-400">
                    هنوز فعالیتی ثبت نشده
                </p>


                <p class="mx-auto mt-1 max-w-xs text-xs leading-5 text-zinc-600">
                    فعالیت‌های مربوط به رزروهای شما
                    اینجا نمایش داده می‌شوند.
                </p>

            </div>


        @endforelse

    </div>

</div>
