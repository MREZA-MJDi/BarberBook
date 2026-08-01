<div class="rounded-[30px] border border-border bg-surface p-6 lg:p-8">

    {{-- Header --}}
    <div class="mb-8 flex items-center justify-between">

        <button
            class="flex h-11 w-11 items-center justify-center rounded-2xl bg-background text-text transition hover:bg-primary hover:text-white">

            →

        </button>

        <div class="text-center">

            <p class="text-sm text-muted">

                انتخاب تاریخ

            </p>

            <h3 class="mt-1 text-xl font-black text-text">

                مرداد ۱۴۰۵

            </h3>

        </div>

        <button
            class="flex h-11 w-11 items-center justify-center rounded-2xl bg-background text-text transition hover:bg-primary hover:text-white">

            ←

        </button>

    </div>

    {{-- Week Days --}}
    <div class="mb-4 grid grid-cols-7 text-center">

        @foreach (['ش','ی','د','س','چ','پ','ج'] as $day)

            <span class="py-2 text-sm font-bold text-muted">

                {{ $day }}

            </span>

        @endforeach

    </div>

    {{-- Days --}}
    <div class="grid grid-cols-7 gap-3">

        @for ($i = 1; $i <= 31; $i++)

            @php
                $busy = in_array($i,[7,13,18,25]);
                $limited = in_array($i,[10,20]);
                $active = $i == 15;
            @endphp

            <button
                class="relative flex aspect-square items-center justify-center rounded-2xl border text-sm font-bold transition-all duration-200

                {{ $active
                    ? 'border-primary bg-primary text-white shadow-lg shadow-primary/20'
                    : ($busy
                        ? 'border-red-200 bg-red-50 text-red-500'
                        : ($limited
                            ? 'border-amber-200 bg-amber-50 text-amber-600'
                            : 'border-border bg-background text-text hover:-translate-y-1 hover:border-primary')) }}">

                {{ $i }}

                @if(!$active)

                    <span
                        class="absolute bottom-2 h-2 w-2 rounded-full

                        {{ $busy
                            ? 'bg-red-500'
                            : ($limited
                                ? 'bg-amber-500'
                                : 'bg-primary') }}">

                    </span>

                @endif

            </button>

        @endfor

    </div>

    {{-- Legend --}}
    <div class="mt-8 flex flex-wrap justify-center gap-6 border-t border-border pt-6 text-sm">

        <div class="flex items-center gap-2">

            <span class="h-3 w-3 rounded-full bg-primary"></span>

            <span class="text-muted">

                آزاد

            </span>

        </div>

        <div class="flex items-center gap-2">

            <span class="h-3 w-3 rounded-full bg-amber-500"></span>

            <span class="text-muted">

                محدود

            </span>

        </div>

        <div class="flex items-center gap-2">

            <span class="h-3 w-3 rounded-full bg-red-500"></span>

            <span class="text-muted">

                تکمیل

            </span>

        </div>

    </div>

</div>
