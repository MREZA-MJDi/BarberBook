{{-- resources/views/components/salon/reviews.blade.php --}}

<section
    id="reviews"
    class="bg-background py-20"
    dir="rtl"
>
    <div class="mx-auto max-w-5xl px-5 sm:px-6 lg:px-8">

        {{-- =====================================================
            Header
        ====================================================== --}}

        <div class="text-center">

            <span class="text-sm font-bold tracking-widest text-primary">
                نظرات مشتریان
            </span>

            <h2 class="mt-3 text-3xl font-black text-text sm:text-4xl">
                مشتری‌ها چی گفتن؟
            </h2>

            <p class="mx-auto mt-4 max-w-2xl leading-7 text-muted">
                بخشی از تجربه افرادی که از این آرایشگاه نوبت گرفته‌اند.
            </p>

        </div>


        {{-- =====================================================
            Review Summary
        ====================================================== --}}

        @if($reviews->isNotEmpty())

            <div
                class="
                    mt-10
                    grid
                    gap-4
                    sm:grid-cols-2
                "
            >

                {{-- Average Rating --}}
                <div
                    class="
                        rounded-2xl
                        border
                        border-border
                        bg-surface
                        p-5
                    "
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="
                                flex
                                h-11
                                w-11
                                items-center
                                justify-center
                                rounded-xl
                                bg-primary/10
                                text-xl
                            "
                        >
                            ★
                        </div>

                        <div>

                            <p class="text-xs text-muted">
                                امتیاز کاربران
                            </p>

                            <p class="mt-1 text-xl font-black text-text">
                                {{ number_format($averageRating ?? 0, 1) }}
                                <span class="text-sm font-bold text-muted">
                                    از 5
                                </span>
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Review Count --}}
                <div
                    class="
                        rounded-2xl
                        border
                        border-border
                        bg-surface
                        p-5
                    "
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="
                                flex
                                h-11
                                w-11
                                items-center
                                justify-center
                                rounded-xl
                                bg-primary/10
                                text-xl
                            "
                        >
                            💬
                        </div>

                        <div>

                            <p class="text-xs text-muted">
                                تعداد نظرات
                            </p>

                            <p class="mt-1 text-xl font-black text-text">
                                {{ $reviewsCount ?? $reviews->count() }}
                                <span class="text-sm font-bold text-muted">
                                    نظر
                                </span>
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                Reviews List
            ================================================== --}}

            <div class="mt-12 space-y-5">

                @foreach($reviews as $review)

                    <x-salon.review-card
                        :review="$review"
                    />

                @endforeach

            </div>


        @else

            {{-- =================================================
                Empty State
            ================================================== --}}

            <div
                class="
                    mt-12
                    rounded-[28px]
                    border
                    border-border
                    bg-surface
                    px-6
                    py-14
                    text-center
                "
            >

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
                    ★
                </div>

                <h3 class="mt-5 text-xl font-black text-text">
                    هنوز نظری ثبت نشده است
                </h3>

                <p class="mx-auto mt-3 max-w-md leading-7 text-muted">
                    هنوز نظری برای این سالن منتشر نشده است.
                    بعد از ثبت و تأیید نظرات، تجربه مشتریان اینجا نمایش داده می‌شود.
                </p>

            </div>

        @endif

    </div>

</section>
