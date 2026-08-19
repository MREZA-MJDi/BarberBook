<x-layouts.dashboard>

    {{-- =========================================================
        Page Header
    ========================================================== --}}

    <div class="mb-8">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

            <div>

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-2xl
                               border border-primary/20 bg-primary/10 text-primary"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.562.562 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.562.562 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.817a.562.562 0 00-.576 0l-4.725 2.817a.562.562 0 01-.84-.61l1.285-5.385a.562.562 0 00-.182-.557L2.075 10.385c-.38-.325-.178-.948.321-.988l5.518-.442a.562.562 0 00.475-.345L10.514 3.5Z"
                            />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-bold text-primary">
                            بازخورد مشتریان
                        </p>

                        <h1 class="mt-1 text-2xl font-black text-text sm:text-3xl">
                            نظرات مشتری‌ها
                        </h1>
                    </div>

                </div>

                <p class="mt-3 max-w-2xl text-sm leading-7 text-text-muted">
                    تجربه مشتری‌ها را ببین، کیفیت خدماتت را بسنج و از بازخورد آن‌ها
                    برای بهتر شدن سالن استفاده کن.
                </p>

            </div>


            {{-- Rating Summary Badge --}}

            <div
                class="flex items-center gap-4 rounded-2xl border border-border
                       bg-surface px-5 py-4 shadow-sm"
            >

                <div class="text-right">

                    <p class="text-xs font-bold text-text-muted">
                        امتیاز فعلی سالن
                    </p>

                    <div class="mt-1 flex items-center gap-2">

                        <span class="text-2xl font-black text-text">
                            {{ number_format($averageRating, 1) }}
                        </span>

                        <span class="text-lg text-primary">
                            ★
                        </span>

                    </div>

                </div>

                <div class="h-10 w-px bg-border"></div>

                <div>

                    <p class="text-xs font-bold text-text-muted">
                        تعداد نظرات
                    </p>

                    <p class="mt-1 text-lg font-black text-text">
                        {{ number_format($ratingsCount) }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        Statistics
    ========================================================== --}}

    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Average --}}
        <div
            class="relative overflow-hidden rounded-3xl border border-border
                   bg-surface p-5"
        >

            <div class="absolute -left-8 -top-8 h-24 w-24 rounded-full bg-primary/5"></div>

            <div class="relative">

                <div class="flex items-center justify-between">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-2xl
                               bg-primary/10 text-primary"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.036a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.802-2.036a1 1 0 00-1.176 0l-2.802 2.036c-.783.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.363-1.118L2.713 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.293Z"
                            />
                        </svg>
                    </div>

                    <span class="text-xs font-bold text-emerald-400">
                        عالی
                    </span>

                </div>

                <p class="mt-5 text-xs font-bold text-text-muted">
                    میانگین امتیاز
                </p>

                <div class="mt-1 flex items-baseline gap-2">

                    <span class="text-3xl font-black text-text">
                        {{ number_format($averageRating, 1) }}
                    </span>

                    <span class="text-sm text-text-muted">
                        از ۵
                    </span>

                </div>

            </div>

        </div>


        {{-- Total --}}
        <div
            class="rounded-3xl border border-border bg-surface p-5"
        >

            <div class="flex items-center justify-between">

                <div
                    class="flex h-11 w-11 items-center justify-center rounded-2xl
                           bg-blue-500/10 text-blue-400"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M8 10h8M8 14h5m5 7H6a2 2 0 01-2-2V5a2 2 0 012-2h10l4 4v12a2 2 0 01-2 2Z"
                        />
                    </svg>
                </div>

                <span class="text-xs font-bold text-text-muted">
                    کل بازخورد
                </span>

            </div>

            <p class="mt-5 text-xs font-bold text-text-muted">
                تعداد نظرات منتشرشده
            </p>

            <p class="mt-1 text-3xl font-black text-text">
                {{ number_format($ratingsCount) }}
            </p>

        </div>


        {{-- Five Stars --}}
        <div
            class="rounded-3xl border border-border bg-surface p-5"
        >

            <div class="flex items-center justify-between">

                <div
                    class="flex h-11 w-11 items-center justify-center rounded-2xl
                           bg-amber-400/10 text-amber-400"
                >
                    <span class="text-xl">
                        ★
                    </span>
                </div>

                <span class="text-xs font-bold text-text-muted">
                    ۵ ستاره
                </span>

            </div>

            <p class="mt-5 text-xs font-bold text-text-muted">
                مشتریان بسیار راضی
            </p>

            <p class="mt-1 text-3xl font-black text-text">
                {{ number_format($ratingDistribution[5] ?? 0) }}
            </p>

        </div>


        {{-- One Star --}}
        <div
            class="rounded-3xl border border-border bg-surface p-5"
        >

            <div class="flex items-center justify-between">

                <div
                    class="flex h-11 w-11 items-center justify-center rounded-2xl
                           bg-red-500/10 text-red-400"
                >
                    <span class="text-xl">
                        ★
                    </span>
                </div>

                <span class="text-xs font-bold text-text-muted">
                    نیاز به توجه
                </span>

            </div>

            <p class="mt-5 text-xs font-bold text-text-muted">
                نظرات ۱ ستاره
            </p>

            <p class="mt-1 text-3xl font-black text-text">
                {{ number_format($ratingDistribution[1] ?? 0) }}
            </p>

        </div>

    </div>


    {{-- =========================================================
        Main Content
    ========================================================== --}}

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">


        {{-- =====================================================
            Rating Distribution
        ====================================================== --}}

        <div
            class="rounded-3xl border border-border bg-surface p-6"
        >

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-base font-black text-text">
                        توزیع امتیازها
                    </h2>

                    <p class="mt-1 text-xs text-text-muted">
                        وضعیت رضایت مشتریان
                    </p>

                </div>

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-2xl
                           bg-primary/10 text-primary"
                >
                    ★
                </div>

            </div>


            <div class="mt-7 space-y-5">

                @for ($rating = 5; $rating >= 1; $rating--)

                    @php
                        $count = $ratingDistribution[$rating] ?? 0;

                        $percentage = $ratingsCount > 0
                            ? round(($count / $ratingsCount) * 100)
                            : 0;
                    @endphp

                    <div>

                        <div class="mb-2 flex items-center justify-between">

                            <div class="flex items-center gap-2">

                                <span class="w-3 text-xs font-black text-text">
                                    {{ $rating }}
                                </span>

                                <span class="text-sm text-primary">
                                    ★
                                </span>

                            </div>

                            <span class="text-xs font-bold text-text-muted">
                                {{ $count }} نظر
                            </span>

                        </div>

                        <div class="h-2.5 overflow-hidden rounded-full bg-border">

                            <div
                                class="h-full rounded-full bg-primary transition-all"
                                style="width: {{ $percentage }}%"
                            ></div>

                        </div>

                        <div class="mt-1 text-left text-[10px] font-bold text-text-muted">
                            {{ $percentage }}٪
                        </div>

                    </div>

                @endfor

            </div>

        </div>


        {{-- =====================================================
            Reviews List
        ====================================================== --}}

        <div class="xl:col-span-2">

            <div
                class="overflow-hidden rounded-3xl border border-border bg-surface"
            >

                {{-- Header --}}

                <div
                    class="flex flex-col gap-4 border-b border-border p-6
                           sm:flex-row sm:items-center sm:justify-between"
                >

                    <div>

                        <h2 class="text-base font-black text-text">
                            آخرین نظرات
                        </h2>

                        <p class="mt-1 text-xs text-text-muted">
                            بازخورد مشتریان درباره سالن
                        </p>

                    </div>


                    <div
                        class="flex items-center gap-2 rounded-xl border border-border
                               bg-background px-3 py-2"
                    >

                        <span class="text-xs text-text-muted">
                            مرتب‌سازی:
                        </span>

                        <span class="text-xs font-bold text-text">
                            جدیدترین
                        </span>

                        <svg
                            class="h-4 w-4 text-text-muted"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m6 9 6 6 6-6"
                            />
                        </svg>

                    </div>

                </div>


                {{-- Reviews --}}

                @forelse ($reviews as $review)

                    <div
                        class="border-b border-border p-6 last:border-b-0
                               transition hover:bg-background/40"
                    >

                        <div class="flex gap-4">

                            {{-- Avatar --}}

                            <div
                                class="flex h-12 w-12 shrink-0 items-center justify-center
                                       rounded-2xl bg-primary/10 text-sm font-black text-primary"
                            >
                                {{ mb_substr($review->user?->full_name ?? 'م', 0, 1) }}
                            </div>


                            <div class="min-w-0 flex-1">

                                {{-- Top Row --}}

                                <div
                                    class="flex flex-col gap-3 sm:flex-row sm:items-start
                                           sm:justify-between"
                                >

                                    <div>

                                        <h3 class="text-sm font-black text-text">
                                            {{ $review->user?->full_name ?? 'مشتری' }}
                                        </h3>

                                        <div class="mt-1 flex flex-wrap items-center gap-2">

                                            <div class="flex items-center gap-0.5">

                                                @for ($star = 1; $star <= 5; $star++)

                                                    <span
                                                        class="text-sm {{ $star <= $review->rating ? 'text-primary' : 'text-text-muted/30' }}"
                                                    >
                                                        ★
                                                    </span>

                                                @endfor

                                            </div>

                                            <span class="text-[11px] text-text-muted">
                                                {{ $review->created_at?->diffForHumans() }}
                                            </span>

                                        </div>

                                    </div>


                                    {{-- Status + Moderation Actions --}}

                                    <div class="flex flex-wrap items-center gap-2">

                                        @if ($review->status === 'published')

                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full
                                                       bg-emerald-500/10 px-3 py-1.5
                                                       text-[11px] font-bold text-emerald-400"
                                            >
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                                منتشر شده
                                            </span>

                                            <form
                                                action="{{ route('dashboard.reviews.reject', $review) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="rounded-xl border border-red-500/20
                                                           bg-red-500/5 px-3 py-1.5
                                                           text-[11px] font-bold text-red-400
                                                           transition hover:bg-red-500/10"
                                                >
                                                    مخفی کردن
                                                </button>
                                            </form>

                                        @elseif ($review->status === 'pending')

                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full
                                                       bg-amber-500/10 px-3 py-1.5
                                                       text-[11px] font-bold text-amber-400"
                                            >
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                                در انتظار بررسی
                                            </span>

                                            <form
                                                action="{{ route('dashboard.reviews.publish', $review) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="rounded-xl border border-emerald-500/20
                                                           bg-emerald-500/5 px-3 py-1.5
                                                           text-[11px] font-bold text-emerald-400
                                                           transition hover:bg-emerald-500/10"
                                                >
                                                    انتشار
                                                </button>
                                            </form>

                                            <form
                                                action="{{ route('dashboard.reviews.reject', $review) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="rounded-xl border border-red-500/20
                                                           bg-red-500/5 px-3 py-1.5
                                                           text-[11px] font-bold text-red-400
                                                           transition hover:bg-red-500/10"
                                                >
                                                    رد کردن
                                                </button>
                                            </form>

                                        @else

                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full
                                                       bg-red-500/10 px-3 py-1.5
                                                       text-[11px] font-bold text-red-400"
                                            >
                                                <span class="h-1.5 w-1.5 rounded-full bg-red-400"></span>
                                                مخفی شده
                                            </span>

                                            <form
                                                action="{{ route('dashboard.reviews.publish', $review) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="rounded-xl border border-emerald-500/20
                                                           bg-emerald-500/5 px-3 py-1.5
                                                           text-[11px] font-bold text-emerald-400
                                                           transition hover:bg-emerald-500/10"
                                                >
                                                    انتشار مجدد
                                                </button>
                                            </form>

                                        @endif

                                    </div>

                                </div>


                                {{-- Comment --}}

                                @if ($review->comment)

                                    <div class="mt-4 rounded-2xl border border-border bg-background/50 p-4">

                                        <div class="flex gap-3">

                                            <div class="mt-0.5 text-lg text-primary">
                                                “
                                            </div>

                                            <p class="text-sm leading-7 text-text-muted">
                                                {{ $review->comment }}
                                            </p>

                                        </div>

                                    </div>

                                @else

                                    <p class="mt-4 text-xs italic text-text-muted">
                                        مشتری متنی برای این امتیاز ثبت نکرده است.
                                    </p>

                                @endif


                                {{-- Booking Info --}}

                                @if ($review->booking)

                                    <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2">

                                        @if ($review->booking->service)

                                            <div class="flex items-center gap-2">

                                                <svg
                                                    class="h-4 w-4 text-text-muted"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M9 5h6m-7 4h8m-9 4h10m-9 4h5"
                                                    />
                                                </svg>

                                                <span class="text-xs font-bold text-text-muted">
                                                    {{ $review->booking->service->name }}
                                                </span>

                                            </div>

                                        @endif


                                        <div class="flex items-center gap-2">

                                            <svg
                                                class="h-4 w-4 text-text-muted"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2Z"
                                                />
                                            </svg>

                                            <span class="text-xs text-text-muted">
                                                رزرو #{{ $review->booking->id }}
                                            </span>

                                        </div>

                                        @if ($review->booking->booking_date)

                                            <div class="flex items-center gap-2">

                                                <svg
                                                    class="h-4 w-4 text-text-muted"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2Z"
                                                    />
                                                </svg>

                                                <span class="text-xs text-text-muted">
                                                    {{ $review->booking->booking_date }}
                                                </span>

                                            </div>

                                        @endif

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                @empty

                    {{-- Empty State --}}

                    <div class="px-6 py-16 text-center">

                        <div
                            class="mx-auto flex h-16 w-16 items-center justify-center
                                   rounded-3xl bg-primary/10 text-primary"
                        >

                            <svg
                                class="h-7 w-7"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.562.562 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.562.562 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.817a.562.562 0 00-.576 0l-4.725 2.817a.562.562 0 01-.84-.61l1.285-5.385a.562.562 0 00-.182-.557L2.075 10.385c-.38-.325-.178-.948.321-.988l5.518-.442a.562.562 0 00.475-.345l2.125-5.111Z"
                                />
                            </svg>

                        </div>

                        <h3 class="mt-5 text-base font-black text-text">
                            هنوز نظری ثبت نشده
                        </h3>

                        <p class="mx-auto mt-2 max-w-sm text-sm leading-7 text-text-muted">
                            وقتی مشتری‌ها تجربه خودشان را با سالن به اشتراک بگذارند،
                            نظرات آن‌ها در این قسمت نمایش داده می‌شود.
                        </p>

                    </div>

                @endforelse


                {{-- Pagination --}}

                @if ($reviews->hasPages())

                    <div class="border-t border-border px-6 py-5">
                        {{ $reviews->links() }}
                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- =========================================================
        Insight Card
    ========================================================== --}}

    <div
        class="mt-6 overflow-hidden rounded-3xl border border-primary/20
               bg-primary/5"
    >

        <div class="flex flex-col gap-5 p-6 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-start gap-4">

                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center
                           rounded-2xl bg-primary/10 text-primary"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M9.813 15.904 9 20l3-1 3 1-.813-4.096M15 10a3 3 0 11-6 0 3 3 0 016 0Z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M19.5 10a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0Z"
                        />
                    </svg>
                </div>

                <div>

                    <h3 class="text-sm font-black text-text">
                        بازخورد مشتری‌ها سرمایه‌ی سالن توست.
                    </h3>

                    <p class="mt-2 max-w-2xl text-xs leading-6 text-text-muted">
                        امتیاز بالا اعتماد مشتری‌های جدید را بیشتر می‌کند.
                        سعی کن نظرات منفی را هم فرصتی برای بهتر کردن تجربه مشتری ببینی.
                    </p>

                </div>

            </div>

            <div
                class="shrink-0 rounded-2xl border border-border bg-surface
                       px-4 py-3 text-center"
            >

                <p class="text-[10px] font-bold text-text-muted">
                    امتیاز فعلی
                </p>

                <div class="mt-1 flex items-center justify-center gap-2">

                    <span class="text-xl font-black text-text">
                        {{ number_format($averageRating, 1) }}
                    </span>

                    <span class="text-primary">
                        ★
                    </span>

                </div>

            </div>

        </div>

    </div>

</x-layouts.dashboard>
