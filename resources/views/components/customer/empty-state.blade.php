@props([
'title' => 'موردی پیدا نشد',
'description' => null,
'icon' => 'inbox',
])

<div
    {{ $attributes->merge([
        'class' => 'flex flex-col items-center justify-center rounded-2xl border border-dashed border-zinc-800 bg-zinc-900/40 px-6 py-12 text-center sm:py-16',
    ]) }}
>

    {{-- Icon --}}

    <div
        class="flex h-14 w-14 items-center justify-center rounded-2xl border border-zinc-800 bg-zinc-950 text-zinc-600"
    >

        <x-dynamic-component
            :component="'lucide-' . $icon"
            class="h-6 w-6"
        />

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


    {{-- Action --}}

    @if(isset($action))

        <div class="mt-5">

            {{ $action }}

        </div>

    @endif

</div>
