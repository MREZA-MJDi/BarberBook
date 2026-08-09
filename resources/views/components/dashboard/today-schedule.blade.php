{{-- resources/views/components/dashboard/today-schedule.blade.php --}}

@props([
'bookings' => collect(),
])


{{-- =========================================================
    Header
========================================================== --}}

<div>

    <h2 class="text-lg font-black text-white">
        برنامه امروز
    </h2>

    <p class="mt-1 text-sm text-zinc-500">
        زمان‌بندی رزروهای امروز
    </p>

</div>


<div
    class="flex h-10 w-10 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10"
>

    <x-lucide-clock-3
        class="h-5 w-5 text-orange-500"
    />

</div>



{{-- =========================================================
    Timeline
========================================================== --}}

@if($bookings->count())

    <div class="mt-6 space-y-5">

        @foreach($bookings->sortBy('booking_time') as $booking)

            <div class="flex gap-4">


                {{-- Time --}}

                <div class="w-16 shrink-0">

                    <span class="text-sm font-black text-white">
                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                    </span>

                </div>



                {{-- Timeline --}}

                <div class="relative">

                    <div class="h-full w-px bg-zinc-800"></div>

                    <div
                        class="absolute left-1/2 top-1 h-3 w-3 -translate-x-1/2 rounded-full bg-orange-500"
                    ></div>

                </div>



                {{-- Content --}}

                <div
                    class="flex-1 rounded-xl border border-zinc-800 bg-zinc-950 p-4"
                >

                    <div class="flex items-center justify-between gap-4">


                        <div>

                            <h4 class="font-bold text-white">
                                {{ $booking->customer_name }}
                            </h4>


                            <p class="mt-1 text-sm text-zinc-500">

                                @if($booking->service)

                                    ✂ {{ $booking->service->name }}

                                @else

                                    بدون خدمت

                                @endif

                            </p>

                        </div>



                        {{-- Status --}}

                        @if($booking->status === 'pending')

                            <span
                                class="shrink-0 rounded-full bg-orange-500/10 px-3 py-1 text-xs font-bold text-orange-400"
                            >
                                در انتظار
                            </span>


                        @elseif($booking->status === 'approved')

                            <span
                                class="shrink-0 rounded-full bg-green-500/10 px-3 py-1 text-xs font-bold text-green-400"
                            >
                                تایید شده
                            </span>


                        @elseif($booking->status === 'completed')

                            <span
                                class="shrink-0 rounded-full bg-blue-500/10 px-3 py-1 text-xs font-bold text-blue-400"
                            >
                                تکمیل شده
                            </span>


                        @elseif($booking->status === 'rejected')

                            <span
                                class="shrink-0 rounded-full bg-red-500/10 px-3 py-1 text-xs font-bold text-red-400"
                            >
                                رد شده
                            </span>


                        @elseif($booking->status === 'cancelled')

                            <span
                                class="shrink-0 rounded-full bg-red-500/10 px-3 py-1 text-xs font-bold text-red-400"
                            >
                                لغو شده
                            </span>


                        @else

                            <span
                                class="shrink-0 rounded-full bg-zinc-500/10 px-3 py-1 text-xs font-bold text-zinc-400"
                            >
                                {{ $booking->status }}
                            </span>

                        @endif

                    </div>



                    {{-- Reference --}}

                    <div class="mt-3">

                        <span class="text-xs text-zinc-600">
                            #{{ $booking->reference_code }}
                        </span>

                    </div>

                </div>

            </div>

        @endforeach

    </div>


@else


    {{-- =========================================================
        Empty State
    ========================================================== --}}

    <div
        class="mt-6 flex min-h-[220px] flex-col items-center justify-center rounded-xl border border-dashed border-zinc-800 bg-zinc-950 p-6 text-center"
    >

        <div
            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-zinc-900"
        >

            <x-lucide-calendar-x
                class="h-7 w-7 text-zinc-600"
            />

        </div>


        <h3 class="mt-4 font-bold text-white">
            امروز رزروی نداری
        </h3>


        <p class="mt-2 max-w-xs text-sm text-zinc-500">
            وقتی مشتری رزرو جدیدی ثبت کند، برنامه اینجا نمایش داده می‌شود.
        </p>

    </div>

@endif

