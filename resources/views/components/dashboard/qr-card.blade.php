{{-- resources/views/dashboard/qr/index.blade.php --}}

<div
    class="
        rounded-[28px]
        border
        border-zinc-800
        bg-zinc-900
        p-5
        sm:p-6
    "
>

    {{-- =========================================================
        Header
    ========================================================== --}}

    <div
        class="
            flex
            flex-col
            gap-4
            sm:flex-row
            sm:items-center
            sm:justify-between
        "
    >

        <div>

            <div class="flex items-center gap-3">

                <div
                    class="
                        flex
                        h-11
                        w-11
                        shrink-0
                        items-center
                        justify-center
                        rounded-xl
                        border
                        border-orange-500/20
                        bg-orange-500/10
                        text-orange-500
                    "
                >

                    <x-lucide-qr-code class="h-5 w-5" />

                </div>


                <div>

                    <h3 class="text-lg font-black text-white">
                        QR رزرو آنلاین
                    </h3>

                    <p class="mt-1 text-xs text-zinc-500 sm:text-sm">
                        مشتری‌ها با اسکن این کد وارد صفحه رزرو سالن می‌شوند.
                    </p>

                </div>

            </div>

        </div>


        @if(filled($salon->qr_token))

            <span
                class="
                    inline-flex
                    w-fit
                    items-center
                    gap-2
                    rounded-full
                    border
                    border-green-500/20
                    bg-green-500/10
                    px-3
                    py-2
                    text-xs
                    font-bold
                    text-green-400
                "
            >

                <span class="h-2 w-2 rounded-full bg-green-400"></span>

                QR فعال

            </span>

        @else

            <span
                class="
                    inline-flex
                    w-fit
                    items-center
                    gap-2
                    rounded-full
                    border
                    border-yellow-500/20
                    bg-yellow-500/10
                    px-3
                    py-2
                    text-xs
                    font-bold
                    text-yellow-400
                "
            >

                <span class="h-2 w-2 rounded-full bg-yellow-400"></span>

                هنوز ساخته نشده

            </span>

        @endif

    </div>


    @if(filled($salon->qr_token))

        {{-- =====================================================
            QR Area
        ====================================================== --}}

        <div
            class="
                mt-7
                grid
                gap-6
                lg:grid-cols-[1fr_320px]
                lg:items-center
            "
        >

            {{-- =================================================
                QR Preview
            ================================================== --}}

            <div
                class="
                    flex
                    flex-col
                    items-center
                    rounded-[24px]
                    border
                    border-zinc-800
                    bg-zinc-950
                    p-5
                    sm:p-6
                "
            >

                <div
                    class="
                        flex
                        w-full
                        justify-center
                    "
                >

                    <div
                        class="
                            aspect-square
                            w-[min(100%,320px)]
                            rounded-2xl
                            bg-white
                            p-3
                            shadow-2xl
                            shadow-black/30
                            sm:p-4
                        "
                    >

                        <img
                            src="{{ route('qr.image') }}"
                            alt="QR رزرو {{ $salon->name }}"
                            class="
                                h-full
                                w-full
                                object-contain
                            "
                        >

                    </div>

                </div>


                {{-- Salon Name --}}

                <div class="mt-5 text-center">

                    <p class="text-xs text-zinc-500">
                        QR اختصاصی
                    </p>

                    <p class="mt-1 text-base font-black text-white">
                        {{ $salon->name }}
                    </p>

                </div>


                {{-- Token --}}

                <div
                    class="
                        mt-4
                        rounded-xl
                        border
                        border-orange-500/20
                        bg-orange-500/5
                        px-4
                        py-3
                        text-center
                    "
                >

                    <p class="text-[10px] text-zinc-500">
                        کد اختصاصی
                    </p>

                    <p
                        dir="ltr"
                        class="
                            mt-1
                            text-sm
                            font-black
                            tracking-[0.18em]
                            text-orange-500
                        "
                    >
                        {{ $salon->qr_token }}
                    </p>

                </div>

            </div>


            {{-- =================================================
                Actions / URL
            ================================================== --}}

            <div class="space-y-4">

                {{-- Public URL --}}

                <div
                    class="
                        rounded-2xl
                        border
                        border-zinc-800
                        bg-zinc-950
                        p-4
                    "
                >

                    <div class="flex items-center gap-2">

                        <x-lucide-link
                            class="h-4 w-4 text-orange-500"
                        />

                        <p class="text-xs font-bold text-zinc-400">
                            لینک صفحه رزرو
                        </p>

                    </div>


                    <div
                        class="
                            mt-3
                            rounded-xl
                            bg-zinc-900
                            px-3
                            py-3
                        "
                    >

                        <p
                            dir="ltr"
                            class="
                                break-all
                                text-xs
                                leading-5
                                text-zinc-300
                            "
                        >
                            {{ route('salon.public', ['salon' => $salon->slug]) }}
                        </p>

                    </div>

                </div>


                {{-- Download --}}

                <a
                    href="{{ route('qr.download') }}"
                    class="
                        flex
                        w-full
                        items-center
                        justify-center
                        gap-2
                        rounded-xl
                        bg-orange-500
                        px-4
                        py-3.5
                        text-sm
                        font-black
                        text-black
                        transition
                        hover:bg-orange-400
                        active:scale-[0.99]
                    "
                >

                    <x-lucide-download class="h-5 w-5" />

                    دانلود QR Code

                </a>


                {{-- Open Public Page --}}

                <a
                    href="{{ route('salon.public', ['salon' => $salon->slug]) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="
                        flex
                        w-full
                        items-center
                        justify-center
                        gap-2
                        rounded-xl
                        border
                        border-zinc-700
                        bg-zinc-900
                        px-4
                        py-3.5
                        text-sm
                        font-bold
                        text-white
                        transition
                        hover:border-orange-500/40
                        hover:text-orange-400
                    "
                >

                    <x-lucide-external-link class="h-5 w-5" />

                    مشاهده صفحه سالن

                </a>


                {{-- Print Hint --}}

                <div
                    class="
                        rounded-2xl
                        border
                        border-blue-500/20
                        bg-blue-500/5
                        p-4
                    "
                >

                    <div class="flex items-start gap-3">

                        <x-lucide-info
                            class="mt-0.5 h-5 w-5 shrink-0 text-blue-400"
                        />

                        <div>

                            <p class="text-xs font-black text-blue-300">
                                آماده چاپ
                            </p>

                            <p
                                class="
                                    mt-1
                                    text-xs
                                    leading-6
                                    text-zinc-500
                                "
                            >
                                فایل QR را دانلود کنید و برای چاپ استیکر یا
                                نصب روی شیشه سالن استفاده کنید.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @else

        {{-- =====================================================
            Generate QR
        ====================================================== --}}

        <div
            class="
                mt-7
                rounded-[24px]
                border
                border-dashed
                border-zinc-700
                bg-zinc-950
                p-8
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
                    border
                    border-orange-500/20
                    bg-orange-500/10
                    text-orange-500
                "
            >

                <x-lucide-qr-code class="h-8 w-8" />

            </div>


            <h4
                class="
                    mt-5
                    text-lg
                    font-black
                    text-white
                "
            >
                QR سالن هنوز ساخته نشده
            </h4>


            <p
                class="
                    mx-auto
                    mt-2
                    max-w-md
                    text-sm
                    leading-7
                    text-zinc-500
                "
            >
                با ساخت QR اختصاصی، مشتری‌ها می‌توانند با اسکن آن
                مستقیماً وارد صفحه سالن و رزرو آنلاین شوند.
            </p>


            <form
                method="POST"
                action="{{ route('qr.generate') }}"
                class="mt-6"
            >

                @csrf

                <button
                    type="submit"
                    class="
                        inline-flex
                        w-full
                        items-center
                        justify-center
                        gap-2
                        rounded-xl
                        bg-orange-500
                        px-6
                        py-3.5
                        text-sm
                        font-black
                        text-black
                        transition
                        hover:bg-orange-400
                        sm:w-auto
                    "
                >

                    <x-lucide-qr-code class="h-5 w-5" />

                    ساخت QR اختصاصی

                </button>

            </form>

        </div>

    @endif

</div>
