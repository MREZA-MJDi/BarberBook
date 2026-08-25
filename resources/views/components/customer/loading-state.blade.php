{{-- resources/views/components/customer/loading-state.blade.php --}}

@props([
'text' => 'در حال دریافت اطلاعات...',
])

<div
    {{ $attributes->merge([
        'class' => '
            rounded-[28px]
            border
            border-border
            bg-surface
            px-6
            py-12
            text-center
        ',
    ]) }}
>

    {{-- =========================================================
        Spinner
    ========================================================== --}}

    <div
        class="
            mx-auto
            flex
            h-14
            w-14
            items-center
            justify-center
            rounded-2xl
            bg-primary/10
        "
        aria-hidden="true"
    >

        <span
            class="
                h-6
                w-6
                animate-spin
                rounded-full
                border-2
                border-primary/20
                border-t-primary
            "
        ></span>

    </div>


    {{-- =========================================================
        Message
    ========================================================== --}}

    <p
        class="
            mt-5
            text-sm
            font-bold
            text-muted
        "
    >
        {{ $text }}
    </p>

</div>
