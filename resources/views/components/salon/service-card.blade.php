{{-- resources/views/components/salon/service-card.blade.php --}}

@props([
'service',
])

<article
    class="
        group
        flex
        h-full
        flex-col
        rounded-[26px]
        border
        border-border
        bg-surface
        p-6
        transition-all
        duration-300
        hover:-translate-y-1
        hover:border-primary
        hover:bg-primary/5
    "
>

    {{-- =========================================================
        Icon
    ========================================================== --}}

    <div
        class="
            flex
            h-14
            w-14
            shrink-0
            items-center
            justify-center
            rounded-2xl
            bg-primary/10
            text-3xl
            transition-transform
            duration-300
            group-hover:scale-105
        "
    >
        ✂️
    </div>


    {{-- =========================================================
        Service Information
    ========================================================== --}}

    <div class="flex flex-1 flex-col">

        {{-- Service Name --}}

        <h2 class="mt-6 text-xl font-black text-text">
            {{ $service->name }}
        </h2>


        {{-- Description --}}

        @if($service->description)

            <p class="mt-3 text-sm leading-7 text-muted">
                {{ $service->description }}
            </p>

        @else

            <p class="mt-3 text-sm leading-7 text-muted">
                دریافت این خدمت با کیفیت و زمان‌بندی مشخص.
            </p>

        @endif


        {{-- =====================================================
            Service Meta
        ====================================================== --}}

        <div class="mt-auto pt-6">

            <div
                class="
                    flex
                    items-end
                    justify-between
                    gap-4
                    border-t
                    border-border
                    pt-5
                "
            >

                {{-- Duration + Price --}}

                <div>

                    <p class="text-sm text-muted">
                        حدود {{ $service->duration }} دقیقه
                    </p>

                    <p class="mt-2 text-lg font-black text-primary">

                        {{ number_format($service->price) }}

                        <span class="text-xs font-bold">
                            تومان
                        </span>

                    </p>

                </div>


                {{-- Availability --}}

                <span
                    class="
                        shrink-0
                        rounded-full
                        bg-primary/10
                        px-3
                        py-1
                        text-sm
                        font-black
                        text-primary
                    "
                >
                    قابل رزرو
                </span>

            </div>


            {{-- =================================================
                Booking Action
            ================================================== --}}

            <div class="mt-5">

                <a
                    href="{{route('salon.public', [
    'salon' => $service->salon->slug,
    'service_id' => $service->id,
]) }}#booking"
                    class="
                        flex
                        w-full
                        items-center
                        justify-center
                        rounded-2xl
                        bg-primary
                        px-5
                        py-3
                        text-sm
                        font-black
                        text-white
                        transition
                        duration-200
                        hover:opacity-90
                        active:scale-[0.98]
                    "
                >
                    رزرو این خدمت
                </a>

            </div>

        </div>

    </div>

</article>
