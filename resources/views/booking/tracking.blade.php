@extends('layouts.app')

@section('title', 'پیگیری نوبت | BarberBook')

@section('description')
    پیگیری وضعیت نوبت آرایشگاه با کد رهگیری و شماره موبایل
@endsection

@section('content')

    @php

        $booking = $booking ?? null;

        $status = $booking?->status;

        $statusMap = [

            'pending' => [
                'label' => 'در انتظار تأیید',
                'class' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                'icon' => 'clock-3',
            ],

            'approved' => [
                'label' => 'تأیید شده',
                'class' => 'bg-green-500/10 text-green-400 border-green-500/20',
                'icon' => 'circle-check',
            ],

            'rejected' => [
                'label' => 'رد شده',
                'class' => 'bg-red-500/10 text-red-400 border-red-500/20',
                'icon' => 'circle-x',
            ],

            'completed' => [
                'label' => 'تکمیل شده',
                'class' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                'icon' => 'check-check',
            ],

        ];

        $statusData = $statusMap[$status] ?? [
            'label' => 'نامشخص',
            'class' => 'bg-zinc-800 text-zinc-300 border-zinc-700',
            'icon' => 'circle-help',
        ];

    @endphp


    <div
        class="
            min-h-screen
            bg-background
            px-4
            py-8
            sm:px-6
            sm:py-12
            lg:px-8
        "
        dir="rtl"
    >

        <div class="mx-auto max-w-2xl">


            {{-- =====================================================
                Header
            ====================================================== --}}

            <div class="text-center">

                <div
                    class="
                        mx-auto
                        flex
                        h-14
                        w-14
                        items-center
                        justify-center
                        rounded-2xl
                        border
                        border-primary/20
                        bg-primary/10
                        text-primary
                    "
                >

                    <x-lucide-search-check class="h-6 w-6" />

                </div>


                <h1
                    class="
                        mt-5
                        text-2xl
                        font-black
                        text-text
                        sm:text-3xl
                    "
                >
                    پیگیری نوبت
                </h1>


                <p
                    class="
                        mx-auto
                        mt-2
                        max-w-lg
                        text-sm
                        leading-7
                        text-muted
                    "
                >
                    کد رهگیری و شماره موبایلی که هنگام رزرو وارد کردی را
                    وارد کن تا وضعیت نوبتت را ببینی.
                </p>

            </div>


            {{-- =====================================================
                Search Form
            ====================================================== --}}

            <div
                class="
                    mt-8
                    rounded-[28px]
                    border
                    border-border
                    bg-surface
                    p-5
                    shadow-xl
                    shadow-black/10
                    sm:p-6
                "
            >

                <form
                    method="POST"
                    action="{{ route('booking.track.lookup') }}"
                    class="space-y-5"
                >

                    @csrf


                    {{-- Tracking Code --}}

                    <div>

                        <label
                            for="reference_code"
                            class="mb-2 block text-sm font-bold text-text"
                        >
                            کد رهگیری
                        </label>


                        <input
                            id="reference_code"
                            type="text"
                            name="reference_code"
                            value="{{ old('reference_code', $referenceCode ?? '') }}"
                            placeholder="مثلاً BB-8F4K2P"
                            autocomplete="off"
                            autocapitalize="characters"
                            required
                            dir="ltr"
                            class="
                                w-full
                                rounded-xl
                                border
                                border-border
                                bg-background
                                px-4
                                py-3.5
                                text-sm
                                font-bold
                                tracking-wider
                                text-text
                                outline-none
                                transition
                                placeholder:tracking-normal
                                placeholder:text-zinc-600
                                focus:border-primary
                                focus:ring-2
                                focus:ring-primary/10
                            "
                        >


                        @error('reference_code')

                        <p class="mt-2 text-xs font-bold text-red-400">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- Phone --}}

                    <div>

                        <label
                            for="customer_phone"
                            class="mb-2 block text-sm font-bold text-text"
                        >
                            شماره موبایل
                        </label>


                        <input
                            id="customer_phone"
                            type="tel"
                            name="customer_phone"
                            value="{{ old('customer_phone') }}"
                            placeholder="0912xxxxxxx"
                            autocomplete="tel"
                            inputmode="tel"
                            required
                            dir="ltr"
                            class="
                                w-full
                                rounded-xl
                                border
                                border-border
                                bg-background
                                px-4
                                py-3.5
                                text-sm
                                text-text
                                outline-none
                                transition
                                placeholder:text-zinc-600
                                focus:border-primary
                                focus:ring-2
                                focus:ring-primary/10
                            "
                        >


                        @error('customer_phone')

                        <p class="mt-2 text-xs font-bold text-red-400">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- Lookup Error --}}

                    @error('tracking')

                    <div
                        class="
                                rounded-xl
                                border
                                border-red-500/20
                                bg-red-500/5
                                px-4
                                py-3
                                text-sm
                                font-bold
                                leading-6
                                text-red-400
                            "
                    >
                        {{ $message }}
                    </div>

                    @enderror


                    {{-- Submit --}}

                    <button
                        type="submit"
                        class="
                            flex
                            w-full
                            items-center
                            justify-center
                            gap-2
                            rounded-xl
                            bg-primary
                            px-5
                            py-3.5
                            text-sm
                            font-black
                            text-white
                            shadow-lg
                            shadow-primary/20
                            transition
                            hover:bg-primary-hover
                            active:scale-[0.99]
                        "
                    >

                        <x-lucide-search class="h-5 w-5" />

                        پیگیری نوبت

                    </button>

                </form>

            </div>


            {{-- =====================================================
                Booking Result
            ====================================================== --}}

            @if($booking)

                <div
                    class="
                        mt-5
                        overflow-hidden
                        rounded-[28px]
                        border
                        border-border
                        bg-surface
                    "
                >

                    {{-- Result Header --}}

                    <div
                        class="
                            border-b
                            border-border
                            bg-background/50
                            p-5
                            sm:p-6
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

                            <div>

                                <p class="text-xs font-bold text-muted">
                                    نوبت شما
                                </p>


                                <h2
                                    class="
                                        mt-1
                                        text-xl
                                        font-black
                                        text-text
                                    "
                                >
                                    {{ $booking->salon?->name ?? 'آرایشگاه' }}
                                </h2>

                            </div>


                            <span
                                class="
                                    inline-flex
                                    w-fit
                                    items-center
                                    gap-2
                                    rounded-full
                                    border
                                    px-3
                                    py-2
                                    text-xs
                                    font-black
                                    {{ $statusData['class'] }}
                                    "
                            >

                                @if($statusData['icon'] === 'clock-3')

                                    <x-lucide-clock-3 class="h-4 w-4" />

                                @elseif($statusData['icon'] === 'circle-check')

                                    <x-lucide-circle-check class="h-4 w-4" />

                                @elseif($statusData['icon'] === 'circle-x')

                                    <x-lucide-circle-x class="h-4 w-4" />

                                @elseif($statusData['icon'] === 'check-check')

                                    <x-lucide-check-check class="h-4 w-4" />

                                @else

                                    <x-lucide-circle-help class="h-4 w-4" />

                                @endif

                                {{ $statusData['label'] }}

                            </span>

                        </div>

                    </div>


                    {{-- Details --}}

                    <div class="grid gap-px bg-border sm:grid-cols-2">

                        {{-- Service --}}

                        <div class="bg-surface p-5">

                            <p class="text-xs text-muted">
                                خدمت
                            </p>

                            <p class="mt-2 text-sm font-black text-text">
                                {{ $booking->service?->name ?? '—' }}
                            </p>

                        </div>


                        {{-- Reference --}}

                        <div class="bg-surface p-5">

                            <p class="text-xs text-muted">
                                کد رهگیری
                            </p>

                            <p
                                dir="ltr"
                                class="
                                    mt-2
                                    text-sm
                                    font-black
                                    tracking-wider
                                    text-primary
                                "
                            >
                                {{ $booking->reference_code }}
                            </p>

                        </div>


                        {{-- Date --}}

                        <div class="bg-surface p-5">

                            <p class="text-xs text-muted">
                                تاریخ
                            </p>

                            <p class="mt-2 text-sm font-black text-text">

                                @if($booking->booking_date)

                                    {{ \Morilog\Jalali\Jalalian::fromCarbon(
                                        \Carbon\Carbon::parse($booking->booking_date)
                                    )->format('Y/m/d') }}

                                @else

                                    —

                                @endif

                            </p>

                        </div>


                        {{-- Time --}}

                        <div class="bg-surface p-5">

                            <p class="text-xs text-muted">
                                ساعت
                            </p>

                            <p
                                dir="ltr"
                                class="
                                    mt-2
                                    text-sm
                                    font-black
                                    text-text
                                "
                            >
                                {{ $booking->booking_time ? substr($booking->booking_time, 0, 5) : '—' }}
                            </p>

                        </div>


                        {{-- Customer --}}

                        <div class="bg-surface p-5">

                            <p class="text-xs text-muted">
                                نام
                            </p>

                            <p class="mt-2 text-sm font-black text-text">
                                {{ $booking->customer_name }}
                            </p>

                        </div>


                        {{-- Price --}}

                        <div class="bg-surface p-5">

                            <p class="text-xs text-muted">
                                مبلغ
                            </p>

                            <p class="mt-2 text-sm font-black text-primary">

                                {{ number_format((float) ($booking->final_price ?? 0)) }}

                                <span class="text-xs font-normal text-muted">
                                    تومان
                                </span>

                            </p>

                        </div>

                    </div>


                    {{-- Status Message --}}

                    <div
                        class="
                            border-t
                            border-border
                            bg-background/40
                            p-5
                            sm:p-6
                        "
                    >

                        @if($booking->status === 'pending')

                            <div class="flex items-start gap-3">

                                <x-lucide-info
                                    class="mt-0.5 h-5 w-5 shrink-0 text-yellow-400"
                                />

                                <p
                                    class="
                                        text-sm
                                        leading-7
                                        text-zinc-400
                                    "
                                >
                                    درخواست شما ثبت شده و در انتظار تأیید آرایشگر است.
                                </p>

                            </div>

                        @elseif($booking->status === 'approved')

                            <div class="flex items-start gap-3">

                                <x-lucide-circle-check
                                    class="mt-0.5 h-5 w-5 shrink-0 text-green-400"
                                />

                                <p
                                    class="
                                        text-sm
                                        leading-7
                                        text-zinc-400
                                    "
                                >
                                    نوبت شما با موفقیت توسط آرایشگر تأیید شده است.
                                </p>

                            </div>

                        @elseif($booking->status === 'rejected')

                            <div class="flex items-start gap-3">

                                <x-lucide-circle-x
                                    class="mt-0.5 h-5 w-5 shrink-0 text-red-400"
                                />

                                <p
                                    class="
                                        text-sm
                                        leading-7
                                        text-zinc-400
                                    "
                                >
                                    این درخواست توسط آرایشگر تأیید نشده است.
                                </p>

                            </div>

                        @elseif($booking->status === 'completed')

                            <div class="flex items-start gap-3">

                                <x-lucide-check-check
                                    class="mt-0.5 h-5 w-5 shrink-0 text-blue-400"
                                />

                                <p
                                    class="
                                        text-sm
                                        leading-7
                                        text-zinc-400
                                    "
                                >
                                    این نوبت تکمیل شده است.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            @endif


            {{-- =====================================================
                Back
            ====================================================== --}}

            <div class="mt-5 text-center">

                <a
                    href="{{ url()->previous() }}"
                    class="
                        inline-flex
                        items-center
                        gap-2
                        text-xs
                        font-bold
                        text-muted
                        transition
                        hover:text-primary
                    "
                >

                    <x-lucide-arrow-right class="h-4 w-4" />

                    بازگشت

                </a>

            </div>

        </div>

    </div>

@endsection
