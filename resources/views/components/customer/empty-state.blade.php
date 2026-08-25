{{-- resources/views/components/customer/empty-state.blade.php --}}

@props([
'icon' => '📭',
'title' => 'موردی پیدا نشد',
'description' => null,
'actionUrl' => null,
'actionText' => null,
])

<div
    {{ $attributes->merge([
        'class' => '
            rounded-[28px]
            border
            border-border
            bg-surface
            px-6
            py-14
            text-center
        ',
    ]) }}
>

    {{-- =========================================================
        Icon
    ========================================================== --}}

    <div
        class="
            mx-auto
            flex
            h-16
            w-16
            items-center
            justify-center
            rounded-2xl
            bg-primary/10
            text-3xl
        "
    >
        {{ $icon }}
    </div>


    {{-- =========================================================
        Title
    ========================================================== --}}

    <h3
        class="
            mt-5
            text-xl
            font-black
            text-text
        "
    >
        {{ $title }}
    </h3>


    {{-- =========================================================
        Description
    ========================================================== --}}

    @if($description)

        <p
            class="
                mx-auto
                mt-3
                max-w-md
                leading-7
                text-muted
            "
        >
            {{ $description }}
        </p>

    @endif


    {{-- =========================================================
        Action
    ========================================================== --}}

    @if($actionUrl && $actionText)

        <div class="mt-6">

            <a
                href="{{ $actionUrl }}"
                class="
                    inline-flex
                    items-center
                    justify-center
                    rounded-2xl
                    bg-primary
                    px-6
                    py-3.5
                    text-sm
                    font-black
                    text-white
                    transition
                    hover:bg-primary-hover
                "
            >
                {{ $actionText }}
            </a>

        </div>

    @endif

</div>
