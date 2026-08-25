@props([
'status' => null,
])

@php

    $status = $status ?? 'pending';

    $statuses = [

        'pending' => [
            'label' => 'در انتظار تایید',
            'class' => 'border-yellow-500/20 bg-yellow-500/10 text-yellow-400',
            'dot' => 'bg-yellow-500',
            'icon' => 'clock-3',
        ],

        'approved' => [
            'label' => 'تایید شده',
            'class' => 'border-green-500/20 bg-green-500/10 text-green-400',
            'dot' => 'bg-green-500',
            'icon' => 'circle-check',
        ],

        'confirmed' => [
            'label' => 'تایید شده',
            'class' => 'border-green-500/20 bg-green-500/10 text-green-400',
            'dot' => 'bg-green-500',
            'icon' => 'circle-check',
        ],

        'completed' => [
            'label' => 'انجام شده',
            'class' => 'border-blue-500/20 bg-blue-500/10 text-blue-400',
            'dot' => 'bg-blue-500',
            'icon' => 'check-check',
        ],

        'rejected' => [
            'label' => 'رد شده',
            'class' => 'border-red-500/20 bg-red-500/10 text-red-400',
            'dot' => 'bg-red-500',
            'icon' => 'circle-x',
        ],

        'cancelled' => [
            'label' => 'لغو شده',
            'class' => 'border-red-500/20 bg-red-500/10 text-red-400',
            'dot' => 'bg-red-500',
            'icon' => 'ban',
        ],

        'canceled' => [
            'label' => 'لغو شده',
            'class' => 'border-red-500/20 bg-red-500/10 text-red-400',
            'dot' => 'bg-red-500',
            'icon' => 'ban',
        ],

        'processing' => [
            'label' => 'در حال انجام',
            'class' => 'border-orange-500/20 bg-orange-500/10 text-orange-400',
            'dot' => 'bg-orange-500',
            'icon' => 'loader-circle',
        ],

    ];

    $current = $statuses[$status] ?? [
        'label' => 'نامشخص',
        'class' => 'border-zinc-700 bg-zinc-800 text-zinc-400',
        'dot' => 'bg-zinc-500',
        'icon' => 'circle-help',
    ];

@endphp

<span
    {{ $attributes->merge([
        'class' => 'inline-flex items-center gap-2 rounded-xl border px-3 py-1.5 text-xs font-bold ' . $current['class'],
    ]) }}
>

    <span
        class="h-2 w-2 shrink-0 rounded-full {{ $current['dot'] }}"
    ></span>

    <x-dynamic-component
        :component="'lucide-' . $current['icon']"
        class="h-3.5 w-3.5"
    />

    <span>
        {{ $current['label'] }}
    </span>

</span>
