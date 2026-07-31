<div
    class="group min-w-[260px] max-w-[260px] snap-start overflow-hidden rounded-[28px] border border-border bg-surface transition-all duration-300 hover:-translate-y-1 hover:border-primary/40">

    {{-- Image --}}
    <div class="relative overflow-hidden">

        <img
            src="{{ asset('images/model1.jpg') }}"
            alt="French Crop"
            class="h-80 w-full object-cover transition duration-500 group-hover:scale-105">

        {{-- Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

        {{-- Badge --}}
        <div
            class="absolute top-4 right-4 rounded-full bg-primary px-3 py-1.5 text-xs font-bold text-white shadow-lg">

            ترند

        </div>

    </div>

    {{-- Body --}}
    <div class="p-5">

        <h3 class="text-xl font-black text-text">

            French Crop

        </h3>

        <p class="mt-2 text-sm leading-7 text-muted">

            فید کوتاه با حجم طبیعی؛ مناسب استایل‌های روزمره و رسمی.

        </p>

        {{-- Action --}}
        <button
            class="mt-6 flex w-full items-center justify-center rounded-2xl bg-primary py-3 font-bold text-white transition hover:bg-primary-hover">

            انتخاب این مدل

        </button>

    </div>

</div>
