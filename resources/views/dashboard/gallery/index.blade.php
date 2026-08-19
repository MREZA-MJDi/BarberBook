<x-layouts.dashboard>

    {{-- Page Header --}}
    <div class="mb-8 flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-black text-white">
                گالری
            </h1>

            <p class="mt-2 text-zinc-400">
                مدیریت تصاویر نمونه‌کار و گالری آرایشگاه
            </p>
        </div>

        <a
            href="{{ route('gallery.create') }}"
            class="inline-flex items-center rounded-xl bg-orange-500 px-5 py-3 text-sm font-bold text-black transition hover:bg-orange-400"
        >
            <x-lucide-plus class="ml-2 h-5 w-5" />
            افزودن عکس
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="mb-6 rounded-xl border border-green-500/20 bg-green-500/10 px-4 py-3 text-sm font-medium text-green-400">
            {{ session('success') }}
        </div>

    @endif


    {{-- Gallery --}}
    <section>

        @forelse($galleryItems as $item)

            {{-- Gallery cards --}}

        @empty

            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-10 text-center">

                <x-lucide-images class="mx-auto h-12 w-12 text-zinc-600" />

                <h2 class="mt-4 text-lg font-black text-white">
                    هنوز تصویری در گالری وجود ندارد
                </h2>

                <p class="mt-2 text-sm text-zinc-500">
                    اولین عکس نمونه‌کارت را اضافه کن.
                </p>

                <a
                    href="{{ route('gallery.create') }}"
                    class="mt-5 inline-flex rounded-xl bg-orange-500 px-5 py-3 text-sm font-bold text-black"
                >
                    افزودن اولین عکس
                </a>

            </div>

        @endforelse

    </section>

</x-layouts.dashboard>
