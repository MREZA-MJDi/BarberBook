@props([
'title',
'value',
'icon' => 'chart',
'description' => null,
'trend' => null,
])


<div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-5">


    {{-- Header --}}
    <div class="flex items-center justify-between">


        {{-- Icon --}}
        <div
            class="flex h-12 w-12 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10">


            @switch($icon)


                @case('calendar')

                <x-lucide-calendar-days
                    class="h-6 w-6 text-orange-500" />

                @break



                @case('money')

                <x-lucide-wallet
                    class="h-6 w-6 text-orange-500" />

                @break



                @case('users')

                <x-lucide-users
                    class="h-6 w-6 text-orange-500" />

                @break



                @case('target')

                <x-lucide-target
                    class="h-6 w-6 text-orange-500" />

                @break



                @default

                <x-lucide-chart-column
                    class="h-6 w-6 text-orange-500" />


            @endswitch


        </div>


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





    {{-- Footer --}}
    @if($description || $trend)

        <div class="mt-4 flex items-center justify-between">


            @if($description)

                <span class="text-xs text-zinc-500">

                    {{ $description }}

                </span>

            @endif



            @if($trend)

                <span class="text-xs font-bold text-green-400">

                    {{ $trend }}

                </span>

            @endif


        </div>

    @endif



</div>
