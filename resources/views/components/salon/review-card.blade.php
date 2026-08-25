{{-- resources/views/components/salon/review-card.blade.php --}}

@props([
'review',
])

@php
    $customerName = $review->user?->full_name ?? 'مشتری';
    $initial = mb_substr($customerName, 0, 1);
    $rating = (int) ($review->rating ?? 0);
@endphp

<article
    class="
        rounded-[28px]
        border border-border
        bg-surface
        p-6
        transition duration-300
        hover:border-primary/40
    "
>

    <div class="flex items-start gap-4">

        {{-- Avatar --}}
        <div
            class="
                flex h-14 w-14 shrink-0
                items-center justify-center
                rounded-full
                bg-primary
                text-lg font-black
                text-white
            "
        >
            {{ $initial }}
        </div>


        <div class="min-w-0 flex-1">

            {{-- Header --}}
            <div
                class="
                    flex flex-col gap-3
                    sm:flex-row
                    sm:items-start
                    sm:justify-between
                "
            >

                <div>

                    <h3 class="font-black text-text">
                        {{ $customerName }}
                    </h3>


                    {{-- Rating --}}
                    <div
                        class="mt-2 flex gap-0.5 text-yellow-400"
                        aria-label="امتیاز {{ $rating }} از 5"
                    >

                        @for($i = 1; $i <= 5; $i++)

                            <span
                                class="{{ $i <= $rating ? 'opacity-100' : 'opacity-25' }}"
                            >
                                ★
                            </span>

                        @endfor

                    </div>

                </div>


                {{-- Date --}}
                <span class="text-sm text-muted">
                    {{ $review->created_at?->diffForHumans() ?? 'به‌تازگی' }}
                </span>

            </div>


            {{-- Comment --}}
            <p class="mt-5 leading-8 text-muted">
                {{ $review->comment }}
            </p>

        </div>

    </div>

</article>
