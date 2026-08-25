<x-layouts.dashboard>

    {{-- =========================================================
        Header
    ========================================================== --}}

    <div class="mb-8">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <div class="flex items-center gap-2">

                    <span
                        class="h-2 w-2 rounded-full bg-orange-500 shadow-[0_0_12px_rgba(249,115,22,.7)]"
                    ></span>

                    <p class="text-sm font-bold text-orange-500">
                        مدیریت نمونه‌کارها
                    </p>

                </div>

                <h1 class="mt-2 text-3xl font-black tracking-tight text-white sm:text-4xl">
                    گالری
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-7 text-zinc-500">
                    نمونه‌کارهای قبل و بعد
                    {{ $salon?->name ?? 'آرایشگاه' }}
                    را مدیریت کنید.
                </p>

            </div>


            <a
                href="{{ route('gallery.create') }}"
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
                    transition
                    hover:bg-orange-400
                    sm:w-auto
                "
            >

                <x-lucide-plus class="h-5 w-5" />

                افزودن نمونه‌کار

            </a>

        </div>

    </div>


    {{-- =========================================================
        Flash
    ========================================================== --}}

    @if(session('success'))

        <div
            class="mb-6 flex items-start gap-3 rounded-2xl border border-green-500/10 bg-green-500/5 p-4"
        >

            <x-lucide-check-circle-2
                class="mt-0.5 h-5 w-5 shrink-0 text-green-500"
            />

            <p class="text-sm font-bold leading-6 text-green-400">
                {{ session('success') }}
            </p>

        </div>

    @endif


    @if(session('error'))

        <div
            class="mb-6 flex items-start gap-3 rounded-2xl border border-red-500/10 bg-red-500/5 p-4"
        >

            <x-lucide-circle-alert
                class="mt-0.5 h-5 w-5 shrink-0 text-red-400"
            />

            <p class="text-sm font-bold leading-6 text-red-400">
                {{ session('error') }}
            </p>

        </div>

    @endif


    {{-- =========================================================
        Summary
    ========================================================== --}}

    @if($galleryItems->total() > 0)

        <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

            <div class="rounded-2xl border border-zinc-800 bg-zinc-950 p-5">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs text-zinc-600">
                            مجموع نمونه‌کارها
                        </p>

                        <p class="mt-2 text-2xl font-black text-white">
                            {{ $galleryItems->total() }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500/10">
                        <x-lucide-images class="h-5 w-5 text-orange-500" />
                    </div>

                </div>

            </div>


            <div class="rounded-2xl border border-zinc-800 bg-zinc-950 p-5">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs text-zinc-600">
                            این صفحه
                        </p>

                        <p class="mt-2 text-2xl font-black text-white">
                            {{ $galleryItems->count() }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-500/10">
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

                    <div class="min-w-0">

                        <p class="text-xs text-zinc-600">
                            سالن
                        </p>

                        <p class="mt-2 truncate text-sm font-black text-white">
                            {{ $salon?->name ?? 'آرایشگاه' }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-green-500/10">
                        <x-lucide-store class="h-5 w-5 text-green-500" />
                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- =========================================================
        Gallery Items
    ========================================================== --}}

    <div class="space-y-5">

        @forelse($galleryItems as $item)

            @php

                $beforeUrl = filled($item->before_image)
                    ? Storage::url($item->before_image)
                    : null;

                $afterUrl = filled($item->after_image)
                    ? Storage::url($item->after_image)
                    : null;

            @endphp


            <article
                class="
                    overflow-hidden
                    rounded-3xl
                    border
                    border-zinc-800
                    bg-zinc-950
                "
            >

                {{-- =================================================
                    Before / After
                ================================================== --}}

                <div class="grid grid-cols-2 gap-px bg-zinc-800">

                    {{-- Before --}}

                    <div class="relative aspect-[4/3] overflow-hidden bg-zinc-900">

                        @if($beforeUrl)

                            <img
                                src="{{ $beforeUrl }}"
                                alt="{{ ($item->alt_text ?: $item->title ?: 'نمونه‌کار') . ' - قبل' }}"
                                loading="lazy"
                                class="h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full items-center justify-center text-zinc-700">
                                <x-lucide-image-off class="h-8 w-8" />
                            </div>

                        @endif


                        <span
                            class="
                                absolute
                                right-3
                                top-3
                                rounded-full
                                border
                                border-white/10
                                bg-black/70
                                px-3
                                py-1.5
                                text-[10px]
                                font-black
                                text-white
                                backdrop-blur
                            "
                        >
                            قبل
                        </span>

                    </div>


                    {{-- After --}}

                    <div class="relative aspect-[4/3] overflow-hidden bg-zinc-900">

                        @if($afterUrl)

                            <img
                                src="{{ $afterUrl }}"
                                alt="{{ ($item->alt_text ?: $item->title ?: 'نمونه‌کار') . ' - بعد' }}"
                                loading="lazy"
                                class="h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full items-center justify-center text-zinc-700">
                                <x-lucide-image-off class="h-8 w-8" />
                            </div>

                        @endif


                        <span
                            class="
                                absolute
                                right-3
                                top-3
                                rounded-full
                                bg-orange-500
                                px-3
                                py-1.5
                                text-[10px]
                                font-black
                                text-black
                            "
                        >
                            بعد
                        </span>

                    </div>

                </div>


                {{-- =================================================
                    Content
                ================================================== --}}

                <div class="p-5 sm:p-6">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-2">

                                <span class="text-[10px] font-black uppercase tracking-widest text-orange-500">
                                    Before / After
                                </span>


                                @if($item->is_active)

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-green-500/10 px-2.5 py-1 text-[10px] font-bold text-green-400"
                                    >
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-400"></span>
                                        فعال
                                    </span>

                                @else

                                    <span
                                        class="inline-flex rounded-full bg-zinc-800 px-2.5 py-1 text-[10px] font-bold text-zinc-500"
                                    >
                                        غیرفعال
                                    </span>

                                @endif

                            </div>


                            <h2 class="mt-2 text-lg font-black text-white">
                                {{ $item->title ?: 'نمونه‌کار بدون عنوان' }}
                            </h2>


                            @if($item->description)

                                <p class="mt-2 text-xs leading-6 text-zinc-500">
                                    {{ $item->description }}
                                </p>

                            @endif

                        </div>


                        <span
                            class="
                                inline-flex
                                w-fit
                                shrink-0
                                items-center
                                gap-2
                                rounded-xl
                                border
                                border-zinc-800
                                bg-zinc-900
                                px-3
                                py-2
                                text-[10px]
                                font-bold
                                text-zinc-500
                            "
                        >

                            <x-lucide-arrow-down-up class="h-3.5 w-3.5" />

                            ترتیب {{ $item->sort_order }}

                        </span>

                    </div>


                    {{-- =================================================
                        Actions
                    ================================================== --}}

                    <div class="mt-5 grid gap-2 sm:grid-cols-3">

                        <a
                            href="{{ route('gallery.edit', $item) }}"
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
                                hover:bg-orange-500/5
                                hover:text-orange-400
                            "
                        >

                            <x-lucide-pencil class="h-4 w-4" />

                            ویرایش

                        </a>


                        @if($afterUrl)

                            <a
                                href="{{ $afterUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
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
                                    hover:border-blue-500/30
                                    hover:bg-blue-500/5
                                    hover:text-blue-400
                                "
                            >

                                <x-lucide-external-link class="h-4 w-4" />

                                مشاهده تصویر

                            </a>

                        @else

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    rounded-xl
                                    border
                                    border-zinc-800
                                    px-4
                                    py-3
                                    text-xs
                                    text-zinc-700
                                "
                            >
                                تصویر موجود نیست
                            </span>

                        @endif


                        <form
                            method="POST"
                            action="{{ route('gallery.destroy', $item) }}"
                            onsubmit="return confirm('آیا از حذف این نمونه‌کار مطمئن هستید؟ این عملیات قابل بازگشت نیست.');"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="
                                    flex
                                    w-full
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-xl
                                    border
                                    border-red-500/10
                                    bg-red-500/5
                                    px-4
                                    py-3
                                    text-xs
                                    font-bold
                                    text-red-400
                                    transition
                                    hover:bg-red-500/10
                                "
                            >

                                <x-lucide-trash-2 class="h-4 w-4" />

                                حذف

                            </button>

                        </form>

                    </div>

                </div>

            </article>

        @empty

            <div
                class="
                    rounded-3xl
                    border
                    border-dashed
                    border-zinc-800
                    bg-zinc-950
                    p-10
                    text-center
                    sm:p-14
                "
            >

                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-zinc-900"
                >
                    <x-lucide-images class="h-7 w-7 text-zinc-600" />
                </div>


                <h2 class="mt-5 text-lg font-black text-white">
                    هنوز نمونه‌کاری ثبت نشده است
                </h2>


                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-zinc-500">
                    اولین نمونه‌کار قبل و بعد را اضافه کنید تا در گالری سالن نمایش داده شود.
                </p>


                <a
                    href="{{ route('gallery.create') }}"
                    class="
                        mt-6
                        inline-flex
                        items-center
                        gap-2
                        rounded-xl
                        bg-orange-500
                        px-5
                        py-3
                        text-sm
                        font-black
                        text-black
                        transition
                        hover:bg-orange-400
                    "
                >

                    <x-lucide-plus class="h-5 w-5" />

                    افزودن اولین نمونه‌کار

                </a>

            </div>

        @endforelse

    </div>


    {{-- =========================================================
        Pagination
    ========================================================== --}}

    @if($galleryItems->hasPages())

        <div
            class="
                mt-8
                rounded-2xl
                border
                border-zinc-800
                bg-zinc-950
                p-4
            "
        >

            {{ $galleryItems->links() }}

        </div>

    @endif

</x-layouts.dashboard>
