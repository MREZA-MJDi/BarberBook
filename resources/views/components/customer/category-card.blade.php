@props([
'title' => 'دسته‌بندی',
'description' => null,
'icon' => 'scissors',
'href' => '#',
'count' => null,
])

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => '
            group block
            rounded-2xl
            border border-zinc-800
            bg-zinc-900
            p-5
            transition-all duration-200
            hover:-translate-y-1
            hover:border-orange-500/30
            hover:bg-zinc-900/80
        '
    ]) }}
>

    <div class="flex items-center gap-4">

        {{-- Icon --}}
        <div
            class="
                flex h-14 w-14 shrink-0
                items-center justify-center
                rounded-2xl
                border border-orange-500/20
                bg-orange-500/10
                text-orange-500
                transition
                group-hover:bg-orange-500
                group-hover:text-black
            "
        >

            @switch($icon)

                @case('scissors')
                <x-lucide-scissors class="h-6 w-6" />
                @break

                @case('sparkles')
                <x-lucide-sparkles class="h-6 w-6" />
                @break

                @case('user')
                <x-lucide-user-round class="h-6 w-6" />
                @break

                @case('heart')
                <x-lucide-heart class="h-6 w-6" />
                @break

                @case('calendar')
                <x-lucide-calendar-days class="h-6 w-6" />
                @break

                @default
                <x-lucide-grid-2x2 class="h-6 w-6" />

            @endswitch

        </div>


        {{-- Content --}}
        <div class="min-w-0 flex-1">

            <div class="flex items-center justify-between gap-3">

                <h3
                    class="
                        truncate
                        text-sm
                        font-black
                        text-white
                        transition
                        group-hover:text-orange-400
                    "
                >
                    {{ $title }}
                </h3>

                <x-lucide-chevron-left
                    class="
                        h-5 w-5
                        shrink-0
                        text-zinc-600
                        transition
                        group-hover:-translate-x-1
                        group-hover:text-orange-500
                    "
                />

            </div>


            @if($description)

                <p
                    class="
                        mt-1
                        line-clamp-2
                        text-xs
                        leading-5
                        text-zinc-500
                    "
                >
                    {{ $description }}
                </p>

            @endif


            @if($count !== null)

                <div class="mt-3">

                    <span
                        class="
                            inline-flex
                            items-center
                            gap-1.5
                            rounded-lg
                            bg-zinc-800
                            px-2.5
                            py-1
                            text-[11px]
                            font-bold
                            text-zinc-400
                        "
                    >

                        <x-lucide-layers-3 class="h-3.5 w-3.5" />

                        {{ $count }} مورد

                    </span>

                </div>

            @endif

        </div>

    </div>

</a>
