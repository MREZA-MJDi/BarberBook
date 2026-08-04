@props([
'title',
'value',
'icon' => 'chart'
])


<div
    class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6 transition hover:border-orange-500/40">


    <div class="flex items-center justify-between">


        {{-- Icon --}}
        <div
            class="flex h-12 w-12 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10">


            @switch($icon)


                @case('calendar')

                <x-lucide-calendar-days
                    class="h-6 w-6 text-orange-500" />

                @break



                @case('clock')

                <x-lucide-clock-3
                    class="h-6 w-6 text-orange-500" />

                @break



                @case('scissors')

                <x-lucide-scissors
                    class="h-6 w-6 text-orange-500" />

                @break



                @case('users')

                <x-lucide-users
                    class="h-6 w-6 text-orange-500" />

                @break



                @default

                <x-lucide-chart-column
                    class="h-6 w-6 text-orange-500" />

            @endswitch


        </div>





        {{-- Action --}}
        <button
            type="button"
            class="text-zinc-500 transition hover:text-orange-500">


            <x-lucide-ellipsis
                class="h-5 w-5" />


        </button>


    </div>





    {{-- Content --}}
    <div class="mt-6">


        <p class="text-sm text-zinc-400">

            {{ $title }}

        </p>



        <h3
            class="mt-2 text-3xl font-black text-white">


            {{ $value }}


        </h3>


    </div>



</div>
