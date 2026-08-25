<x-layouts.dashboard>

    {{-- =========================================================
        Header
    ========================================================== --}}

    <div class="mb-8">

        <a
            href="{{ route('gallery.index') }}"
            class="inline-flex items-center gap-2 text-xs font-bold text-zinc-500 transition hover:text-orange-400"
        >

            <x-lucide-arrow-right class="h-4 w-4" />

            بازگشت به گالری

        </a>


        <div class="mt-5">

            <div class="flex items-center gap-2">

                <span class="h-2 w-2 rounded-full bg-orange-500"></span>

                <p class="text-sm font-bold text-orange-500">
                    ویرایش نمونه‌کار
                </p>

            </div>


            <h1 class="mt-2 text-3xl font-black text-white sm:text-4xl">
                {{ $galleryItem->title ?: 'ویرایش نمونه‌کار' }}
            </h1>


            <p class="mt-2 max-w-2xl text-sm leading-7 text-zinc-500">
                تصاویر و اطلاعات این نمونه‌کار را به‌روزرسانی کنید.
            </p>

        </div>

    </div>


    {{-- =========================================================
        Errors
    ========================================================== --}}

    @if($errors->any())

        <div class="mb-6 rounded-2xl border border-red-500/20 bg-red-500/5 p-5">

            <div class="flex items-start gap-3">

                <x-lucide-circle-alert class="mt-0.5 h-5 w-5 shrink-0 text-red-400" />

                <div>

                    <p class="text-sm font-black text-red-400">
                        اطلاعات واردشده را بررسی کنید.
                    </p>

                    <ul class="mt-2 space-y-1">

                        @foreach($errors->all() as $error)

                            <li class="text-xs leading-6 text-red-400/80">
                                • {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- =========================================================
        Form
    ========================================================== --}}

    <form
        action="{{ route('gallery.update', $galleryItem) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf

        @method('PUT')


        {{-- =====================================================
            Images
        ====================================================== --}}

        <section class="overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-950">

            <div class="border-b border-zinc-800 bg-zinc-900/40 p-5 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500/10">
                        <x-lucide-images class="h-5 w-5 text-orange-500" />
                    </div>

                    <div>

                        <h2 class="font-black text-white">
                            تصاویر قبل و بعد
                        </h2>

                        <p class="mt-1 text-xs text-zinc-600">
                            با انتخاب تصویر جدید، تصویر قبلی جایگزین می‌شود.
                        </p>

                    </div>

                </div>

            </div>


            <div class="grid gap-6 p-5 sm:grid-cols-2 sm:p-6">

                {{-- Before --}}

                <div>

                    <div class="flex items-center justify-between gap-3">

                        <label
                            for="before_image"
                            class="text-sm font-bold text-zinc-300"
                        >
                            تصویر قبل
                        </label>

                        <span class="rounded-full bg-zinc-800 px-2.5 py-1 text-[10px] font-bold text-zinc-500">
                            قبل
                        </span>

                    </div>


                    @if($galleryItem->before_image)

                        <div class="mt-3 overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-900">

                            <img
                                src="{{ Storage::url($galleryItem->before_image) }}"
                                alt="{{ ($galleryItem->alt_text ?: $galleryItem->title ?: 'نمونه‌کار') . ' - قبل' }}"
                                class="aspect-[4/3] w-full object-cover"
                            >

                        </div>

                    @else

                        <div class="mt-3 flex aspect-[4/3] items-center justify-center rounded-3xl border border-dashed border-zinc-700 bg-zinc-900/50">

                            <x-lucide-image-off class="h-8 w-8 text-zinc-700" />

                        </div>

                    @endif


                    <input
                        id="before_image"
                        type="file"
                        name="before_image"
                        accept="image/jpeg,image/png,image/webp"
                        class="mt-3 block w-full text-sm text-zinc-500 file:mr-4 file:rounded-xl file:border-0 file:bg-orange-500/10 file:px-4 file:py-2.5 file:text-xs file:font-bold file:text-orange-400 hover:file:bg-orange-500/20"
                    >


                    <p class="mt-2 text-[11px] text-zinc-600">
                        اختیاری — فقط در صورت نیاز به تغییر تصویر انتخاب کنید.
                    </p>


                    @error('before_image')

                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>

                    @enderror

                </div>


                {{-- After --}}

                <div>

                    <div class="flex items-center justify-between gap-3">

                        <label
                            for="after_image"
                            class="text-sm font-bold text-zinc-300"
                        >
                            تصویر بعد
                        </label>

                        <span class="rounded-full bg-orange-500 px-2.5 py-1 text-[10px] font-black text-black">
                            بعد
                        </span>

                    </div>


                    @if($galleryItem->after_image)

                        <div class="mt-3 overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-900">

                            <img
                                src="{{ Storage::url($galleryItem->after_image) }}"
                                alt="{{ ($galleryItem->alt_text ?: $galleryItem->title ?: 'نمونه‌کار') . ' - بعد' }}"
                                class="aspect-[4/3] w-full object-cover"
                            >

                        </div>

                    @else

                        <div class="mt-3 flex aspect-[4/3] items-center justify-center rounded-3xl border border-dashed border-zinc-700 bg-zinc-900/50">

                            <x-lucide-image-off class="h-8 w-8 text-zinc-700" />

                        </div>

                    @endif


                    <input
                        id="after_image"
                        type="file"
                        name="after_image"
                        accept="image/jpeg,image/png,image/webp"
                        class="mt-3 block w-full text-sm text-zinc-500 file:mr-4 file:rounded-xl file:border-0 file:bg-orange-500/10 file:px-4 file:py-2.5 file:text-xs file:font-bold file:text-orange-400 hover:file:bg-orange-500/20"
                    >


                    <p class="mt-2 text-[11px] text-zinc-600">
                        اختیاری — فقط در صورت نیاز به تغییر تصویر انتخاب کنید.
                    </p>


                    @error('after_image')

                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>

                    @enderror

                </div>

            </div>

        </section>


        {{-- =====================================================
            Information
        ====================================================== --}}

        <section class="overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-950">

            <div class="border-b border-zinc-800 bg-zinc-900/40 p-5 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-500/10">
                        <x-lucide-file-text class="h-5 w-5 text-blue-400" />
                    </div>

                    <div>

                        <h2 class="font-black text-white">
                            اطلاعات نمونه‌کار
                        </h2>

                        <p class="mt-1 text-xs text-zinc-600">
                            عنوان و محتوای نمونه‌کار
                        </p>

                    </div>

                </div>

            </div>


            <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">

                {{-- Title --}}

                <div class="sm:col-span-2">

                    <label
                        for="title"
                        class="text-sm font-bold text-zinc-300"
                    >
                        عنوان
                    </label>

                    <input
                        id="title"
                        type="text"
                        name="title"
                        value="{{ old('title', $galleryItem->title) }}"
                        maxlength="255"
                        placeholder="مثلاً Fade + Textured Crop"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('title')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Description --}}

                <div class="sm:col-span-2">

                    <label
                        for="description"
                        class="text-sm font-bold text-zinc-300"
                    >
                        توضیحات
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        maxlength="2000"
                        class="mt-2 w-full resize-none rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm leading-7 text-white outline-none transition focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >{{ old('description', $galleryItem->description) }}</textarea>

                    @error('description')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Alt --}}

                <div class="sm:col-span-2">

                    <label
                        for="alt_text"
                        class="text-sm font-bold text-zinc-300"
                    >
                        متن جایگزین
                    </label>

                    <input
                        id="alt_text"
                        type="text"
                        name="alt_text"
                        value="{{ old('alt_text', $galleryItem->alt_text) }}"
                        maxlength="255"
                        placeholder="مثلاً نمونه اصلاح قبل و بعد"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('alt_text')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Sort --}}

                <div>

                    <label
                        for="sort_order"
                        class="text-sm font-bold text-zinc-300"
                    >
                        ترتیب نمایش
                    </label>

                    <input
                        id="sort_order"
                        type="number"
                        name="sort_order"
                        value="{{ old('sort_order', $galleryItem->sort_order) }}"
                        min="0"
                        inputmode="numeric"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('sort_order')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Active --}}

                <div>

                    <p class="text-sm font-bold text-zinc-300">
                        وضعیت نمایش
                    </p>

                    <label class="mt-2 flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-zinc-800 bg-zinc-900/50 p-4">

                        <div>

                            <p class="text-xs font-bold text-zinc-300">
                                نمایش در سایت
                            </p>

                            <p class="mt-1 text-[10px] text-zinc-600">
                                این نمونه‌کار برای مشتری نمایش داده شود.
                            </p>

                        </div>


                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            @checked(old('is_active', $galleryItem->is_active))
                        class="h-5 w-5 rounded border-zinc-700 bg-zinc-900 text-orange-500 focus:ring-orange-500"
                        >

                    </label>

                </div>

            </div>

        </section>


        {{-- =====================================================
            Actions
        ====================================================== --}}

        <div
            class="
                flex
                flex-col
                gap-3
                rounded-3xl
                border
                border-zinc-800
                bg-zinc-950
                p-5
                sm:flex-row
                sm:items-center
                sm:justify-between
                sm:p-6
            "
        >

            <div>

                <p class="text-sm font-black text-white">
                    ذخیره تغییرات
                </p>

                <p class="mt-1 text-xs text-zinc-600">
                    تغییرات نمونه‌کار بعد از ذخیره اعمال می‌شوند.
                </p>

            </div>


            <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">

                <a
                    href="{{ route('gallery.index') }}"
                    class="inline-flex w-full items-center justify-center rounded-xl border border-zinc-800 px-6 py-3.5 text-sm font-bold text-zinc-400 transition hover:border-zinc-700 hover:text-white sm:w-auto"
                >
                    انصراف
                </a>


                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-orange-500 px-7 py-3.5 text-sm font-black text-black shadow-lg shadow-orange-500/10 transition hover:bg-orange-400 active:scale-[.99] sm:w-auto"
                >

                    <x-lucide-save class="h-5 w-5" />

                    ذخیره تغییرات

                </button>

            </div>

        </div>

    </form>

</x-layouts.dashboard>
