@props([
'booking' => null,
'review' => null,
])

@php
    $currentRating = old(
        'rating',
        $review?->rating ?? 0
    );

    $currentComment = old(
        'comment',
        $review?->comment ?? ''
    );

    $formAction = $review?->id
        ? route('customer.reviews.update', $review)
        : route('customer.reviews.store');
@endphp

<form
    method="POST"
    action="{{ $formAction }}"
    {{ $attributes->merge([
        'class' => 'rounded-2xl border border-zinc-800 bg-zinc-900 p-5 sm:p-6',
    ]) }}
>

    @csrf

    @if($review?->id)

        @method('PUT')

    @endif


    {{-- Header --}}

    <div class="mb-6">

        <div class="flex items-center gap-3">

            <div
                class="flex h-11 w-11 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10 text-orange-500"
            >

                <x-lucide-message-square-heart class="h-5 w-5" />

            </div>

            <div>

                <h2 class="text-base font-black text-white sm:text-lg">

                    {{ $review?->id ? 'ویرایش نظر' : 'ثبت نظر' }}

                </h2>

                <p class="mt-1 text-xs text-zinc-500">

                    تجربه خود را درباره خدمات آرایشگاه با ما به اشتراک بگذارید.

                </p>

            </div>

        </div>

    </div>


    {{-- Booking --}}

    @if($booking?->id)

        <input
            type="hidden"
            name="booking_id"
            value="{{ $booking->id }}"
        >

        <div
            class="mb-6 rounded-xl border border-zinc-800 bg-zinc-950/60 p-4"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-zinc-900 text-orange-500"
                >

                    <x-lucide-calendar-check class="h-5 w-5" />

                </div>

                <div class="min-w-0">

                    <p class="text-xs text-zinc-500">
                        نوبت
                    </p>

                    <p class="mt-1 truncate text-sm font-bold text-white">

                        {{ $booking->service?->name ?? 'خدمت' }}

                    </p>

                    @if($booking->salon?->name)

                        <p class="mt-1 truncate text-xs text-zinc-600">

                            {{ $booking->salon->name }}

                        </p>

                    @endif

                </div>

            </div>

        </div>

    @endif


    {{-- Rating --}}

    <div>

        <label class="block text-sm font-bold text-zinc-300">

            امتیاز شما

        </label>

        <p class="mt-1 text-xs text-zinc-600">

            از ۱ تا ۵ ستاره انتخاب کنید.

        </p>


        <div
            class="mt-4 flex items-center gap-2"
            x-data="{ rating: {{ (int) $currentRating }} }"
        >

            <input
                type="hidden"
                name="rating"
                x-model="rating"
            >

            @for($i = 1; $i <= 5; $i++)

                <button
                    type="button"
                    @click="rating = {{ $i }}"
                    class="rounded-xl p-1 transition hover:scale-110"
                    aria-label="امتیاز {{ $i }} از ۵"
                >

                    <x-lucide-star
                        class="h-7 w-7 transition sm:h-8 sm:w-8"
                        x-bind:class="rating >= {{ $i }}
                            ? 'fill-yellow-400 text-yellow-400'
                            : 'text-zinc-700 hover:text-yellow-500'"
                    />

                </button>

            @endfor

        </div>


        @error('rating')

        <p class="mt-2 text-xs font-medium text-red-400">

            {{ $message }}

        </p>

        @enderror

    </div>


    {{-- Comment --}}

    <div class="mt-6">

        <label
            for="review-comment"
            class="block text-sm font-bold text-zinc-300"
        >

            متن نظر

        </label>


        <textarea
            id="review-comment"
            name="comment"
            rows="5"
            maxlength="1000"
            placeholder="تجربه‌تان از این آرایشگاه و خدمات آن را بنویسید..."
            class="mt-2 w-full resize-none rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3 text-sm leading-7 text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
        >{{ $currentComment }}</textarea>


        @error('comment')

        <p class="mt-2 text-xs font-medium text-red-400">

            {{ $message }}

        </p>

        @enderror

    </div>


    {{-- Submit --}}

    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

        @if($review?->id)

            <a
                href="{{ route('customer.reviews.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-zinc-800 px-5 py-3 text-sm font-bold text-zinc-400 transition hover:bg-zinc-800 hover:text-white"
            >

                انصراف

            </a>

        @endif


        <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-5 py-3 text-sm font-bold text-black transition hover:bg-orange-400"
        >

            <x-lucide-send class="h-4 w-4" />

            {{ $review?->id ? 'ذخیره تغییرات' : 'ثبت نظر' }}

        </button>

    </div>

</form>
