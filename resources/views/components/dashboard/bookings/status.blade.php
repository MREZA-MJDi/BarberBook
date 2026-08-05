@props([
'status'
])


@php

    $statusMap = [

        'pending'=>[
            'title'=>'در انتظار',
            'class'=>'bg-orange-500/10 text-orange-400'
        ],

        'approved'=>[
            'title'=>'تایید شده',
            'class'=>'bg-green-500/10 text-green-400'
        ],

        'completed'=>[
            'title'=>'تکمیل شده',
            'class'=>'bg-blue-500/10 text-blue-400'
        ],

        'rejected'=>[
            'title'=>'رد شده',
            'class'=>'bg-red-500/10 text-red-400'
        ],

        'cancelled'=>[
            'title'=>'لغو شده',
            'class'=>'bg-zinc-500/10 text-zinc-400'
        ],

    ];

@endphp



<span class="rounded-full px-3 py-1 text-xs font-bold {{ $statusMap[$status]['class'] }}">

    {{ $statusMap[$status]['title'] }}

</span>
