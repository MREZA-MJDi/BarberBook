{{-- resources/views/components/customer/appointment-status.blade.php --}}

@props([
'status',
])

@php
    $statuses = [
        'pending' => [
            'label' => 'در انتظار تأیید',
            'class' => 'border-amber-500/20 bg-amber-500/10 text-amber-400',
            'dot'   => 'bg-amber-400',
        ],

        'approved' => [
            'label' => 'تأیید شده',
            'class' => 'border-emerald-500/20 bg-emerald-500/10 text-emerald-400',
            'dot'   => 'bg-emerald-400',
        ],

        'completed' => [
            'label' => 'انجام شده',
            'class' => 'border-primary/20 bg-primary/10 text-primary',
            'dot'   => 'bg-primary',
        ],

        'rejected' => [
            'label' => 'رد شده',
            'class' => 'border-red-500/20 bg-red-500/10 text-red-400',
            'dot'   => 'bg-red-400',
        ],

        'cancelled' => [
            'label' => 'لغو شده',
            'class' => 'border-slate-500/20 bg-slate-500/10 text-slate-400',
            'dot'   => 'bg-slate-400',
        ],
    ];

    $current = $statuses[$status] ?? [
        'label' => 'نامشخص',
        'class' => 'border-slate-500/20 bg-slate-500/10 text-slate-400',
        'dot'   => 'bg-slate-400',
    ];
@endphp

<span
    {{ $attributes->merge([
        'class' => "
            inline-flex
            w-fit
            items-center
            gap-2
            rounded-full
            border
            px-3
            py-1.5
            text-xs
            font-black
            {$current['class']}
        ",
    ]) }}
>

    <span
        class="h-1.5 w-1.5 shrink-0 rounded-full {{ $current['dot'] }}"
    ></span>

    {{ $current['label'] }}

</span>
