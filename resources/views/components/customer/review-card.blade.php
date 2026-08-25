@props([
'review',
])

@php
    $rating = (int) ($review?->rating ?? 0);

    $salon = $review?->salon;

    $salonName = $salon?->name ?? 'آرایشگاه';

    $serviceName = $review?->service?->name;

    $comment = $review?->comment ?? $review?->content;

    $createdAt = $review?->created_at;

    $isPublished = (bool) ($review?->is_published ?? false);
@endphp

<article
    {{ $attributes->merge([
        'class' => 'rounded-2xl border border-zinc-800 bg-zinc-900 p-5 transition hover:border-orange-500/20',
    ]) }}
>

    {{-- Header --}}

    <div class="flex items-start justify-between gap-4">

        <div class="flex min-w-0 items-center gap-3">

            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-yellow-500/20 bg-yellow-500/10 text-yellow-400"
            >

                <x-lucide-star class="h-5 w-5" />

            </div>


            <div class="min-w-0">

                <h3 class="truncate text-sm font-black text-white">

                    {{ $salonName }}

                </h3>

                @if($serviceName)

                    <p class="mt-1 truncate text-xs text-zinc-500">

                        {{ $serviceName }}

                    </p>

                @endif

            </div>

        </div>


        {{-- Rating --}}

        <div
            class="flex shrink-0 items-center gap-1 rounded-xl border border-yellow-500/20 bg-yellow-500/10 px-2.5 py-1.5"
        >

            <x-lucide-star
                class="h-3.5 w-3.5 fill-yellow-400 text-yellow-400"
            />

            <span class="text-xs font-black text-yellow-400">

                {{ $rating }}/5

            </span>

        </div>

    </div>


    {{-- Stars --}}

    <div class="mt-4 flex items-center gap-1">

        @for($i = 1; $i <= 5; $i++)

            <x-lucide-star
                class="h-4 w-4 {{ $i <= $rating
                    ? 'fill-yellow-400 text-yellow-400'
                    : 'text-zinc-700' }}"
            />

        @endfor

    </div>


    {{-- Comment --}}

    @if($comment)

        <div
            class="mt-4 rounded-xl border border-zinc-800 bg-zinc-950/50 p-4"
        >

            <p class="text-sm leading-7 text-zinc-400">

                {{ $comment }}

            </p>

        </div>

    @else

        <p class="mt-4 text-sm text-zinc-600">

            متنی برای این نظر ثبت نشده است.

        </p>

    @endif


    {{-- Footer --}}

    <div
        class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-zinc-800 pt-4"
    >

        @if($createdAt)

            <span class="inline-flex items-center gap-1.5 text-[11px] text-zinc-600">

                <x-lucide-clock-3 class="h-3.5 w-3.5" />

                {{ $createdAt->locale('fa')->translatedFormat('j F Y') }}

            </span>

        @endif


        @if($isPublished)

            <span
                class="inline-flex items-center gap-1.5 rounded-lg border border-green-500/20 bg-green-500/10 px-2.5 py-1.5 text-[11px] font-bold text-green-400"
            >

                <x-lucide-check-circle class="h-3.5 w-3.5" />

                منتشر شده

            </span>

        @else

            <span
                class="inline-flex items-center gap-1.5 rounded-lg border border-yellow-500/20 bg-yellow-500/10 px-2.5 py-1.5 text-[11px] font-bold text-yellow-400"
            >

                <x-lucide-clock-3 class="h-3.5 w-3.5" />

                در انتظار بررسی

            </span>

        @endif

    </div>

</article>
