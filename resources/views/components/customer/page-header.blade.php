@props([
'title' => '',
'description' => null,
'icon' => null,
])

<header class="mb-6 sm:mb-8">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        {{-- Title --}}

        <div class="flex min-w-0 items-center gap-3">

            @if($icon)

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10 text-orange-500"
                >

                    <x-dynamic-component
                        :component="'lucide-' . $icon"
                        class="h-5 w-5"
                    />

                </div>

            @endif

            <div class="min-w-0">

                <h1 class="truncate text-xl font-black text-white sm:text-2xl">

                    {{ $title }}

                </h1>

                @if($description)

                    <p class="mt-1 text-sm leading-6 text-zinc-500">

                        {{ $description }}

                    </p>

                @endif

            </div>

        </div>


        {{-- Actions --}}

        @if(isset($actions))

            <div class="flex shrink-0 flex-wrap items-center gap-2">

                {{ $actions }}

            </div>

        @endif

    </div>

</header>
