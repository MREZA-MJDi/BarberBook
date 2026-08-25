{{-- resources/views/components/customer/search.blade.php --}}

@props([
'name' => 'search',
'value' => null,
'placeholder' => 'جستجو کنید...',
'action' => null,
'method' => 'GET',
])

<form
    method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}"
    @if($action)
    action="{{ $action }}"
    @endif
    {{ $attributes->merge([
        'class' => 'w-full',
    ]) }}
>

    @if(strtoupper($method) !== 'GET')

        @csrf

    @endif


    <div
        class="
            relative
            flex
            items-center
        "
    >

        {{-- Search Icon --}}
        <div
            class="
                pointer-events-none
                absolute
                right-4
                flex
                items-center
                text-muted
            "
        >

            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <circle
                    cx="11"
                    cy="11"
                    r="7"
                />

                <path
                    stroke-linecap="round"
                    d="m20 20-4-4"
                />
            </svg>

        </div>


        {{-- Search Input --}}
        <input
            type="search"
            name="{{ $name }}"
            value="{{ $value ?? request($name) }}"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
            class="
                w-full
                rounded-2xl
                border
                border-border
                bg-surface
                py-3.5
                pl-14
                pr-12
                text-sm
                font-medium
                text-text
                outline-none
                transition
                placeholder:text-muted/60
                focus:border-primary
                focus:ring-2
                focus:ring-primary/10
            "
        />


        {{-- Clear --}}
        @if($value ?? request($name))

            <a
                href="{{ $action ?: url()->current() }}"
                class="
                    absolute
                    left-3
                    flex
                    h-8
                    w-8
                    items-center
                    justify-center
                    rounded-xl
                    text-muted
                    transition
                    hover:bg-background
                    hover:text-primary
                "
                aria-label="پاک کردن جستجو"
            >

                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        d="M6 6l12 12M18 6 6 18"
                    />
                </svg>

            </a>

        @endif

    </div>

</form>
