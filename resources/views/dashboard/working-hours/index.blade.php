<x-layouts.dashboard>

    {{-- =========================================================
        Time Options
    ========================================================== --}}

    @php
        $timeOptions = [];

        for ($hour = 0; $hour < 24; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 15) {
                $timeOptions[] = sprintf('%02d:%02d', $hour, $minute);
            }
        }

        $formatTime = function ($time) {
            if (!$time) {
                return null;
            }

            return substr((string) $time, 0, 5);
        };
    @endphp


    {{-- =========================================================
        Page Header
    ========================================================== --}}

    <div class="mb-8">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

            <div>

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-11 w-11 items-center justify-center
                               rounded-2xl border border-primary/20
                               bg-primary/10 text-primary"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0Z"
                            />
                        </svg>
                    </div>

                    <div>

                        <p class="text-sm font-bold text-primary">
                            برنامه کاری سالن
                        </p>

                        <h1 class="mt-1 text-2xl font-black text-text sm:text-3xl">
                            ساعت کاری هفتگی
                        </h1>

                    </div>

                </div>

                <p class="mt-3 max-w-2xl text-sm leading-7 text-text-muted">
                    ساعت کاری معمول سالن را برای هر روز هفته مشخص کن.
                    این برنامه به‌صورت خودکار در هفته‌های آینده تکرار می‌شود.
                </p>

            </div>

        </div>

    </div>


    {{-- =========================================================
        How It Works
    ========================================================== --}}

    <div
        class="mb-6 overflow-hidden rounded-3xl border
               border-primary/20 bg-primary/5"
    >

        <div class="flex items-start gap-4 p-5">

            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center
                       rounded-2xl bg-primary/10 text-primary"
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000-18Z"
                    />
                </svg>
            </div>

            <div>

                <h2 class="text-sm font-black text-text">
                    این برنامه چطور کار می‌کند؟
                </h2>

                <p class="mt-2 text-xs leading-7 text-text-muted">
                    اینجا فقط
                    <span class="font-bold text-text">
                        برنامه عادی هفتگی
                    </span>
                    سالن را مشخص می‌کنی.
                    این برنامه هر هفته به‌صورت خودکار تکرار می‌شود.
                    اگر یک تاریخ خاص تعطیل شد یا ساعت متفاوتی داشت،
                    برنامه هفتگی را تغییر نده و آن تغییر را از
                    <span class="font-bold text-primary">
                        وضعیت روزانه سالن
                    </span>
                    مدیریت کن.
                </p>

            </div>

        </div>

    </div>


    {{-- =========================================================
        Validation Errors
    ========================================================== --}}

    @if ($errors->any())

        <div
            class="mb-6 rounded-2xl border border-red-500/20
                   bg-red-500/5 p-5"
        >

            <div class="flex items-start gap-3">

                <div class="text-red-400">
                    !
                </div>

                <div class="min-w-0">

                    <p class="text-sm font-black text-red-400">
                        اطلاعات واردشده صحیح نیست.
                    </p>

                    <ul class="mt-2 space-y-1 text-xs leading-6 text-red-300">

                        @foreach ($errors->all() as $error)

                            <li>
                                • {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- =========================================================
        Success Message
    ========================================================== --}}

    @if (session('success'))

        <div
            class="mb-6 rounded-2xl border border-emerald-500/20
                   bg-emerald-500/5 p-5"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-9 w-9 items-center justify-center
                           rounded-xl bg-emerald-500/10 text-emerald-400"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m5 13 4 4L19 7"
                        />
                    </svg>
                </div>

                <p class="text-sm font-bold text-emerald-400">
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif


    {{-- =========================================================
        Weekly Schedule
    ========================================================== --}}

    <form
        action="{{ route('working-hours.update-week') }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        <div class="overflow-hidden rounded-3xl border border-border bg-surface">

            {{-- Header --}}

            <div
                class="flex flex-col gap-3 border-b border-border
                       p-6 sm:flex-row sm:items-center sm:justify-between"
            >

                <div>

                    <h2 class="text-base font-black text-text">
                        برنامه هفتگی
                    </h2>

                    <p class="mt-1 text-xs text-text-muted">
                        ساعت کاری عادی سالن را برای هر روز مشخص کن.
                    </p>

                </div>

                <div
                    class="inline-flex w-fit items-center gap-2 rounded-xl
                           border border-border bg-background px-3 py-2"
                >

                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>

                    <span class="text-xs font-bold text-text-muted">
                        برنامه تکرارشونده
                    </span>

                </div>

            </div>


            {{-- Days --}}

            <div class="divide-y divide-border">

                @foreach ($days as $day => $dayName)

                    @php
                        $workingHour = $week[$day] ?? null;

                        $isClosed = old(
                            "days.$day.is_closed",
                            $workingHour?->is_closed ?? false
                        );

                        $startTime = $formatTime(
                            old(
                                "days.$day.start_time",
                                $workingHour?->start_time
                            )
                        );

                        $endTime = $formatTime(
                            old(
                                "days.$day.end_time",
                                $workingHour?->end_time
                            )
                        );

                        $breakStart = $formatTime(
                            old(
                                "days.$day.break_start",
                                $workingHour?->break_start
                            )
                        );

                        $breakEnd = $formatTime(
                            old(
                                "days.$day.break_end",
                                $workingHour?->break_end
                            )
                        );
                    @endphp


                    <div
                        class="working-hour-row p-5 sm:p-6"
                        data-day-row="{{ $day }}"
                    >

                        <div
                            class="flex flex-col gap-6
                                   xl:flex-row xl:items-start
                                   xl:justify-between"
                        >

                            {{-- Day --}}

                            <div class="flex items-center gap-4 xl:w-56">

                                <div
                                    class="flex h-11 w-11 shrink-0 items-center
                                           justify-center rounded-2xl
                                           bg-primary/10 text-sm font-black
                                           text-primary"
                                >
                                    {{ $day + 1 }}
                                </div>

                                <div>

                                    <h3 class="text-sm font-black text-text">
                                        {{ $dayName }}
                                    </h3>

                                    <p class="mt-1 text-[11px] text-text-muted">
                                        برنامه تکرارشونده
                                    </p>

                                </div>

                            </div>


                            {{-- Schedule --}}

                            <div class="flex-1">

                                <div
                                    class="grid grid-cols-1 gap-4
                                           md:grid-cols-2 xl:grid-cols-4"
                                >

                                    {{-- Start --}}

                                    <div>

                                        <label
                                            class="mb-2 block text-xs font-bold
                                                   text-text-muted"
                                        >
                                            شروع کار
                                        </label>

                                        <select
                                            name="days[{{ $day }}][start_time]"
                                            data-time-input
                                            class="w-full rounded-2xl border border-border
                                                   bg-background px-4 py-3 text-sm
                                                   font-bold text-text outline-none
                                                   transition focus:border-primary
                                                   focus:ring-2 focus:ring-primary/10
                                                   disabled:cursor-not-allowed
                                                   disabled:opacity-40"
                                        >

                                            <option value="">
                                                انتخاب ساعت
                                            </option>

                                            @foreach ($timeOptions as $time)

                                                <option
                                                    value="{{ $time }}"
                                                    @selected($startTime === $time)
                                                >
                                                    {{ $time }}
                                                </option>

                                            @endforeach

                                        </select>

                                        @error("days.$day.start_time")
                                        <p class="mt-1 text-[10px] font-bold text-red-400">
                                            {{ $message }}
                                        </p>
                                        @enderror

                                    </div>


                                    {{-- End --}}

                                    <div>

                                        <label
                                            class="mb-2 block text-xs font-bold
                                                   text-text-muted"
                                        >
                                            پایان کار
                                        </label>

                                        <select
                                            name="days[{{ $day }}][end_time]"
                                            data-time-input
                                            class="w-full rounded-2xl border border-border
                                                   bg-background px-4 py-3 text-sm
                                                   font-bold text-text outline-none
                                                   transition focus:border-primary
                                                   focus:ring-2 focus:ring-primary/10
                                                   disabled:cursor-not-allowed
                                                   disabled:opacity-40"
                                        >

                                            <option value="">
                                                انتخاب ساعت
                                            </option>

                                            @foreach ($timeOptions as $time)

                                                <option
                                                    value="{{ $time }}"
                                                    @selected($endTime === $time)
                                                >
                                                    {{ $time }}
                                                </option>

                                            @endforeach

                                        </select>

                                        @error("days.$day.end_time")
                                        <p class="mt-1 text-[10px] font-bold text-red-400">
                                            {{ $message }}
                                        </p>
                                        @enderror

                                    </div>


                                    {{-- Break Start --}}

                                    <div>

                                        <label
                                            class="mb-2 block text-xs font-bold
                                                   text-text-muted"
                                        >
                                            شروع استراحت
                                        </label>

                                        <select
                                            name="days[{{ $day }}][break_start]"
                                            data-time-input
                                            class="w-full rounded-2xl border border-border
                                                   bg-background px-4 py-3 text-sm
                                                   font-bold text-text outline-none
                                                   transition focus:border-primary
                                                   focus:ring-2 focus:ring-primary/10
                                                   disabled:cursor-not-allowed
                                                   disabled:opacity-40"
                                        >

                                            <option value="">
                                                بدون استراحت
                                            </option>

                                            @foreach ($timeOptions as $time)

                                                <option
                                                    value="{{ $time }}"
                                                    @selected($breakStart === $time)
                                                >
                                                    {{ $time }}
                                                </option>

                                            @endforeach

                                        </select>

                                        @error("days.$day.break_start")
                                        <p class="mt-1 text-[10px] font-bold text-red-400">
                                            {{ $message }}
                                        </p>
                                        @enderror

                                    </div>


                                    {{-- Break End --}}

                                    <div>

                                        <label
                                            class="mb-2 block text-xs font-bold
                                                   text-text-muted"
                                        >
                                            پایان استراحت
                                        </label>

                                        <select
                                            name="days[{{ $day }}][break_end]"
                                            data-time-input
                                            class="w-full rounded-2xl border border-border
                                                   bg-background px-4 py-3 text-sm
                                                   font-bold text-text outline-none
                                                   transition focus:border-primary
                                                   focus:ring-2 focus:ring-primary/10
                                                   disabled:cursor-not-allowed
                                                   disabled:opacity-40"
                                        >

                                            <option value="">
                                                بدون استراحت
                                            </option>

                                            @foreach ($timeOptions as $time)

                                                <option
                                                    value="{{ $time }}"
                                                    @selected($breakEnd === $time)
                                                >
                                                    {{ $time }}
                                                </option>

                                            @endforeach

                                        </select>

                                        @error("days.$day.break_end")
                                        <p class="mt-1 text-[10px] font-bold text-red-400">
                                            {{ $message }}
                                        </p>
                                        @enderror

                                    </div>

                                </div>


                                {{-- Day Status --}}

                                <div
                                    class="mt-5 flex flex-wrap items-center
                                           justify-between gap-4"
                                >

                                    <div>

                                        <p class="text-xs font-black text-text">
                                            وضعیت این روز
                                        </p>

                                        <p class="mt-1 text-[11px] text-text-muted">
                                            روز تعطیل است یا طبق برنامه باز است؟
                                        </p>

                                    </div>


                                    <div class="flex items-center gap-3">

                                        <span
                                            data-status-label
                                            class="text-xs font-bold
                                                {{ $isClosed
                                                    ? 'text-red-400'
                                                    : 'text-emerald-400' }}"
                                        >
                                            {{ $isClosed ? 'تعطیل' : 'باز' }}
                                        </span>


                                        <label
                                            class="relative inline-flex cursor-pointer items-center"
                                        >

                                            <input
                                                type="hidden"
                                                name="days[{{ $day }}][is_closed]"
                                                value="0"
                                            >

                                            <input
                                                type="checkbox"
                                                name="days[{{ $day }}][is_closed]"
                                                value="1"
                                                data-closed-toggle
                                                class="peer sr-only"
                                                @checked($isClosed)
                                            >

                                            <div
                                                class="h-7 w-12 rounded-full
                                                       bg-border transition
                                                       peer-checked:bg-primary
                                                       peer-focus:outline-none
                                                       peer-focus:ring-4
                                                       peer-focus:ring-primary/10
                                                       after:absolute after:right-[4px]
                                                       after:top-[4px] after:h-5
                                                       after:w-5 after:rounded-full
                                                       after:bg-white after:transition-all
                                                       peer-checked:after:-translate-x-5"
                                            ></div>

                                        </label>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- Footer --}}

            <div
                class="flex flex-col gap-4 border-t border-border
                       bg-background/30 p-6
                       sm:flex-row sm:items-center
                       sm:justify-between"
            >

                <div>

                    <p class="text-xs font-bold text-text-muted">
                        تغییراتت را یک‌جا ذخیره کن
                    </p>

                    <p class="mt-1 text-[11px] text-text-muted">
                        این برنامه برای هفته‌های آینده هم به‌صورت خودکار استفاده می‌شود.
                    </p>

                </div>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2
                           rounded-2xl bg-primary px-6 py-3
                           text-sm font-black text-background
                           transition hover:-translate-y-0.5
                           hover:shadow-lg hover:shadow-primary/10"
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    ذخیره برنامه هفتگی

                </button>

            </div>

        </div>

    </form>


    {{-- =========================================================
        Information Cards
    ========================================================== --}}

    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">

        {{-- Daily Exception --}}

        <div
            class="rounded-3xl border border-border bg-surface p-6"
        >

            <div class="flex items-start gap-4">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center
                           rounded-2xl bg-primary/10 text-primary"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7H5a2 2 0 00-2 2v12a2 2 0 002 2Z"
                        />
                    </svg>
                </div>

                <div>

                    <h3 class="text-sm font-black text-text">
                        تغییر برای یک تاریخ خاص
                    </h3>

                    <p class="mt-2 text-xs leading-6 text-text-muted">
                        اگر فقط یک تاریخ خاص تعطیل هستی یا ساعت متفاوتی داری،
                        برنامه هفتگی را تغییر نده.
                        این تغییرات باید از بخش وضعیت روزانه سالن مدیریت شوند.
                    </p>

                </div>

            </div>

        </div>


        {{-- Booking Logic --}}

        <div
            class="rounded-3xl border border-border bg-surface p-6"
        >

            <div class="flex items-start gap-4">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center
                           rounded-2xl bg-primary/10 text-primary"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0Z"
                        />
                    </svg>
                </div>

                <div>

                    <h3 class="text-sm font-black text-text">
                        ساعت‌های رزرو مشتری
                    </h3>

                    <p class="mt-2 text-xs leading-6 text-text-muted">
                        زمان‌های قابل رزرو مشتری بر اساس ساعت کاری،
                        زمان استراحت و رزروهای ثبت‌شده محاسبه می‌شوند.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        Closed-Day Toggle
    ========================================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const rows = document.querySelectorAll('[data-day-row]');

            rows.forEach((row) => {

                const toggle = row.querySelector('[data-closed-toggle]');
                const inputs = row.querySelectorAll('[data-time-input]');
                const label = row.querySelector('[data-status-label]');

                if (!toggle) {
                    return;
                }

                const updateState = () => {

                    const isClosed = toggle.checked;

                    inputs.forEach((input) => {
                        input.disabled = isClosed;
                    });

                    if (label) {

                        label.textContent = isClosed
                            ? 'تعطیل'
                            : 'باز';

                        label.classList.toggle(
                            'text-red-400',
                            isClosed
                        );

                        label.classList.toggle(
                            'text-emerald-400',
                            !isClosed
                        );
                    }
                };

                toggle.addEventListener(
                    'change',
                    updateState
                );

                updateState();
            });

        });
    </script>

</x-layouts.dashboard>
