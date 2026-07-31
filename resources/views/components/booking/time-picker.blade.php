<div class="rounded-[30px] border border-border bg-surface p-6 lg:p-8">

    <div class="mb-6">

        <h3 class="text-xl font-black text-text">
            انتخاب ساعت
        </h3>

        <p class="mt-2 text-sm text-muted">
            فقط زمان‌های آزاد برای رزرو نمایش داده می‌شوند.
        </p>

    </div>


    <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 lg:grid-cols-5">

        @foreach([
            '09:00',
            '09:30',
            '10:00',
            '10:30',
            '11:00',
            '11:30',
            '14:00',
            '14:30',
            '15:00',
            '16:00',
            '17:30',
            '18:00'
        ] as $time)


            @php

                // موقت برای تست UI
                $busy = in_array($time, [
                    '09:30',
                    '14:30',
                    '17:30'
                ]);

                $active = $time === '15:00';

            @endphp


            <button
                type="button"
                @disabled($busy)

                class="
                rounded-2xl
                border
                py-4
                text-sm
                font-black
                transition-all
                duration-300

                {{ $active

                    ? 'border-primary bg-primary text-white shadow-lg shadow-primary/20 scale-[1.03]'

                    : ($busy

                        ? 'cursor-not-allowed border-border bg-background text-muted opacity-40'

                        : 'border-border bg-background text-text hover:-translate-y-1 hover:border-primary hover:bg-primary/5')

                }}
                    ">

                {{ $time }}

            </button>


        @endforeach

    </div>

</div>
