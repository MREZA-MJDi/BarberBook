@props([
'booking' => null,
])


{{-- Header --}}
<div class="flex items-center justify-between">

    <div>

        <h2 class="text-lg font-black text-white">
            رزرو بعدی
        </h2>

        <p class="mt-1 text-sm text-zinc-500">
            نزدیک‌ترین مشتری شما
        </p>

    </div>


    <div
        class="flex h-10 w-10 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10"
    >

        <x-lucide-calendar-clock
            class="h-5 w-5 text-orange-500"
        />

    </div>

</div>


{{-- Booking --}}
@if($booking)

    <div class="mt-6 rounded-xl border border-zinc-800 bg-zinc-950 p-5">

        <div class="flex items-center justify-between">


            {{-- Customer --}}
            <div class="flex items-center gap-4">

                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-500/10 font-black text-orange-500"
                >
                    {{ mb_substr($booking->customer_name, 0, 1) }}
                </div>


                <div>

                    <h3 class="font-bold text-white">
                        {{ $booking->customer_name }}
                    </h3>


                    <p class="mt-1 text-sm text-zinc-500">

                        @if($booking->service)
                            ✂ {{ $booking->service->name }}
                        @else
                            بدون خدمت
                        @endif

                    </p>

                </div>

            </div>


            {{-- Time --}}
            <div class="text-left">

                <p class="text-xs text-zinc-500">
                    ساعت
                </p>

                <p class="mt-1 text-xl font-black text-white">
                    {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                </p>

            </div>

        </div>


        {{-- Status --}}
        <div class="mt-5 flex items-center justify-between">


            @if($booking->status === 'pending')

                <span
                    class="rounded-full bg-orange-500/10 px-3 py-1 text-xs font-bold text-orange-400"
                >
                    در انتظار تایید
                </span>

            @elseif($booking->status === 'confirmed')

                <span
                    class="rounded-full bg-green-500/10 px-3 py-1 text-xs font-bold text-green-400"
                >
                    تایید شده
                </span>

            @elseif($booking->status === 'completed')

                <span
                    class="rounded-full bg-blue-500/10 px-3 py-1 text-xs font-bold text-blue-400"
                >
                    تکمیل شده
                </span>

            @elseif($booking->status === 'rejected')

                <span
                    class="rounded-full bg-red-500/10 px-3 py-1 text-xs font-bold text-red-400"
                >
                    رد شده
                </span>

            @else

                <span
                    class="rounded-full bg-zinc-500/10 px-3 py-1 text-xs font-bold text-zinc-400"
                >
                    {{ $booking->status }}
                </span>

            @endif


            <span class="text-xs text-zinc-500">
                امروز
            </span>

        </div>


        {{-- Actions --}}
        @if($booking->status === 'pending')

            <div class="mt-5 flex gap-3">


                {{-- Approve --}}
                <form
                    action="{{ route('bookings.approve', $booking) }}"
                    method="POST"
                    class="flex-1"
                >

                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-green-500/10 py-3 text-sm font-bold text-green-400 transition hover:bg-green-500/20"
                    >
                        تایید
                    </button>

                </form>


                {{-- Reject --}}
                <form
                    action="{{ route('bookings.reject', $booking) }}"
                    method="POST"
                    class="flex-1"
                >

                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-red-500/10 py-3 text-sm font-bold text-red-400 transition hover:bg-red-500/20"
                    >
                        رد
                    </button>

                </form>

            </div>

        @endif

    </div>


@else

    {{-- Empty State --}}
    <div
        class="mt-6 flex min-h-[220px] flex-col items-center justify-center rounded-xl border border-dashed border-zinc-800 bg-zinc-950 p-6 text-center"
    >

        <div
            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-zinc-900"
        >

            <x-lucide-calendar-check
                class="h-7 w-7 text-zinc-600"
            />

        </div>


        <h3 class="mt-4 font-bold text-white">
            رزرو بعدی وجود ندارد
        </h3>


        <p class="mt-2 max-w-xs text-sm text-zinc-500">
            فعلاً رزرو دیگری برای امروز ثبت نشده است.
        </p>

    </div>

@endif
