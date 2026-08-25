{{-- resources/views/components/customer/review-form.blade.php --}}

@props([
'booking',
'action' => null,
'method' => 'POST',
])

@php
    $service = $booking->service;
    $salon = $booking->salon;

    $oldRating = old('rating', 0);

    $toPersianDigits = function ($value) {
        return strtr((string) $value, [
            '0' => '۰',
            '1' => '۱',
            '2' => '۲',
            '3' => '۳',
            '4' => '۴',
            '5' => '۵',
            '6' => '۶',
            '7' => '۷',
            '8' => '۸',
            '9' => '۹',
        ]);
    };
@endphp


<form
    method="{{ strtoupper($method) }}"
    @if($action)
    action="{{ $action }}"
    @endif
    {{ $attributes->merge([
        'class' => '
            overflow-hidden
            rounded-[28px]
            border
            border-border
            bg-surface
        ',
    ]) }}
>

    @if(strtoupper($method) !== 'GET')

        @csrf

    @endif


    {{-- =========================================================
        Header
    ========================================================== --}}

    <div class="border-b border-border p-5 sm:p-6">

        <div class="flex items-start gap-4">

            <div
                class="
                    flex
                    h-12
                    w-12
                    shrink-0
                    items-center
                    justify-center
                    rounded-2xl
                    bg-primary/10
                    text-xl
                    text-primary
                "
            >
                ★
            </div>

            <div class="min-w-0">

                <span class="text-xs font-black text-primary">
                    ثبت تجربه
                </span>

                <h2
                    class="
                        mt-1.5
                        text-xl
                        font-black
                        text-text
                    "
                >
                    درباره این نوبت نظرت چیه؟
                </h2>

                <p
                    class="
                        mt-2
                        text-sm
                        leading-7
                        text-muted
                    "
                >
                    تجربه واقعی خودت از خدمتی که دریافت کردی را با ما به اشتراک بگذار.
                </p>

            </div>

        </div>

    </div>


    {{-- =========================================================
        Booking Context
    ========================================================== --}}

    <div class="p-5 sm:p-6">

        <div
            class="
                rounded-2xl
                border
                border-border
                bg-background
                p-4
            "
        >

            <div
                class="
                    flex
                    flex-col
                    gap-4
                    sm:flex-row
                    sm:items-center
                    sm:justify-between
                "
            >

                <div class="min-w-0">

                    <p class="text-xs font-bold text-muted">
                        نوبت ثبت‌شده
                    </p>

                    <h3
                        class="
                            mt-1
                            truncate
                            text-sm
                            font-black
                            text-text
                        "
                    >
                        {{ $salon?->name ?? 'آرایشگاه' }}
                    </h3>

                    @if($service)

                        <p
                            class="
                                mt-1
                                truncate
                                text-xs
                                font-bold
                                text-muted
                            "
                        >
                            {{ $service->name }}
                        </p>

                    @endif

                </div>


                <div
                    class="
                        shrink-0
                        rounded-xl
                        bg-primary/10
                        px-3
                        py-2
                        text-xs
                        font-black
                        text-primary
                    "
                >
                    {{ $booking->reference_code }}
                </div>

            </div>

        </div>


        {{-- =====================================================
            Rating
        ====================================================== --}}

        <div class="mt-7">

            <label
                class="
                    block
                    text-sm
                    font-black
                    text-text
                "
            >
                امتیاز شما
            </label>

            <p class="mt-2 text-xs leading-6 text-muted">
                کیفیت خدمتی که دریافت کردید را از ۱ تا ۵ امتیاز دهید.
            </p>


            <div
                class="
                    mt-4
                    grid
                    grid-cols-5
                    gap-2
                    sm:max-w-md
                "
            >

                @for($rating = 1; $rating <= 5; $rating++)

                    <label
                        class="
                            cursor-pointer
                            rounded-2xl
                            border
                            border-border
                            bg-background
                            px-3
                            py-4
                            text-center
                            transition
                            hover:border-primary/50
                            hover:bg-primary/5
                        "
                    >

                        <input
                            type="radio"
                            name="rating"
                            value="{{ $rating }}"
                            class="sr-only"
                            @checked((int) $oldRating === $rating)
                        >

                        <span
                            class="
                                block
                                text-2xl
                                leading-none
                                {{ (int) $oldRating >= $rating
                                    ? 'text-primary'
                                    : 'text-text/20'
                                }}
                                "
                        >
                            ★
                        </span>

                        <span
                            class="
                                mt-2
                                block
                                text-[11px]
                                font-black
                                text-muted
                            "
                        >
                            {{ $toPersianDigits($rating) }}
                        </span>

                    </label>

                @endfor

            </div>

            @error('rating')

            <p class="mt-2 text-xs font-bold text-red-400">
                {{ $message }}
            </p>

            @enderror

        </div>


        {{-- =====================================================
            Comment
        ====================================================== --}}

        <div class="mt-7">

            <label
                for="review_comment"
                class="
                    text-sm
                    font-black
                    text-text
                "
            >
                تجربه شما
            </label>

            <p class="mt-2 text-xs leading-6 text-muted">
                درباره کیفیت خدمت، برخورد یا تجربه‌ات بنویس.
            </p>

            <textarea
                id="review_comment"
                name="comment"
                rows="6"
                maxlength="2000"
                required
                placeholder="مثلاً از کیفیت کوتاهی و برخورد آرایشگر خیلی راضی بودم..."
                class="
                    mt-3
                    w-full
                    resize-none
                    rounded-2xl
                    border
                    border-border
                    bg-background
                    p-4
                    text-sm
                    leading-8
                    text-text
                    outline-none
                    transition
                    placeholder:text-muted/60
                    focus:border-primary
                    focus:ring-2
                    focus:ring-primary/10
                "
            >{{ old('comment') }}</textarea>

            @error('comment')

            <p class="mt-2 text-xs font-bold text-red-400">
                {{ $message }}
            </p>

            @enderror

        </div>


        {{-- =====================================================
            Notice
        ====================================================== --}}

        <div
            class="
                mt-6
                rounded-2xl
                border
                border-primary/20
                bg-primary/5
                p-4
            "
        >

            <div class="flex items-start gap-3">

                <div class="shrink-0 text-lg">
                    ℹ
                </div>

                <p
                    class="
                        text-xs
                        leading-7
                        text-muted
                    "
                >
                    نظر شما پس از بررسی سالن منتشر می‌شود و فقط درباره تجربه واقعی
                    این نوبت نمایش داده خواهد شد.
                </p>

            </div>

        </div>


        {{-- =====================================================
            Submit
        ====================================================== --}}

        <div
            class="
                mt-7
                flex
                flex-col-reverse
                gap-3
                sm:flex-row
                sm:justify-end
            "
        >

            <button
                type="submit"
                class="
                    inline-flex
                    items-center
                    justify-center
                    rounded-2xl
                    bg-primary
                    px-7
                    py-4
                    text-sm
                    font-black
                    text-white
                    shadow-lg
                    shadow-primary/20
                    transition
                    hover:-translate-y-0.5
                    hover:bg-primary-hover
                "
            >
                ثبت نظر
            </button>

        </div>

    </div>

</form>
