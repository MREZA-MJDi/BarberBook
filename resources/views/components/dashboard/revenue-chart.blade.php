@props([
'revenue' => [
'labels' => [],
'data' => [],
'current_month' => 0,
'previous_month' => 0,
'growth' => 0,
'goal' => 0,
'progress' => 0,
'total' => 0,
],
])


@php

    $labels = $revenue['labels'] ?? [];
    $data = $revenue['data'] ?? [];

    $currentMonth = $revenue['current_month'] ?? 0;
    $previousMonth = $revenue['previous_month'] ?? 0;
    $growth = $revenue['growth'] ?? 0;

    $goal = $revenue['goal'] ?? 0;
    $progress = $revenue['progress'] ?? 0;

    /*
    |--------------------------------------------------------------------------
    | Chart
    |--------------------------------------------------------------------------
    */

    $maxRevenue = max($data ?: [1]);

@endphp


<div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


    {{-- =========================================================
        Header
    ========================================================== --}}

    <div class="flex items-start justify-between gap-4">

        <div>

            <h2 class="text-lg font-black text-white">
                درآمد ماهانه
            </h2>

            <p class="mt-1 text-sm text-zinc-500">
                روند درآمد سالن در ۶ ماه اخیر
            </p>

        </div>


        <div
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10"
        >

            <x-lucide-chart-line
                class="h-5 w-5 text-orange-500"
            />

        </div>

    </div>


    {{-- =========================================================
        Revenue Summary
    ========================================================== --}}

    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">


        {{-- Current Month --}}

        <div class="rounded-xl bg-zinc-950 p-4">

            <p class="text-sm text-zinc-500">
                درآمد این ماه
            </p>

            <h3 class="mt-2 text-2xl font-black text-white">
                {{ number_format($currentMonth) }}
            </h3>

            <span class="text-xs text-zinc-500">
                تومان
            </span>

        </div>


        {{-- Monthly Goal --}}

        <div class="rounded-xl bg-zinc-950 p-4">

            <p class="text-sm text-zinc-500">
                هدف ماه
            </p>

            <h3 class="mt-2 text-2xl font-black text-white">
                {{ number_format($goal) }}
            </h3>

            <span class="text-xs text-zinc-500">
                تومان
            </span>

        </div>


        {{-- Growth --}}

        <div class="rounded-xl bg-zinc-950 p-4">

            <p class="text-sm text-zinc-500">
                رشد نسبت به ماه قبل
            </p>


            <h3
                class="mt-2 text-2xl font-black
                {{ $growth >= 0 ? 'text-green-400' : 'text-red-400' }}"
            >

                {{ $growth > 0 ? '+' : '' }}{{ $growth }}%

            </h3>


            <span class="text-xs text-zinc-500">

                نسبت به
                {{ number_format($previousMonth) }}
                تومان

            </span>

        </div>


    </div>


    {{-- =========================================================
        Monthly Goal Progress
    ========================================================== --}}

    <div class="mt-6">


        <div class="mb-2 flex items-center justify-between gap-4">

            <span class="text-sm text-zinc-400">
                پیشرفت هدف ماهانه
            </span>


            <span class="text-sm font-black text-white">
                {{ $progress }}%
            </span>

        </div>


        <div class="h-3 overflow-hidden rounded-full bg-zinc-800">

            <div
                class="h-full rounded-full bg-orange-500 transition-all duration-700"
                style="width: {{ $progress }}%"
            ></div>

        </div>


        <div class="mt-2 flex items-center justify-between text-xs text-zinc-600">

            <span>
                {{ number_format($currentMonth) }} تومان
            </span>

            <span>
                {{ number_format($goal) }} تومان
            </span>

        </div>


    </div>


    {{-- =========================================================
        Revenue Chart
    ========================================================== --}}

    @if(count($data))


        <div class="mt-8">


            {{-- Chart --}}

            <div class="flex h-44 items-end gap-2 sm:gap-3">


                @foreach($data as $index => $amount)

                    @php

                        $height = $maxRevenue > 0
                            ? round(($amount / $maxRevenue) * 100)
                            : 5;

                        $height = max(5, $height);

                        $label = $labels[$index] ?? '';

                    @endphp


                    <div
                        class="group relative flex h-full flex-1 items-end"
                    >


                        {{-- Tooltip --}}

                        <div
                            class="pointer-events-none absolute bottom-full left-1/2 z-10 mb-2 hidden -translate-x-1/2 whitespace-nowrap rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-xs font-bold text-white shadow-xl group-hover:block"
                        >

                            {{ number_format($amount) }}
                            تومان

                        </div>


                        {{-- Bar --}}

                        <div
                            class="w-full rounded-t-xl bg-orange-500/60 transition-all duration-500 hover:bg-orange-500"
                            style="height: {{ $height }}%"
                        ></div>


                    </div>

                @endforeach


            </div>


            {{-- Labels --}}

            <div class="mt-3 flex gap-2 sm:gap-3">


                @foreach($labels as $label)

                    <div
                        class="flex-1 truncate text-center text-[10px] text-zinc-600 sm:text-xs"
                    >

                        {{ $label }}

                    </div>

                @endforeach


            </div>


        </div>


    @else


        {{-- Empty Chart --}}

        <div
            class="mt-8 flex h-44 flex-col items-center justify-center rounded-xl border border-dashed border-zinc-800 bg-zinc-950"
        >

            <x-lucide-chart-no-axes-column
                class="h-8 w-8 text-zinc-700"
            />


            <p class="mt-3 text-sm font-bold text-zinc-500">
                هنوز اطلاعات درآمدی وجود ندارد
            </p>


            <p class="mt-1 text-xs text-zinc-600">
                پس از تکمیل رزروها، نمودار درآمد نمایش داده می‌شود.
            </p>

        </div>


    @endif


</div>

