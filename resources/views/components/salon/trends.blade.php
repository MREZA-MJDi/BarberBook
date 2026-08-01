<section
    id="trends"
    class="py-16 bg-background"
    dir="rtl">

    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        {{-- Header --}}
        <div class="flex items-end justify-between">

            <div>

                <span class="text-sm font-bold tracking-widest text-primary uppercase">

                    Trending

                </span>

                <h2 class="mt-2 text-3xl font-black text-text lg:text-4xl">

                    مدل‌های ترند

                </h2>

                <p class="mt-3 max-w-xl leading-8 text-muted">

                    محبوب‌ترین مدل‌هایی که این روزها بیشتر انتخاب می‌شوند.

                </p>

            </div>

        </div>

        {{-- Cards --}}
        <div
            class="mt-10 flex gap-5 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-thin scrollbar-thumb-border scrollbar-track-transparent">

            <x-salon.trend-card />

            <x-salon.trend-card />

            <x-salon.trend-card />

            <x-salon.trend-card />

            <x-salon.trend-card />

        </div>

    </div>

</section>
