<nav
    x-data="{ isOpen: false }"
    class="sticky top-0 z-50 border-b border-zinc-800 bg-zinc-950/80 backdrop-blur-lg">

    <div class="container mx-auto flex h-20 items-center justify-between px-6">

        {{-- Logo --}}
        <x-ui.logo />

        {{-- Desktop Menu --}}
        <div class="hidden items-center gap-8 lg:flex">

            <a href="#"
               class="text-sm font-medium text-zinc-300 transition hover:text-white">
                خانه
            </a>

            <a href="#"
               class="text-sm font-medium text-zinc-300 transition hover:text-white">
                آرایشگاه‌ها
            </a>

            <a href="#"
               class="text-sm font-medium text-zinc-300 transition hover:text-white">
                خدمات
            </a>

            <a href="#"
               class="text-sm font-medium text-zinc-300 transition hover:text-white">
                درباره ما
            </a>

            <a href="#"
               class="text-sm font-medium text-zinc-300 transition hover:text-white">
                تماس با ما
            </a>

        </div>

        {{-- Desktop Buttons --}}
        <div class="hidden items-center gap-3 lg:flex">

            <a href="#"
               class="rounded-xl border border-zinc-700 px-5 py-2 text-sm font-medium text-zinc-200 transition hover:border-zinc-500 hover:bg-zinc-900">
                ورود
            </a>

            <a href="#"
               class="rounded-xl bg-white px-5 py-2 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-200">
                ثبت آرایشگاه
            </a>

        </div>

        {{-- Mobile Button --}}
        <button
            @click="isOpen=!isOpen"
            class="text-white lg:hidden">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-7 w-7"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"/>

            </svg>

        </button>

    </div>

    {{-- Mobile Menu --}}
    <div
        x-show="isOpen"
        x-transition
        @click.away="isOpen=false"
        class="border-t border-zinc-800 bg-zinc-950 lg:hidden">

        <div class="space-y-1 px-6 py-6">

            <a href="#" class="block rounded-lg px-4 py-3 hover:bg-zinc-900">
                خانه
            </a>

            <a href="#" class="block rounded-lg px-4 py-3 hover:bg-zinc-900">
                آرایشگاه‌ها
            </a>

            <a href="#" class="block rounded-lg px-4 py-3 hover:bg-zinc-900">
                خدمات
            </a>

            <a href="#" class="block rounded-lg px-4 py-3 hover:bg-zinc-900">
                درباره ما
            </a>

            <a href="#" class="block rounded-lg px-4 py-3 hover:bg-zinc-900">
                تماس با ما
            </a>

            <hr class="my-4 border-zinc-800">

            <a href="#"
               class="block rounded-lg border border-zinc-700 px-4 py-3 text-center">
                ورود
            </a>

            <a href="#"
               class="mt-3 block rounded-lg bg-white px-4 py-3 text-center font-semibold text-zinc-900">
                ثبت آرایشگاه
            </a>

        </div>

    </div>

</nav>
