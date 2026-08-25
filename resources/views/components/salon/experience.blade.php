{{-- resources/views/components/salon/experience.blade.php --}}

@props([
'galleryItems' => collect(),
'reviews' => collect(),
'averageRating' => 0,
'reviewsCount' => 0,
])

<section
    id="experience"
    class="space-y-10"
>

    {{-- =========================================================
        Section Header
    ========================================================== --}}

    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

        <div class="max-w-2xl">

            <div class="mb-3 flex items-center gap-2">

                <span
                    class="h-2 w-2 rounded-full bg-primary shadow-[0_0_14px_rgba(244,114,182,0.45)]"
                ></span>

                <span
                    class="text-sm font-semibold text-primary"
                >
                    تجربه واقعی مشتری‌ها
                </span>

            </div>

            <h2
                class="text-2xl font-black tracking-tight text-text sm:text-3xl"
            >
                فضای سالن و نظر مشتریان
            </h2>

            <p
                class="mt-3 text-sm leading-7 text-text/60 sm:text-base"
            >
                قبل از رزرو، محیط سالن را ببینید و تجربه مشتریانی را بخوانید
                که قبلاً از خدمات این سالن استفاده کرده‌اند.
            </p>

        </div>


        {{-- Rating Summary --}}
        <div
            class="
                flex
                shrink-0
                items-center
                gap-3
                rounded-2xl
                border
                border-border
                bg-surface
                px-4
                py-3
            "
        >

            <div
                class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10"
            >
                <svg
                    class="h-5 w-5 text-primary"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <path
                        d="M12 2.75l2.78 5.63 6.22.9-4.5 4.38
                           1.06 6.2L12 16.93l-5.56 2.93
                           1.06-6.2L3 9.28l6.22-.9L12 2.75z"
                    />
                </svg>
            </div>

            <div>

                <div class="flex items-baseline gap-1">

                    <span
                        class="text-xl font-black text-text"
                    >
                        {{ number_format((float) $averageRating, 1) }}
                    </span>

                    <span class="text-xs text-text/40">
                        از ۵
                    </span>

                </div>

                <div class="text-xs text-text/50">
                    بر اساس {{ $reviewsCount }} نظر
                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        Gallery
    ========================================================== --}}

    @if($galleryItems->count())

        <div
            class="
                overflow-hidden
                rounded-3xl
                border
                border-border
                bg-surface
            "
        >

            <div
                class="
                    flex
                    flex-col
                    gap-3
                    border-b
                    border-border
                    px-5
                    py-5
                    sm:flex-row
                    sm:items-center
                    sm:justify-between
                    sm:px-6
                "
            >

                <div>

                    <h3
                        class="text-lg font-extrabold text-text"
                    >
                        گالری سالن
                    </h3>

                    <p
                        class="mt-1 text-sm text-text/50"
                    >
                        نگاهی به فضای سالن و محیط کار
                    </p>

                </div>

                <span
                    class="
                        inline-flex
                        w-fit
                        items-center
                        rounded-full
                        bg-background
                        px-3
                        py-1.5
                        text-xs
                        font-semibold
                        text-text/55
                    "
                >
                    {{ $galleryItems->count() }} تصویر
                </span>

            </div>


            <div
                class="
                    grid
                    grid-cols-2
                    gap-2
                    p-2
                    sm:grid-cols-4
                "
            >

                @foreach($galleryItems->take(8) as $index => $item)

                    @php
                        $image = is_array($item)
                            ? ($item['image'] ?? $item['path'] ?? $item['url'] ?? null)
                            : ($item->image ?? $item->path ?? $item->url ?? null);

                        $title = is_array($item)
                            ? ($item['title'] ?? 'تصویر سالن')
                            : ($item->title ?? 'تصویر سالن');
                    @endphp

                    @if($image)

                        <div
                            class="
                                group
                                relative
                                overflow-hidden
                                rounded-2xl
                                bg-background
                                {{ $index === 0 ? 'col-span-2 row-span-2' : '' }}
                            {{ $index === 3 ? 'hidden sm:block' : '' }}
                                "
                        >

                            <img
                                src="{{ $image }}"
                                alt="{{ $title }}"
                                class="
                                    h-full
                                    min-h-[150px]
                                    w-full
                                    object-cover
                                    transition
                                    duration-500
                                    group-hover:scale-105
                                    {{ $index === 0 ? 'sm:min-h-[310px]' : '' }}
                                    "
                                loading="lazy"
                            />

                            <div
                                class="
                                    pointer-events-none
                                    absolute
                                    inset-0
                                    bg-gradient-to-t
                                    from-black/40
                                    via-transparent
                                    to-transparent
                                    opacity-0
                                    transition
                                    duration-300
                                    group-hover:opacity-100
                                "
                            ></div>

                        </div>

                    @endif

                @endforeach

            </div>

        </div>

    @else

        {{-- Empty Gallery --}}
        <div
            class="
                flex
                min-h-[220px]
                flex-col
                items-center
                justify-center
                rounded-3xl
                border
                border-dashed
                border-border
                bg-surface/50
                px-6
                text-center
            "
        >

            <div
                class="
                    mb-4
                    flex
                    h-14
                    w-14
                    items-center
                    justify-center
                    rounded-2xl
                    bg-primary/10
                    text-primary
                "
            >
                <svg
                    class="h-6 w-6"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <rect x="3" y="3" width="18" height="18" rx="3" />
                    <circle cx="8.5" cy="8.5" r="1.5" />
                    <path d="M21 15l-5-5L5 21" />
                </svg>
            </div>

            <h3
                class="text-base font-bold text-text"
            >
                هنوز تصویری اضافه نشده
            </h3>

            <p
                class="mt-2 text-sm text-text/50"
            >
                به‌زودی تصاویر فضای سالن در این بخش نمایش داده می‌شود.
            </p>

        </div>

    @endif


    {{-- =========================================================
        Reviews
    ========================================================== --}}

    <div
        class="
            overflow-hidden
            rounded-3xl
            border
            border-border
            bg-surface
        "
    >

        {{-- Reviews Header --}}
        <div
            class="
                flex
                flex-col
                gap-5
                border-b
                border-border
                px-5
                py-6
                sm:flex-row
                sm:items-center
                sm:justify-between
                sm:px-6
            "
        >

            <div>

                <h3
                    class="text-lg font-extrabold text-text"
                >
                    نظر مشتریان
                </h3>

                <p
                    class="mt-1 text-sm text-text/50"
                >
                    تجربه افرادی که قبلاً اینجا خدمات گرفته‌اند
                </p>

            </div>


            <div
                class="flex items-center gap-3"
            >

                <div
                    class="flex items-center gap-0.5"
                    aria-label="امتیاز {{ number_format((float) $averageRating, 1) }} از 5"
                >

                    @for($i = 1; $i <= 5; $i++)

                        <svg
                            class="
                                h-4
                                w-4
                                {{ $i <= round($averageRating) ? 'text-primary' : 'text-text/15' }}
                                "
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                d="M12 2.75l2.78 5.63 6.22.9-4.5 4.38
                                   1.06 6.2L12 16.93l-5.56 2.93
                                   1.06-6.2L3 9.28l6.22-.9L12 2.75z"
                            />
                        </svg>

                    @endfor

                </div>

                <span
                    class="text-sm font-bold text-text"
                >
                    {{ number_format((float) $averageRating, 1) }}
                </span>

            </div>

        </div>


        @if($reviews->count())

            <div
                class="divide-y divide-border"
            >

                @foreach($reviews as $review)

                    <article
                        class="p-5 sm:p-6"
                    >

                        <div
                            class="
                                flex
                                flex-col
                                gap-4
                                sm:flex-row
                                sm:items-start
                                sm:justify-between
                            "
                        >

                            <div
                                class="flex items-center gap-3"
                            >

                                <div
                                    class="
                                        flex
                                        h-11
                                        w-11
                                        shrink-0
                                        items-center
                                        justify-center
                                        rounded-full
                                        bg-primary/10
                                        text-sm
                                        font-black
                                        text-primary
                                    "
                                >
                                    {{ mb_substr($review->customer_name ?? 'م', 0, 1) }}
                                </div>

                                <div>

                                    <h4
                                        class="text-sm font-bold text-text"
                                    >
                                        {{ $review->customer_name ?? 'مشتری' }}
                                    </h4>

                                    <div
                                        class="mt-1 flex items-center gap-2"
                                    >

                                        <div class="flex items-center gap-0.5">

                                            @for($i = 1; $i <= 5; $i++)

                                                <svg
                                                    class="
                                                        h-3.5
                                                        w-3.5
                                                        {{ $i <= $review->rating ? 'text-primary' : 'text-text/15' }}
                                                        "
                                                    viewBox="0 0 24 24"
                                                    fill="currentColor"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        d="M12 2.75l2.78 5.63 6.22.9-4.5 4.38
                                                           1.06 6.2L12 16.93l-5.56 2.93
                                                           1.06-6.2L3 9.28l6.22-.9L12 2.75z"
                                                    />
                                                </svg>

                                            @endfor

                                        </div>

                                        @if($review->created_at)
                                            <span
                                                class="text-xs text-text/40"
                                            >
                                                {{ $review->created_at->diffForHumans() }}
                                            </span>
                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Service --}}
                            @if(isset($review->service) && $review->service)

                                <span
                                    class="
                                        inline-flex
                                        w-fit
                                        items-center
                                        rounded-full
                                        bg-background
                                        px-3
                                        py-1.5
                                        text-xs
                                        font-semibold
                                        text-text/55
                                    "
                                >
                                    {{ $review->service->name }}
                                </span>

                            @endif

                        </div>


                        {{-- Review Text --}}
                        @if(!empty($review->comment))

                            <p
                                class="
                                    mt-5
                                    max-w-4xl
                                    text-sm
                                    leading-8
                                    text-text/70
                                "
                            >
                                {{ $review->comment }}
                            </p>

                        @endif


                        {{-- Review Image --}}
                        @php
                            $reviewImage = $review->image
                                ?? $review->photo
                                ?? $review->media_url
                                ?? null;
                        @endphp

                        @if($reviewImage)

                            <div
                                class="mt-5 overflow-hidden rounded-2xl"
                            >

                                <img
                                    src="{{ $reviewImage }}"
                                    alt="عکس ثبت شده توسط {{ $review->customer_name ?? 'مشتری' }}"
                                    class="
                                        h-56
                                        w-full
                                        object-cover
                                        sm:h-72
                                    "
                                    loading="lazy"
                                />

                            </div>

                        @endif

                    </article>

                @endforeach

            </div>

        @else

            {{-- Empty Reviews --}}
            <div
                class="
                    flex
                    min-h-[220px]
                    flex-col
                    items-center
                    justify-center
                    px-6
                    text-center
                "
            >

                <div
                    class="
                        mb-4
                        flex
                        h-14
                        w-14
                        items-center
                        justify-center
                        rounded-2xl
                        bg-primary/10
                        text-primary
                    "
                >
                    <svg
                        class="h-6 w-6"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            d="M20 3H4a2 2 0 0 0-2 2v15l4-3h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Zm-2 9h-4v2h4v-2Zm0-4H6v2h12V8ZM6 12h4v2H6v-2Z"
                        />
                    </svg>
                </div>

                <h3
                    class="text-base font-bold text-text"
                >
                    هنوز نظری ثبت نشده
                </h3>

                <p
                    class="mt-2 max-w-md text-sm leading-7 text-text/50"
                >
                    اولین نفری باشید که تجربه خود را درباره خدمات این سالن ثبت می‌کند.
                </p>

            </div>

        @endif

    </div>

</section>
