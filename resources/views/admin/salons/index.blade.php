<x-layouts.dashboard>

    {{-- =========================================================
        Page Header
    ========================================================== --}}

    <div class="mb-8">

        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <div class="flex items-center gap-2">

                    <span
                        class="h-2 w-2 rounded-full bg-orange-500 shadow-[0_0_12px_rgba(249,115,22,.7)]"
                    ></span>

                    <p class="text-sm font-bold text-orange-500">
                        مدیریت سیستم
                    </p>

                </div>

                <h1 class="mt-2 text-3xl font-black tracking-tight text-white sm:text-4xl">
                    سالن‌ها
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-7 text-zinc-500">
                    آرایشگرها و سالن‌های ثبت‌شده در BarberBook را مدیریت کنید.
                </p>

            </div>


            <a
                href="{{ route('admin.salons.create') }}"
                class="
                    inline-flex
                    w-full
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
                    shadow-lg
                    shadow-orange-500/10
                    transition
                    hover:bg-orange-400
                    active:scale-[.99]
                    sm:w-auto
                "
            >

                <x-lucide-plus class="h-5 w-5" />

                ایجاد سالن جدید

            </a>

        </div>

    </div>


    {{-- =========================================================
        Flash
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

            <x-lucide-check-circle-2 class="mt-0.5 h-5 w-5 shrink-0 text-green-500" />

            <p class="text-sm font-bold leading-6 text-green-400">
                {{ session('success') }}
            </p>

        </div>

    @endif


    @if(session('error'))

        <div
            class="
                mb-6
                flex
                items-start
                gap-3
                rounded-2xl
                border
                border-red-500/10
                bg-red-500/5
                p-4
            "
        >

            <x-lucide-circle-alert class="mt-0.5 h-5 w-5 shrink-0 text-red-400" />

            <p class="text-sm font-bold leading-6 text-red-400">
                {{ session('error') }}
            </p>

        </div>

    @endif


    {{-- =========================================================
        Summary
    ========================================================== --}}

    <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

        <div
            class="
                rounded-2xl
                border
                border-zinc-800
                bg-zinc-950
                p-5
            "
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs text-zinc-600">
                        مجموع سالن‌ها
                    </p>

                    <p class="mt-2 text-2xl font-black text-white">
                        {{ $salons->total() }}
                    </p>

                </div>

                <div
                    class="
                        flex
                        h-11
                        w-11
                        items-center
                        justify-center
                        rounded-2xl
                        bg-orange-500/10
                    "
                >

                    <x-lucide-store class="h-5 w-5 text-orange-500" />

                </div>

            </div>

        </div>


        <div
            class="
                rounded-2xl
                border
                border-zinc-800
                bg-zinc-950
                p-5
            "
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs text-zinc-600">
                        نمایش این صفحه
                    </p>

                    <p class="mt-2 text-2xl font-black text-white">
                        {{ $salons->count() }}
                    </p>

                </div>

                <div
                    class="
                        flex
                        h-11
                        w-11
                        items-center
                        justify-center
                        rounded-2xl
                        bg-blue-500/10
                    "
                >

                    <x-lucide-list class="h-5 w-5 text-blue-400" />

                </div>

            </div>

        </div>


        <div
            class="
                rounded-2xl
                border
                border-zinc-800
                bg-zinc-950
                p-5
                sm:col-span-2
                lg:col-span-1
            "
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs text-zinc-600">
                        QR فعال
                    </p>

                    <p class="mt-2 text-2xl font-black text-white">
                        {{ $salons->whereNotNull('qr_token')->count() }}
                    </p>

                </div>

                <div
                    class="
                        flex
                        h-11
                        w-11
                        items-center
                        justify-center
                        rounded-2xl
                        bg-green-500/10
                    "
                >

                    <x-lucide-qr-code class="h-5 w-5 text-green-500" />

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        Search
    ========================================================== --}}

    <form
        method="GET"
        action="{{ route('admin.salons.index') }}"
        class="
            mb-6
            rounded-2xl
            border
            border-zinc-800
            bg-zinc-950
            p-4
        "
    >

        <div class="flex flex-col gap-3 sm:flex-row">

            <div class="relative flex-1">

                <x-lucide-search
                    class="
                        pointer-events-none
                        absolute
                        right-4
                        top-1/2
                        h-4
                        w-4
                        -translate-y-1/2
                        text-zinc-600
                    "
                />

                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="جستجوی سالن، آرایشگر، ایمیل یا موبایل..."
                    class="
                        w-full
                        rounded-xl
                        border
                        border-zinc-800
                        bg-zinc-900
                        py-3
                        pl-4
                        pr-11
                        text-sm
                        text-white
                        outline-none
                        transition
                        placeholder:text-zinc-700
                        focus:border-orange-500/50
                    "
                >

            </div>


            <button
                type="submit"
                class="
                    inline-flex
                    items-center
                    justify-center
                    gap-2
                    rounded-xl
                    bg-zinc-800
                    px-5
                    py-3
                    text-sm
                    font-bold
                    text-zinc-200
                    transition
                    hover:bg-zinc-700
                "
            >

                <x-lucide-search class="h-4 w-4" />

                جستجو

            </button>


            @if(request('search'))

                <a
                    href="{{ route('admin.salons.index') }}"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        rounded-xl
                        border
                        border-zinc-800
                        px-5
                        py-3
                        text-sm
                        font-bold
                        text-zinc-500
                        transition
                        hover:text-white
                    "
                >
                    پاک کردن
                </a>

            @endif

        </div>

    </form>


    {{-- =========================================================
        Desktop Table
    ========================================================== --}}

    <div
        class="
            hidden
            overflow-hidden
            rounded-3xl
            border
            border-zinc-800
            bg-zinc-950
            lg:block
        "
    >

        <div class="overflow-x-auto">

            <table class="w-full text-right">

                <thead class="border-b border-zinc-800 bg-zinc-900/60">

                <tr>

                    <th class="px-5 py-4 text-xs font-bold text-zinc-500">
                        سالن
                    </th>

                    <th class="px-5 py-4 text-xs font-bold text-zinc-500">
                        مدیر
                    </th>

                    <th class="px-5 py-4 text-xs font-bold text-zinc-500">
                        تماس
                    </th>

                    <th class="px-5 py-4 text-xs font-bold text-zinc-500">
                        QR
                    </th>

                    <th class="px-5 py-4 text-xs font-bold text-zinc-500">
                        وضعیت
                    </th>

                    <th class="px-5 py-4 text-xs font-bold text-zinc-500">
                        عملیات
                    </th>

                </tr>

                </thead>


                <tbody class="divide-y divide-zinc-800">

                @forelse($salons as $salon)

                    <tr class="transition hover:bg-zinc-900/40">

                        {{-- Salon --}}

                        <td class="px-5 py-4">

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
                                            bg-orange-500/10
                                            font-black
                                            text-orange-500
                                        "
                                >
                                    {{ mb_substr($salon->name, 0, 1) }}
                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-black text-white">
                                        {{ $salon->name }}
                                    </p>

                                    <p
                                        dir="ltr"
                                        class="
                                                mt-1
                                                truncate
                                                text-left
                                                text-[11px]
                                                text-zinc-600
                                            "
                                    >
                                        /{{ $salon->slug }}
                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- Owner --}}

                        <td class="px-5 py-4">

                            @if($salon->user)

                                <p class="text-sm font-bold text-zinc-300">
                                    {{ $salon->user->full_name }}
                                </p>

                                <p
                                    dir="ltr"
                                    class="mt-1 text-xs text-zinc-600"
                                >
                                    {{ $salon->user->email }}
                                </p>

                            @else

                                <span class="text-xs text-red-400">
                                        مالک ندارد
                                    </span>

                            @endif

                        </td>


                        {{-- Phone --}}

                        <td class="px-5 py-4">

                            <p
                                dir="ltr"
                                class="
                                        text-xs
                                        font-bold
                                        text-zinc-400
                                    "
                            >
                                {{ $salon->phone ?? $salon->user?->phone ?? '—' }}
                            </p>

                        </td>


                        {{-- QR --}}

                        <td class="px-5 py-4">

                            @if(filled($salon->qr_token))

                                <span
                                    class="
                                            inline-flex
                                            items-center
                                            gap-1.5
                                            rounded-full
                                            border
                                            border-green-500/10
                                            bg-green-500/5
                                            px-3
                                            py-1.5
                                            text-[11px]
                                            font-bold
                                            text-green-400
                                        "
                                >

                                        <span class="h-1.5 w-1.5 rounded-full bg-green-400"></span>

                                        فعال

                                    </span>

                            @else

                                <span
                                    class="
                                            inline-flex
                                            items-center
                                            gap-1.5
                                            rounded-full
                                            border
                                            border-zinc-700
                                            bg-zinc-900
                                            px-3
                                            py-1.5
                                            text-[11px]
                                            font-bold
                                            text-zinc-500
                                        "
                                >

                                        ساخته نشده

                                    </span>

                            @endif

                        </td>


                        {{-- Status --}}

                        <td class="px-5 py-4">

                            @if($salon->is_active)

                                <span
                                    class="
                                            inline-flex
                                            items-center
                                            gap-1.5
                                            text-xs
                                            font-bold
                                            text-green-400
                                        "
                                >

                                        <span class="h-2 w-2 rounded-full bg-green-400"></span>

                                        فعال

                                    </span>

                            @else

                                <span
                                    class="
                                            inline-flex
                                            items-center
                                            gap-1.5
                                            text-xs
                                            font-bold
                                            text-red-400
                                        "
                                >

                                        <span class="h-2 w-2 rounded-full bg-red-400"></span>

                                        غیرفعال

                                    </span>

                            @endif

                        </td>


                        {{-- Actions --}}

                        <td class="px-5 py-4">

                            <div class="flex items-center gap-2">

                                <a
                                    href="{{ route('admin.salons.edit', $salon) }}"
                                    class="
                                            flex
                                            h-9
                                            w-9
                                            items-center
                                            justify-center
                                            rounded-xl
                                            border
                                            border-zinc-800
                                            text-zinc-500
                                            transition
                                            hover:border-orange-500/30
                                            hover:bg-orange-500/5
                                            hover:text-orange-400
                                        "
                                    title="ویرایش"
                                >

                                    <x-lucide-pencil class="h-4 w-4" />

                                </a>


                                <a
                                    href="{{ route('salon.public', ['qr_token' => $salon->qr_token]) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="
                                            flex
                                            h-9
                                            w-9
                                            items-center
                                            justify-center
                                            rounded-xl
                                            border
                                            border-zinc-800
                                            text-zinc-500
                                            transition
                                            hover:border-blue-500/30
                                            hover:bg-blue-500/5
                                            hover:text-blue-400
                                        "
                                    title="صفحه سالن"
                                    @if(!filled($salon->qr_token)) aria-disabled="true" onclick="return false;" @endif
                                >

                                    <x-lucide-external-link class="h-4 w-4" />

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-5 py-16 text-center"
                        >

                            <div
                                class="
                                        mx-auto
                                        flex
                                        h-14
                                        w-14
                                        items-center
                                        justify-center
                                        rounded-2xl
                                        bg-zinc-900
                                    "
                            >

                                <x-lucide-store class="h-6 w-6 text-zinc-700" />

                            </div>

                            <p class="mt-4 font-bold text-zinc-400">
                                هنوز سالنی ثبت نشده است.
                            </p>

                            <p class="mt-1 text-xs text-zinc-600">
                                اولین سالن را ایجاد کنید.
                            </p>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =========================================================
        Mobile Cards
    ========================================================== --}}

    <div class="space-y-3 lg:hidden">

        @forelse($salons as $salon)

            <article
                class="
                    rounded-2xl
                    border
                    border-zinc-800
                    bg-zinc-950
                    p-4
                "
            >

                <div class="flex items-start justify-between gap-3">

                    <div class="flex min-w-0 items-center gap-3">

                        <div
                            class="
                                flex
                                h-11
                                w-11
                                shrink-0
                                items-center
                                justify-center
                                rounded-xl
                                bg-orange-500/10
                                font-black
                                text-orange-500
                            "
                        >
                            {{ mb_substr($salon->name, 0, 1) }}
                        </div>

                        <div class="min-w-0">

                            <h3 class="truncate text-sm font-black text-white">
                                {{ $salon->name }}
                            </h3>

                            <p class="mt-1 truncate text-xs text-zinc-600">
                                {{ $salon->user?->full_name ?? 'مالک نامشخص' }}
                            </p>

                        </div>

                    </div>


                    @if($salon->is_active)

                        <span
                            class="
                                shrink-0
                                rounded-full
                                bg-green-500/10
                                px-2.5
                                py-1
                                text-[10px]
                                font-bold
                                text-green-400
                            "
                        >
                            فعال
                        </span>

                    @else

                        <span
                            class="
                                shrink-0
                                rounded-full
                                bg-red-500/10
                                px-2.5
                                py-1
                                text-[10px]
                                font-bold
                                text-red-400
                            "
                        >
                            غیرفعال
                        </span>

                    @endif

                </div>


                <div
                    class="
                        mt-4
                        grid
                        grid-cols-2
                        gap-2
                    "
                >

                    <div
                        class="
                            rounded-xl
                            border
                            border-zinc-800
                            bg-zinc-900/50
                            p-3
                        "
                    >

                        <p class="text-[10px] text-zinc-600">
                            موبایل
                        </p>

                        <p
                            dir="ltr"
                            class="mt-1 truncate text-xs font-bold text-zinc-300"
                        >
                            {{ $salon->phone ?? $salon->user?->phone ?? '—' }}
                        </p>

                    </div>


                    <div
                        class="
                            rounded-xl
                            border
                            border-zinc-800
                            bg-zinc-900/50
                            p-3
                        "
                    >

                        <p class="text-[10px] text-zinc-600">
                            QR
                        </p>

                        <p class="mt-1 text-xs font-bold">
                            @if(filled($salon->qr_token))

                                <span class="text-green-400">
                                    فعال
                                </span>

                            @else

                                <span class="text-zinc-600">
                                    ساخته نشده
                                </span>

                            @endif
                        </p>

                    </div>

                </div>


                <div class="mt-4 grid grid-cols-2 gap-2">

                    <a
                        href="{{ route('admin.salons.edit', $salon) }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            gap-2
                            rounded-xl
                            border
                            border-zinc-800
                            px-4
                            py-3
                            text-xs
                            font-bold
                            text-zinc-300
                            transition
                            hover:border-orange-500/30
                            hover:text-orange-400
                        "
                    >

                        <x-lucide-pencil class="h-4 w-4" />

                        ویرایش

                    </a>


                    <a
                        href="{{ route('salon.public', ['qr_token' => $salon->qr_token]) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            gap-2
                            rounded-xl
                            bg-orange-500
                            px-4
                            py-3
                            text-xs
                            font-black
                            text-black
                            transition
                            hover:bg-orange-400
                        "
                        @if(!filled($salon->qr_token)) aria-disabled="true" onclick="return false;" @endif
                    >

                        <x-lucide-external-link class="h-4 w-4" />

                        صفحه سالن

                    </a>

                </div>

            </article>

        @empty

            <div
                class="
                    rounded-2xl
                    border
                    border-dashed
                    border-zinc-800
                    bg-zinc-950
                    p-10
                    text-center
                "
            >

                <x-lucide-store
                    class="
                        mx-auto
                        h-8
                        w-8
                        text-zinc-700
                    "
                />

                <p class="mt-4 font-bold text-zinc-400">
                    هنوز سالنی ثبت نشده است.
                </p>

            </div>

        @endforelse

    </div>


    {{-- =========================================================
        Pagination
    ========================================================== --}}

    @if($salons->hasPages())

        <div class="mt-6">

            {{ $salons->links() }}

        </div>

    @endif

</x-layouts.dashboard>
