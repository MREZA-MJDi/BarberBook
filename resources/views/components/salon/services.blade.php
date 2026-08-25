{{-- resources/views/components/salon/service.blade.php --}}

@props([
'services' => collect(),
])

<section
    id="services"
    class="bg-background py-20"
    dir="rtl"
>

    <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center">

            <span class="text-sm font-bold tracking-widest text-primary">
                خدمات سالن
            </span>

            <h2 class="mt-3 text-3xl font-black text-text sm:text-4xl">
                خدمات و قیمت‌ها
            </h2>

            <p class="mx-auto mt-4 max-w-2xl leading-7 text-muted">
                خدمت موردنظرت را انتخاب کن و زمان مناسب خودت را برای رزرو انتخاب کن.
            </p>

        </div>


        {{-- Services --}}
        @if($services->isNotEmpty())

            <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach($services as $service)

                    <x-salon.service-card
                        :service="$service"
                    />

                @endforeach

            </div>

        @else

            {{-- Empty State --}}
            <div
                class="
                    mt-12
                    rounded-[28px]
                    border
                    border-border
                    bg-surface
                    px-6
                    py-16
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
                    ✂️
                </div>

                <h3 class="mt-6 text-xl font-black text-text">
                    هنوز خدمتی ثبت نشده است
                </h3>

                <p class="mx-auto mt-3 max-w-md leading-7 text-muted">
                    در حال حاضر خدمتی برای نمایش وجود ندارد.
                </p>

            </div>

        @endif

    </div>

</section>
