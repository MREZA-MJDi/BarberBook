<x-layouts.dashboard>

    {{-- Page Header --}}
    <div class="mb-8">

        <h1 class="text-3xl font-black text-white">
            افزودن تصویر
        </h1>

        <p class="mt-2 text-zinc-400">
            یک تصویر جدید به گالری آرایشگاه اضافه کنید.
        </p>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 p-4">

            <ul class="space-y-1 text-sm text-red-400">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Form --}}
    <section class="max-w-3xl">

        <form
            action="{{ route('gallery.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6 rounded-2xl border border-zinc-800 bg-zinc-900 p-6"
        >

            @csrf


            {{-- Image --}}
            <div>

                <label class="mb-2 block text-sm font-bold text-white">
                    تصویر
                </label>

                <input
                    type="file"
                    name="image"
                    accept="image/jpeg,image/png,image/webp"
                    required
                    class="block w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-sm text-zinc-300"
                >

                <p class="mt-2 text-xs text-zinc-500">
                    فرمت‌های مجاز: JPG, PNG, WEBP — حداکثر 5MB
                </p>

            </div>


            {{-- Title --}}
            <div>

                <label class="mb-2 block text-sm font-bold text-white">
                    عنوان
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="مثلاً French Crop"
                    class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-sm text-white placeholder:text-zinc-600 focus:border-orange-500 focus:outline-none"
                >

            </div>


            {{-- Alt Text --}}
            <div>

                <label class="mb-2 block text-sm font-bold text-white">
                    متن جایگزین تصویر
                </label>

                <input
                    type="text"
                    name="alt_text"
                    value="{{ old('alt_text') }}"
                    placeholder="مثلاً نمونه اصلاح French Crop"
                    class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-sm text-white placeholder:text-zinc-600 focus:border-orange-500 focus:outline-none"
                >

            </div>


            {{-- Sort Order --}}
            <div>

                <label class="mb-2 block text-sm font-bold text-white">
                    ترتیب نمایش
                </label>

                <input
                    type="number"
                    name="sort_order"
                    value="{{ old('sort_order', 0) }}"
                    min="0"
                    class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-sm text-white focus:border-orange-500 focus:outline-none"
                >

            </div>


            {{-- Active --}}
            <label class="flex cursor-pointer items-center gap-3">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    {{ old('is_active', true) ? 'checked' : '' }}
                    class="h-4 w-4 rounded border-zinc-700 bg-zinc-950 text-orange-500 focus:ring-orange-500"
                >

                <span class="text-sm font-bold text-zinc-300">
                    نمایش تصویر در سایت
                </span>

            </label>


            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">

                <button
                    type="submit"
                    class="rounded-xl bg-orange-500 px-6 py-3 text-sm font-bold text-black transition hover:bg-orange-400"
                >
                    ذخیره تصویر
                </button>

                <a
                    href="{{ route('gallery.index') }}"
                    class="rounded-xl border border-zinc-700 px-6 py-3 text-sm font-bold text-zinc-300 transition hover:bg-zinc-800 hover:text-white"
                >
                    انصراف
                </a>

            </div>

        </form>

    </section>

</x-layouts.dashboard>
