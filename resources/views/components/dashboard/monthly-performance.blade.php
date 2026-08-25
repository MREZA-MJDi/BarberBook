{{-- resources/views/components/dashboard/monthly-performance.blade.php --}}

@props([
'performance' => [
'bookings' => 0,
'completed' => 0,
'cancelled' => 0,
'revenue' => 0,
'growth' => 0,
],
])


<section
    class="rounded-2xl border border-zinc-800 bg-zinc-900 p-5 sm:p-6"
>

    {{-- =====================================================
        Header
    ====================================================== --}}

    <div class="flex items-start justify-between gap-4">

        <div>

            <h2 class="text-lg font-black text-white">
                عملکرد این ماه
            </h2>

            <p class="mt-1 text-sm text-zinc-500">
                خلاصه عملکرد سالن در ماه جاری
            </p>

        </div>


        <div
            class="flex h-10 w-10 shrink-0 items-center justify-center
                   rounded-xl border border-orange-500/20
                   bg-orange-500/10"
        >

            <x-lucide-chart-no-axes-combined
                class="h-5 w-5 text-orange-500"
            />

        </div>

    </div>



    {{-- =====================================================
        Stats
    ====================================================== --}}

    <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">


        {{-- Bookings --}}

        <div
            class="rounded-xl border border-zinc-800 bg-zinc-950 p-4"
        >

            <p class="text-xs font-medium text-zinc-500">
                رزروها
            </p>

            <p class="mt-2 text-xl font-black text-white">
                {{ number_format($performance['bookings']) }}
            </p>

        </div>



        {{-- Completed --}}

        <div
            class="rounded-xl border border-zinc-800 bg-zinc-950 p-4"
        >

            <p class="text-xs font-medium text-zinc-500">
                تکمیل‌شده
            </p>

            <p class="mt-2 text-xl font-black text-green-400">
                {{ number_format($performance['completed']) }}
            </p>

        </div>



        {{-- Cancelled --}}

        <div
            class="rounded-xl border border-zinc-800 bg-zinc-950 p-4"
        >

            <p class="text-xs font-medium text-zinc-500">
                لغوشده
            </p>

            <p class="mt-2 text-xl font-black text-red-400">
                {{ number_format($performance['cancelled']) }}
            </p>

        </div>



        {{-- Revenue --}}

        <div
            class="rounded-xl border border-zinc-800 bg-zinc-950 p-4"
        >

            <p class="text-xs font-medium text-zinc-500">
                درآمد
            </p>

            <p class="mt-2 text-xl font-black text-orange-400">
                {{ number_format($performance['revenue']) }}
            </p>

            <p class="mt-1 text-[11px] text-zinc-600">
                تومان
            </p>

        </div>

    </div>



    {{-- =====================================================
        Growth
    ====================================================== --}}

    <div
        class="mt-5 flex flex-wrap items-center justify-between gap-3
               rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3"
    >

        <div class="flex items-center gap-2">

            @if($performance['growth'] > 0)

                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg
                           bg-green-500/10"
                >

                    <x-lucide-trending-up
                        class="h-4 w-4 text-green-400"
                    />

                </div>

                <span class="text-sm font-bold text-green-400">
                    +{{ $performance['growth'] }}%
                </span>

            @elseif($performance['growth'] < 0)

                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg
                           bg-red-500/10"
                >

                    <x-lucide-trending-down
                        class="h-4 w-4 text-red-400"
                    />

                </div>

                <span class="text-sm font-bold text-red-400">
                    {{ $performance['growth'] }}%
                </span>

            @else

                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg
                           bg-zinc-800"
                >

                    <x-lucide-minus
                        class="h-4 w-4 text-zinc-500"
                    />

                </div>

                <span class="text-sm font-bold text-zinc-400">
                    بدون تغییر
                </span>

            @endif

        </div>


        <span class="text-xs text-zinc-500">
            نسبت به ماه قبل
        </span>

    </div>

</section>
