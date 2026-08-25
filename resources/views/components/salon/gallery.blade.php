@props([
'salon',
'galleryItems' => collect(),
'hasMore' => false,
'totalCount' => 0,
])

<section
    id="gallery"
    class="
        border-t
        border-border
        bg-background
        py-14
        sm:py-16
        lg:py-20
    "
    dir="rtl"
>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


        {{-- =========================================================
            Header
        ========================================================== --}}

        <div>

            <span
                class="
                    inline-flex
                    items-center
                    gap-2
                    text-xs
                    font-black
                    text-primary
                "
            >

                <span class="h-px w-8 bg-primary"></span>

                نمونه‌کارها

            </span>


            <h2
                class="
                    mt-3
                    text-2xl
                    font-black
                    text-text
                    sm:text-3xl
                "
            >
                قبل و بعد
            </h2>


            <p class="mt-2 max-w-2xl text-sm leading-7 text-muted">
                بخشی از نمونه‌کارهای
                {{ $salon?->name ?? 'سالن' }}
                را ببین.
            </p>

        </div>


        {{-- =========================================================
            Gallery
        ========================================================== --}}

        <div
            class="
                mt-8
                grid
                gap-5
                sm:grid-cols-2
                lg:grid-cols-3
            "
        >

            @foreach($galleryItems as $item)

                @php

                    $beforeUrl =
                        Storage::url(
                            $item->before_image
                        );

                    $afterUrl =
                        Storage::url(
                            $item->after_image
                        );

                @endphp


                <article
                    class="
                        group
                        overflow-hidden
                        rounded-3xl
                        border
                        border-border
                        bg-surface
                    "
                >

                    {{-- Before / After --}}

                    <div
                        class="
                            grid
                            grid-cols-2
                            gap-px
                            bg-border
                        "
                    >

                        {{-- Before --}}

                        <div
                            class="
                                relative
                                aspect-[4/3]
                                overflow-hidden
                                bg-zinc-900
                            "
                        >

                            <img
                                src="{{ $beforeUrl }}"
                                alt="{{
                                    ($item->alt_text
                                        ?: $item->title
                                        ?: 'نمونه‌کار'
                                    ) . ' - قبل'
                                }}"
                                loading="lazy"
                                class="
                                    h-full
                                    w-full
                                    object-cover
                                    transition
                                    duration-500
                                    group-hover:scale-[1.03]
                                "
                            >


                            <span
                                class="
                                    absolute
                                    right-2
                                    top-2
                                    rounded-full
                                    bg-black/70
                                    px-2.5
                                    py-1
                                    text-[9px]
                                    font-black
                                    text-white
                                    backdrop-blur
                                "
                            >
                                قبل
                            </span>

                        </div>


                        {{-- After --}}

                        <div
                            class="
                                relative
                                aspect-[4/3]
                                overflow-hidden
                                bg-zinc-900
                            "
                        >

                            <img
                                src="{{ $afterUrl }}"
                                alt="{{
                                    ($item->alt_text
                                        ?: $item->title
                                        ?: 'نمونه‌کار'
                                    ) . ' - بعد'
                                }}"
                                loading="lazy"
                                class="
                                    h-full
                                    w-full
                                    object-cover
                                    transition
                                    duration-500
                                    group-hover:scale-[1.03]
                                "
                            >


                            <span
                                class="
                                    absolute
                                    right-2
                                    top-2
                                    rounded-full
                                    bg-primary
                                    px-2.5
                                    py-1
                                    text-[9px]
                                    font-black
                                    text-black
                                "
                            >
                                بعد
                            </span>

                        </div>

                    </div>


                    {{-- Content --}}

                    <div class="p-4">

                        <h3
                            class="
                                truncate
                                text-sm
                                font-black
                                text-text
                            "
                        >
                            {{ $item->title ?: 'نمونه‌کار آرایشگاه' }}
                        </h3>


                        @if($item->description)

                            <p
                                class="
                                    mt-2
                                    line-clamp-2
                                    text-xs
                                    leading-6
                                    text-muted
                                "
                            >
                                {{ $item->description }}
                            </p>

                        @endif

                    </div>

                </article>

            @endforeach

        </div>


        {{-- =========================================================
            Total Count
        ========================================================== --}}

        @if($hasMore)

            <div class="mt-6 text-center">

                <p class="text-xs text-muted">
                    {{ $totalCount }} نمونه‌کار در گالری ثبت شده است.
                </p>

            </div>

        @endif

    </div>

</section>
