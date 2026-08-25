@props([
'title' => 'در حال بارگذاری...',
'description' => null,
])

<div
    {{ $attributes->merge([
        'class' => 'flex flex-col items-center justify-center rounded-2xl border border-zinc-800 bg-zinc-900/40 px-6 py-12 text-center sm:py-16',
    ]) }}
>

    {{-- Spinner --}}

    <div
        class="flex h-14 w-14 items-center justify-center rounded-2xl border border-orange-500/20 bg-orange-500/10"
    >

        <svg
            class="h-6 w-6 animate-spin text-orange-500"
            viewBox="0 0 24 24"
            fill="none"
        >

            <circle
                cx="12"
                cy="12"
                r="9"
                class="opacity-20"
                stroke="currentColor"
                stroke-width="3"
            />

            <path
                d="M21 12a9 9 0 0 0-9-9"
                stroke="currentColor"
                stroke-width="3"
                stroke-linecap="round"
            />

        </svg>

    </div>


    {{-- Title --}}

    <h3 class="mt-5 text-base font-black text-white sm:text-lg">

        {{ $title }}

    </h3>


    {{-- Description --}}

    @if($description)

        <p class="mt-2 max-w-md text-sm leading-6 text-zinc-500">

            {{ $description }}

        </p>

    @endif

</div>
