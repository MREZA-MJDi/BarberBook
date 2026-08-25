{{-- resources/views/dashboard/qr/index.blade.php --}}

<x-layouts.dashboard>

    @php

        /*
        |--------------------------------------------------------------------------
        | QR Status
        |--------------------------------------------------------------------------
        */

        $hasQr =
            filled(
                $salon?->qr_token
            );



        /*
        |--------------------------------------------------------------------------
        | Public Salon URL
        |--------------------------------------------------------------------------
        |
        | New public URL:
        |
        | /salon/{slug}
        |
        */

        $publicUrl = $hasQr
            ? route(
                'salon.public',
                [
                    'salon' =>
                        $salon->slug,
                ]
            )
            : null;

    @endphp


    {{-- =========================================================
        Page Header
    ========================================================== --}}

    <div class="mb-8">

        <div
            class="
                flex
                flex-col
                gap-4
                sm:flex-row
                sm:items-end
                sm:justify-between
            "
        >

            <div>

                <div class="flex items-center gap-2">

                    <span
                        class="
                            h-2
                            w-2
                            rounded-full
                            bg-orange-500
                            shadow-[0_0_12px_rgba(249,115,22,0.8)]
                        "
                    ></span>

                    <p class="text-sm font-bold text-orange-500">
                        دسترسی سریع مشتری
                    </p>

                </div>


                <h1
                    class="
                        mt-2
                        text-3xl
                        font-black
                        tracking-tight
                        text-white
                        sm:text-4xl
                    "
                >
                    QR Code سالن
                </h1>


                <p
                    class="
                        mt-2
                        max-w-2xl
                        text-sm
                        leading-6
                        text-zinc-500
                    "
                >
                    مشتریان با اسکن این QR Code مستقیماً وارد صفحه اختصاصی
                    {{ $salon?->name ?? 'سالن شما' }}
                    می‌شوند و می‌توانند خدمات و زمان‌های رزرو را مشاهده کنند.
                </p>

            </div>


            {{-- Status --}}

            @if($hasQr)

                <div
                    class="
                        inline-flex
                        w-fit
                        items-center
                        gap-2
                        rounded-full
                        border
                        border-green-500/10
                        bg-green-500/5
                        px-4
                        py-2
                    "
                >

                    <span class="relative flex h-2.5 w-2.5">

                        <span
                            class="
                                absolute
                                inline-flex
                                h-full
                                w-full
                                animate-ping
                                rounded-full
                                bg-green-400
                                opacity-30
                            "
                        ></span>

                        <span
                            class="
                                relative
                                inline-flex
                                h-2.5
                                w-2.5
                                rounded-full
                                bg-green-500
                            "
                        ></span>

                    </span>

                    <span class="text-xs font-bold text-green-400">
                        QR فعال است
                    </span>

                </div>

            @else

                <div
                    class="
                        inline-flex
                        w-fit
                        items-center
                        gap-2
                        rounded-full
                        border
                        border-orange-500/10
                        bg-orange-500/5
                        px-4
                        py-2
                    "
                >

                    <span
                        class="
                            h-2.5
                            w-2.5
                            rounded-full
                            bg-orange-500
                        "
                    ></span>

                    <span class="text-xs font-bold text-orange-400">
                        هنوز ساخته نشده
                    </span>

                </div>

            @endif

        </div>

    </div>


    {{-- =========================================================
        Flash Messages
    ========================================================== --}}

    @if(session('success'))

        <div
            class="
                mb-6
                flex
                items-start
                gap-3
                rounded-2xl
                border
                border-green-500/10
                bg-green-500/5
                p-4
            "
        >

            <x-lucide-check-circle-2
                class="
                    mt-0.5
                    h-5
                    w-5
                    shrink-0
                    text-green-500
                "
            />

            <p
                class="
                    text-sm
                    font-bold
                    leading-6
                    text-green-400
                "
            >
                {{ session('success') }}
            </p>

        </div>

    @endif


    @if(session('info'))

        <div
            class="
                mb-6
                flex
                items-start
                gap-3
                rounded-2xl
                border
                border-orange-500/10
                bg-orange-500/5
                p-4
            "
        >

            <x-lucide-info
                class="
                    mt-0.5
                    h-5
                    w-5
                    shrink-0
                    text-orange-500
                "
            />

            <p
                class="
                    text-sm
                    font-bold
                    leading-6
                    text-orange-400
                "
            >
                {{ session('info') }}
            </p>

        </div>

    @endif


    {{-- =========================================================
        Main Content
    ========================================================== --}}

    <div class="grid gap-6 xl:grid-cols-12">


        {{-- =====================================================
            QR CARD
        ====================================================== --}}

        <div
            class="
                relative
                overflow-hidden
                rounded-3xl
                border
                border-zinc-800
                bg-zinc-950
                xl:col-span-8
            "
        >

            {{-- Glow --}}

            <div
                class="
                    pointer-events-none
                    absolute
                    -right-32
                    -top-32
                    h-80
                    w-80
                    rounded-full
                    bg-orange-500/10
                    blur-3xl
                "
            ></div>

            <div
                class="
                    pointer-events-none
                    absolute
                    -bottom-40
                    -left-32
                    h-80
                    w-80
                    rounded-full
                    bg-orange-500/5
                    blur-3xl
                "
            ></div>


            <div class="relative p-5 sm:p-8">


                {{-- Header --}}

                <div class="flex items-start gap-4">

                    <div
                        class="
                            flex
                            h-12
                            w-12
                            shrink-0
                            items-center
                            justify-center
                            rounded-2xl
                            border
                            border-orange-500/20
                            bg-orange-500/10
                        "
                    >

                        <x-lucide-qr-code
                            class="
                                h-6
                                w-6
                                text-orange-500
                            "
                        />

                    </div>


                    <div class="min-w-0">

                        <p
                            class="
                                text-xs
                                font-bold
                                uppercase
                                tracking-widest
                                text-orange-500
                            "
                        >
                            اختصاصی سالن
                        </p>

                        <h2
                            class="
                                mt-1
                                text-2xl
                                font-black
                                text-white
                            "
                        >
                            QR Code شما
                        </h2>

                        <p
                            class="
                                mt-2
                                max-w-xl
                                text-sm
                                leading-6
                                text-zinc-500
                            "
                        >
                            این کد مسیر مستقیم مشتری به صفحه آنلاین سالن شماست.
                        </p>

                    </div>

                </div>


                {{-- =================================================
                    NOT GENERATED
                ================================================== --}}

                @if(!$hasQr)

                    <div
                        class="
                            mt-8
                            overflow-hidden
                            rounded-3xl
                            border
                            border-zinc-800
                            bg-black/30
                        "
                    >

                        <div class="grid lg:grid-cols-2">


                            {{-- Preview --}}

                            <div
                                class="
                                    flex
                                    min-h-[360px]
                                    items-center
                                    justify-center
                                    border-b
                                    border-zinc-800
                                    p-8
                                    lg:border-b-0
                                    lg:border-l
                                "
                            >

                                <div class="relative">

                                    <div
                                        class="
                                            flex
                                            h-56
                                            w-56
                                            items-center
                                            justify-center
                                            rounded-3xl
                                            border
                                            border-dashed
                                            border-zinc-700
                                            bg-zinc-900/70
                                        "
                                    >

                                        <div class="text-center">

                                            <div
                                                class="
                                                    mx-auto
                                                    flex
                                                    h-16
                                                    w-16
                                                    items-center
                                                    justify-center
                                                    rounded-2xl
                                                    bg-zinc-800
                                                "
                                            >

                                                <x-lucide-qr-code
                                                    class="
                                                        h-8
                                                        w-8
                                                        text-zinc-600
                                                    "
                                                />

                                            </div>

                                            <p
                                                class="
                                                    mt-4
                                                    text-xs
                                                    font-bold
                                                    text-zinc-600
                                                "
                                            >
                                                QR Code هنوز ساخته نشده
                                            </p>

                                        </div>

                                    </div>


                                    <div
                                        class="
                                            pointer-events-none
                                            absolute
                                            -inset-4
                                            rounded-[2rem]
                                            border
                                            border-orange-500/5
                                        "
                                    ></div>

                                </div>

                            </div>


                            {{-- Generate Info --}}

                            <div
                                class="
                                    flex
                                    flex-col
                                    justify-center
                                    p-6
                                    sm:p-8
                                "
                            >

                                <span
                                    class="
                                        inline-flex
                                        w-fit
                                        items-center
                                        gap-2
                                        rounded-full
                                        bg-orange-500/10
                                        px-3
                                        py-1.5
                                        text-[11px]
                                        font-black
                                        text-orange-400
                                    "
                                >

                                    <x-lucide-sparkles
                                        class="h-3.5 w-3.5"
                                    />

                                    آماده فعال‌سازی

                                </span>


                                <h3
                                    class="
                                        mt-5
                                        text-xl
                                        font-black
                                        text-white
                                    "
                                >
                                    QR Code اختصاصی سالن را بسازید
                                </h3>


                                <p
                                    class="
                                        mt-3
                                        text-sm
                                        leading-7
                                        text-zinc-500
                                    "
                                >
                                    با ساخت QR Code، یک کد اختصاصی برای سالن شما
                                    ایجاد می‌شود که مشتریان می‌توانند با اسکن آن
                                    مستقیماً وارد صفحه رزرو آنلاین شوند.
                                </p>


                                <div class="mt-6 space-y-3">

                                    <div class="flex items-center gap-3">

                                        <span
                                            class="
                                                flex
                                                h-8
                                                w-8
                                                shrink-0
                                                items-center
                                                justify-center
                                                rounded-xl
                                                bg-green-500/10
                                            "
                                        >

                                            <x-lucide-check
                                                class="h-4 w-4 text-green-500"
                                            />

                                        </span>

                                        <span
                                            class="
                                                text-xs
                                                font-bold
                                                text-zinc-400
                                            "
                                        >
                                            QR Code اختصاصی و دائمی
                                        </span>

                                    </div>


                                    <div class="flex items-center gap-3">

                                        <span
                                            class="
                                                flex
                                                h-8
                                                w-8
                                                shrink-0
                                                items-center
                                                justify-center
                                                rounded-xl
                                                bg-green-500/10
                                            "
                                        >

                                            <x-lucide-check
                                                class="h-4 w-4 text-green-500"
                                            />

                                        </span>

                                        <span
                                            class="
                                                text-xs
                                                font-bold
                                                text-zinc-400
                                            "
                                        >
                                            مناسب چاپ روی شیشه و کارت ویزیت
                                        </span>

                                    </div>


                                    <div class="flex items-center gap-3">

                                        <span
                                            class="
                                                flex
                                                h-8
                                                w-8
                                                shrink-0
                                                items-center
                                                justify-center
                                                rounded-xl
                                                bg-green-500/10
                                            "
                                        >

                                            <x-lucide-check
                                                class="h-4 w-4 text-green-500"
                                            />

                                        </span>

                                        <span
                                            class="
                                                text-xs
                                                font-bold
                                                text-zinc-400
                                            "
                                        >
                                            بدون نیاز به ثبت‌نام مشتری
                                        </span>

                                    </div>

                                </div>


                                {{-- Generate --}}

                                <form
                                    method="POST"
                                    action="{{ route('qr.generate') }}"
                                    class="mt-8"
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
                                            rounded-2xl
                                            bg-orange-500
                                            px-5
                                            py-4
                                            text-sm
                                            font-black
                                            text-black
                                            shadow-lg
                                            shadow-orange-500/10
                                            transition
                                            hover:bg-orange-400
                                            active:scale-[0.99]
                                        "
                                    >

                                        <x-lucide-qr-code
                                            class="h-5 w-5"
                                        />

                                        ساخت QR Code

                                    </button>

                                </form>


                                <p
                                    class="
                                        mt-3
                                        text-center
                                        text-[11px]
                                        leading-5
                                        text-zinc-600
                                    "
                                >
                                    پس از ساخت، QR Code قابل حذف یا تغییر نخواهد بود.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        GENERATED
                    ================================================== --}}

                @else

                    <div class="mt-8 grid gap-6 lg:grid-cols-5">


                        {{-- QR Preview --}}

                        <div
                            class="
                                relative
                                flex
                                min-h-[420px]
                                items-center
                                justify-center
                                overflow-hidden
                                rounded-3xl
                                border
                                border-zinc-800
                                bg-black/40
                                p-6
                                sm:p-8
                                lg:col-span-3
                            "
                        >

                            <div
                                class="
                                    pointer-events-none
                                    absolute
                                    -top-24
                                    left-1/2
                                    h-56
                                    w-56
                                    -translate-x-1/2
                                    rounded-full
                                    bg-orange-500/10
                                    blur-3xl
                                "
                            ></div>


                            <div
                                class="
                                    relative
                                    w-full
                                    max-w-[320px]
                                    text-center
                                "
                            >

                                @if($qrSvg)

                                    <div
                                        class="
                                            mx-auto
                                            aspect-square
                                            w-full
                                            max-w-[300px]
                                            rounded-[2rem]
                                            bg-white
                                            p-4
                                            shadow-2xl
                                            shadow-black/50
                                            sm:max-w-[320px]
                                            sm:p-5
                                            [&>svg]:block
                                            [&>svg]:h-full
                                            [&>svg]:w-full
                                        "
                                    >

                                        {!! $qrSvg !!}

                                    </div>

                                @else

                                    <div
                                        class="
                                            mx-auto
                                            flex
                                            aspect-square
                                            w-full
                                            max-w-[300px]
                                            items-center
                                            justify-center
                                            rounded-[2rem]
                                            border
                                            border-red-500/20
                                            bg-red-500/5
                                            p-6
                                            text-center
                                            sm:max-w-[320px]
                                        "
                                    >

                                        <div>

                                            <x-lucide-circle-alert
                                                class="
                                                    mx-auto
                                                    h-8
                                                    w-8
                                                    text-red-400
                                                "
                                            />

                                            <p
                                                class="
                                                    mt-3
                                                    text-sm
                                                    font-bold
                                                    text-red-400
                                                "
                                            >
                                                QR Code تولید نشد
                                            </p>

                                        </div>

                                    </div>

                                @endif


                                <div
                                    class="
                                        mt-5
                                        flex
                                        items-center
                                        justify-center
                                        gap-2
                                    "
                                >

                                    <span
                                        class="
                                            flex
                                            h-7
                                            w-7
                                            items-center
                                            justify-center
                                            rounded-full
                                            bg-green-500/10
                                        "
                                    >

                                        <x-lucide-check
                                            class="
                                                h-4
                                                w-4
                                                text-green-500
                                            "
                                        />

                                    </span>

                                    <span
                                        class="
                                            text-xs
                                            font-bold
                                            text-green-400
                                        "
                                    >
                                        QR Code فعال و دائمی است
                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            QR Details
                        ================================================== --}}

                        <div
                            class="
                                flex
                                flex-col
                                lg:col-span-2
                            "
                        >

                            <div>

                                <p
                                    class="
                                        text-xs
                                        font-bold
                                        text-zinc-600
                                    "
                                >
                                    سالن
                                </p>

                                <h3
                                    class="
                                        mt-1
                                        truncate
                                        text-xl
                                        font-black
                                        text-white
                                    "
                                >
                                    {{ $salon->name }}
                                </h3>

                            </div>


                            {{-- Slug --}}

                            <div
                                class="
                                    mt-5
                                    rounded-2xl
                                    border
                                    border-zinc-800
                                    bg-black/20
                                    p-4
                                "
                            >

                                <p
                                    class="
                                        text-xs
                                        font-bold
                                        text-zinc-500
                                    "
                                >
                                    آدرس عمومی سالن
                                </p>

                                <p
                                    dir="ltr"
                                    class="
                                        mt-2
                                        break-all
                                        text-xs
                                        font-black
                                        text-orange-500
                                    "
                                >
                                    /salon/{{ $salon->slug }}
                                </p>

                            </div>


                            {{-- QR Token --}}

                            <div
                                class="
                                    mt-4
                                    rounded-2xl
                                    border
                                    border-orange-500/10
                                    bg-orange-500/[0.03]
                                    p-4
                                "
                            >

                                <p
                                    class="
                                        text-xs
                                        font-bold
                                        text-zinc-500
                                    "
                                >
                                    شناسه داخلی QR
                                </p>

                                <p
                                    dir="ltr"
                                    class="
                                        mt-2
                                        break-all
                                        text-xs
                                        font-black
                                        tracking-[0.16em]
                                        text-zinc-500
                                    "
                                >
                                    {{ $salon->qr_token }}
                                </p>

                            </div>


                            {{-- Public URL --}}

                            <div
                                class="
                                    mt-4
                                    rounded-2xl
                                    border
                                    border-zinc-800
                                    bg-black/30
                                    p-4
                                "
                            >

                                <div class="flex items-center gap-2">

                                    <x-lucide-link
                                        class="h-4 w-4 text-orange-500"
                                    />

                                    <p
                                        class="
                                            text-xs
                                            font-bold
                                            text-zinc-500
                                        "
                                    >
                                        لینک اختصاصی سالن
                                    </p>

                                </div>


                                <p
                                    dir="ltr"
                                    class="
                                        mt-3
                                        break-all
                                        text-left
                                        text-xs
                                        font-medium
                                        leading-5
                                        text-zinc-400
                                    "
                                >
                                    {{ $publicUrl }}
                                </p>

                            </div>


                            {{-- Actions --}}

                            <div
                                class="
                                    mt-5
                                    grid
                                    gap-3
                                "
                            >

                                <a
                                    href="{{ route('qr.download') }}"
                                    class="
                                        inline-flex
                                        items-center
                                        justify-center
                                        gap-2
                                        rounded-2xl
                                        bg-orange-500
                                        px-5
                                        py-3.5
                                        text-sm
                                        font-black
                                        text-black
                                        transition
                                        hover:bg-orange-400
                                    "
                                >

                                    <x-lucide-download
                                        class="h-4 w-4"
                                    />

                                    دانلود QR Code

                                </a>


                                <button
                                    type="button"
                                    onclick="window.print()"
                                    class="
                                        inline-flex
                                        items-center
                                        justify-center
                                        gap-2
                                        rounded-2xl
                                        border
                                        border-zinc-700
                                        bg-zinc-900
                                        px-5
                                        py-3.5
                                        text-sm
                                        font-bold
                                        text-zinc-300
                                        transition
                                        hover:border-orange-500/30
                                        hover:bg-orange-500/5
                                        hover:text-orange-400
                                    "
                                >

                                    <x-lucide-printer
                                        class="h-4 w-4"
                                    />

                                    چاپ QR Code

                                </button>


                                <a
                                    href="{{ $publicUrl }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="
                                        inline-flex
                                        items-center
                                        justify-center
                                        gap-2
                                        rounded-2xl
                                        border
                                        border-zinc-800
                                        bg-black/20
                                        px-5
                                        py-3.5
                                        text-sm
                                        font-bold
                                        text-zinc-400
                                        transition
                                        hover:border-zinc-700
                                        hover:text-white
                                    "
                                >

                                    <x-lucide-external-link
                                        class="h-4 w-4"
                                    />

                                    مشاهده صفحه سالن

                                </a>

                            </div>


                            {{-- Notice --}}

                            <div class="mt-auto pt-6">

                                <div
                                    class="
                                        rounded-2xl
                                        border
                                        border-green-500/10
                                        bg-green-500/[0.03]
                                        p-4
                                    "
                                >

                                    <div
                                        class="
                                            flex
                                            items-start
                                            gap-3
                                        "
                                    >

                                        <x-lucide-shield-check
                                            class="
                                                mt-0.5
                                                h-4
                                                w-4
                                                shrink-0
                                                text-green-500
                                            "
                                        />

                                        <div>

                                            <p
                                                class="
                                                    text-xs
                                                    font-black
                                                    text-green-400
                                                "
                                            >
                                                QR Code دائمی است
                                            </p>

                                            <p
                                                class="
                                                    mt-1
                                                    text-[11px]
                                                    leading-5
                                                    text-zinc-600
                                                "
                                            >
                                                این QR Code به سالن شما اختصاص دارد
                                                و پس از ایجاد، تغییر یا حذف نمی‌شود.
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endif

            </div>

        </div>


        {{-- =====================================================
            SIDEBAR
        ====================================================== --}}

        <div class="space-y-6 xl:col-span-4">


            {{-- Salon Card --}}

            <div
                class="
                    rounded-3xl
                    border
                    border-zinc-800
                    bg-zinc-950
                    p-5
                    sm:p-6
                "
            >

                <div class="flex items-center gap-3">

                    <div
                        class="
                            flex
                            h-11
                            w-11
                            shrink-0
                            items-center
                            justify-center
                            rounded-2xl
                            bg-orange-500/10
                        "
                    >

                        <x-lucide-store
                            class="h-5 w-5 text-orange-500"
                        />

                    </div>

                    <div class="min-w-0">

                        <p class="text-xs font-bold text-zinc-600">
                            سالن فعال
                        </p>

                        <h2
                            class="
                                mt-1
                                truncate
                                font-black
                                text-white
                            "
                        >
                            {{ $salon?->name ?? 'سالن شما' }}
                        </h2>

                    </div>

                </div>


                <div class="mt-6 space-y-3">

                    {{-- Phone --}}

                    <div
                        class="
                            flex
                            items-center
                            justify-between
                            gap-4
                            rounded-2xl
                            border
                            border-zinc-800
                            bg-black/20
                            px-4
                            py-3
                        "
                    >

                        <div class="flex items-center gap-3">

                            <x-lucide-phone
                                class="h-4 w-4 text-zinc-600"
                            />

                            <span class="text-xs text-zinc-500">
                                تلفن
                            </span>

                        </div>

                        <span
                            dir="ltr"
                            class="
                                truncate
                                text-xs
                                font-bold
                                text-zinc-300
                            "
                        >
                            {{ $salon?->phone ?? 'ثبت نشده' }}
                        </span>

                    </div>


                    {{-- Address --}}

                    <div
                        class="
                            flex
                            items-start
                            gap-3
                            rounded-2xl
                            border
                            border-zinc-800
                            bg-black/20
                            px-4
                            py-3
                        "
                    >

                        <x-lucide-map-pin
                            class="
                                mt-0.5
                                h-4
                                w-4
                                shrink-0
                                text-zinc-600
                            "
                        />

                        <div class="min-w-0">

                            <p class="text-xs text-zinc-600">
                                آدرس
                            </p>

                            <p
                                class="
                                    mt-1
                                    line-clamp-2
                                    text-xs
                                    font-bold
                                    leading-5
                                    text-zinc-300
                                "
                            >
                                {{ $salon?->address ?? 'ثبت نشده' }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                How It Works
            ================================================== --}}

            <div
                class="
                    rounded-3xl
                    border
                    border-zinc-800
                    bg-zinc-950
                    p-5
                    sm:p-6
                "
            >

                <div class="flex items-center gap-3">

                    <div
                        class="
                            flex
                            h-11
                            w-11
                            shrink-0
                            items-center
                            justify-center
                            rounded-2xl
                            bg-zinc-900
                        "
                    >

                        <x-lucide-scan-line
                            class="h-5 w-5 text-zinc-300"
                        />

                    </div>

                    <div>

                        <h2 class="font-black text-white">
                            چطور کار می‌کند؟
                        </h2>

                        <p class="mt-1 text-xs text-zinc-600">
                            مسیر مشتری تا رزرو
                        </p>

                    </div>

                </div>


                <div class="mt-6 space-y-5">

                    <div class="flex gap-3">

                        <div
                            class="
                                flex
                                h-8
                                w-8
                                shrink-0
                                items-center
                                justify-center
                                rounded-xl
                                bg-orange-500/10
                                text-xs
                                font-black
                                text-orange-500
                            "
                        >
                            ۱
                        </div>

                        <div>

                            <p class="text-sm font-bold text-zinc-300">
                                اسکن QR
                            </p>

                            <p
                                class="
                                    mt-1
                                    text-xs
                                    leading-5
                                    text-zinc-600
                                "
                            >
                                مشتری QR Code را با دوربین موبایل اسکن می‌کند.
                            </p>

                        </div>

                    </div>


                    <div class="flex gap-3">

                        <div
                            class="
                                flex
                                h-8
                                w-8
                                shrink-0
                                items-center
                                justify-center
                                rounded-xl
                                bg-orange-500/10
                                text-xs
                                font-black
                                text-orange-500
                            "
                        >
                            ۲
                        </div>

                        <div>

                            <p class="text-sm font-bold text-zinc-300">
                                ورود به صفحه سالن
                            </p>

                            <p
                                class="
                                    mt-1
                                    text-xs
                                    leading-5
                                    text-zinc-600
                                "
                            >
                                صفحه اختصاصی سالن برای مشتری نمایش داده می‌شود.
                            </p>

                        </div>

                    </div>


                    <div class="flex gap-3">

                        <div
                            class="
                                flex
                                h-8
                                w-8
                                shrink-0
                                items-center
                                justify-center
                                rounded-xl
                                bg-orange-500/10
                                text-xs
                                font-black
                                text-orange-500
                            "
                        >
                            ۳
                        </div>

                        <div>

                            <p class="text-sm font-bold text-zinc-300">
                                انتخاب سرویس
                            </p>

                            <p
                                class="
                                    mt-1
                                    text-xs
                                    leading-5
                                    text-zinc-600
                                "
                            >
                                مشتری خدمات، تاریخ و ساعت مناسب را انتخاب می‌کند.
                            </p>

                        </div>

                    </div>


                    <div class="flex gap-3">

                        <div
                            class="
                                flex
                                h-8
                                w-8
                                shrink-0
                                items-center
                                justify-center
                                rounded-xl
                                bg-orange-500/10
                                text-xs
                                font-black
                                text-orange-500
                            "
                        >
                            ۴
                        </div>

                        <div>

                            <p class="text-sm font-bold text-zinc-300">
                                ثبت نوبت
                            </p>

                            <p
                                class="
                                    mt-1
                                    text-xs
                                    leading-5
                                    text-zinc-600
                                "
                            >
                                درخواست رزرو برای شما ارسال می‌شود.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Print Hint --}}

            <div
                class="
                    rounded-3xl
                    border
                    border-orange-500/10
                    bg-orange-500/[0.03]
                    p-5
                "
            >

                <div class="flex items-start gap-3">

                    <x-lucide-lightbulb
                        class="
                            mt-0.5
                            h-4
                            w-4
                            shrink-0
                            text-orange-500
                        "
                    />

                    <p
                        class="
                            text-xs
                            leading-6
                            text-zinc-500
                        "
                    >
                        پیشنهاد می‌کنیم QR Code را روی شیشه ورودی،
                        کارت ویزیت، استند یا میز پذیرش قرار دهید تا مشتری
                        همیشه راه سریع و مستقیمی برای رزرو داشته باشد.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        Print Only Area
    ========================================================== --}}

    @if($hasQr)

        <div
            id="qr-print-area"
            class="hidden"
        >

            <div
                class="
                    mx-auto
                    max-w-xl
                    p-10
                    text-center
                "
            >

                <h1
                    class="
                        text-3xl
                        font-black
                        text-black
                    "
                >
                    {{ $salon->name }}
                </h1>


                <p
                    class="
                        mt-3
                        text-sm
                        text-black
                    "
                >
                    برای رزرو نوبت، QR Code را اسکن کنید.
                </p>


                @if($qrSvg)

                    <div
                        class="
                            mx-auto
                            mt-8
                            h-80
                            w-80
                            [&>svg]:block
                            [&>svg]:h-full
                            [&>svg]:w-full
                        "
                    >

                        {!! $qrSvg !!}

                    </div>

                @endif


                <p
                    dir="ltr"
                    class="
                        mt-6
                        break-all
                        text-sm
                        text-black
                    "
                >
                    {{ $publicUrl }}
                </p>

            </div>

        </div>

    @endif


    {{-- =========================================================
        Print Styles
    ========================================================== --}}

    @if($hasQr)

        <style>

            @media print {

                body * {
                    visibility: hidden !important;
                }

                #qr-print-area,
                #qr-print-area * {
                    visibility: visible !important;
                }

                #qr-print-area {
                    display: block !important;
                    position: absolute;
                    inset: 0;
                    width: 100%;
                    min-height: 100vh;
                    background: white !important;
                    color: black !important;
                }

            }

        </style>

    @endif

</x-layouts.dashboard>
