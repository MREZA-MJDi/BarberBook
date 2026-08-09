@props([
'activities' => collect(),
])


{{-- Header --}}
<div class="flex items-center justify-between">

    <div>

        <h2 class="text-lg font-black text-white">
            فعالیت‌های اخیر
        </h2>

        <p class="mt-1 text-sm text-zinc-500">
            آخرین اتفاقات سالن
        </p>

    </div>


    <div
        class="flex h-10 w-10 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10"
    >

        <x-lucide-bell
            class="h-5 w-5 text-orange-500"
        />

    </div>

</div>


{{-- Activities --}}
<div class="mt-6 space-y-5">

    @forelse($activities as $activity)

        @php

            $status = $activity->status;

            $dotColor = match ($status) {

                'pending' => 'bg-orange-500',

                'approved' => 'bg-green-500',

                'completed' => 'bg-blue-500',

                'rejected' => 'bg-red-500',

                default => 'bg-zinc-500',

            };


            $message = match ($status) {

                'pending' =>
                    $activity->customer_name . ' یک رزرو جدید ثبت کرد',

                'approved' =>
                    'رزرو ' . $activity->customer_name . ' تایید شد',

                'completed' =>
                    'رزرو ' . $activity->customer_name . ' تکمیل شد',

                'rejected' =>
                    'رزرو ' . $activity->customer_name . ' رد شد',

                default =>
                    'رزرو ' . $activity->customer_name . ' به‌روزرسانی شد',

            };

        @endphp


        {{-- Activity Item --}}
        <a
            href="{{ route('bookings.show', $activity) }}"
            class="flex gap-4 rounded-xl p-2 -mx-2 transition hover:bg-zinc-900"
        >

            {{-- Indicator --}}
            <div
                class="mt-1 h-3 w-3 shrink-0 rounded-full {{ $dotColor }}"
            ></div>


            {{-- Content --}}
            <div class="min-w-0">

                <p class="text-sm font-bold text-white">
                    {{ $message }}
                </p>


                <span class="mt-1 block text-xs text-zinc-500">

                    {{ $activity->updated_at?->diffForHumans() }}

                </span>

            </div>

        </a>


    @empty

        {{-- Empty State --}}
        <div
            class="rounded-xl border border-dashed border-zinc-800 bg-zinc-950 p-6 text-center"
        >

            <x-lucide-bell-off
                class="mx-auto h-7 w-7 text-zinc-700"
            />

            <p class="mt-3 text-sm font-bold text-zinc-400">
                هنوز فعالیتی ثبت نشده
            </p>

            <p class="mt-1 text-xs text-zinc-600">
                فعالیت‌های رزروهای شما اینجا نمایش داده می‌شوند.
            </p>

        </div>

    @endforelse

</div>
