{{-- resources/views/components/dashboard/welcome-card.blade.php --}}

<section
    class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6"
>

    <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">


        {{-- =====================================================
            Welcome
        ====================================================== --}}

        <div>

            <h1 class="text-2xl font-black text-white">

                سلام
                {{ auth()->user()->full_name ?? 'آرایشگر' }}
                👋

            </h1>


            <p class="mt-2 text-sm text-zinc-400">

                {{ now()->locale('fa')->translatedFormat('l، j F Y') }}

            </p>


            {{-- =================================================
                Status / Summary
            ================================================== --}}

            <div class="mt-5 flex flex-wrap gap-3">


                {{-- =================================================
                    Salon Status
                ================================================== --}}

                <div
                    class="flex items-center gap-2 rounded-xl bg-zinc-800 px-4 py-2"
                >

                    @if($salonStatus['status'] === 'open')

                        <span
                            class="h-2.5 w-2.5 rounded-full bg-green-500"
                        ></span>

                        <span class="text-sm text-zinc-300">

                            سالن باز است

                            @if(!empty($salonStatus['end_time']))

                                <span class="text-zinc-500">
                                    تا {{ \Carbon\Carbon::parse($salonStatus['end_time'])->format('H:i') }}
                                </span>

                            @endif

                        </span>


                    @elseif($salonStatus['status'] === 'break')

                        <span
                            class="h-2.5 w-2.5 rounded-full bg-yellow-500"
                        ></span>

                        <span class="text-sm text-yellow-400">
                            سالن در زمان استراحت است
                        </span>


                    @elseif($salonStatus['status'] === 'inactive')

                        <span
                            class="h-2.5 w-2.5 rounded-full bg-zinc-500"
                        ></span>

                        <span class="text-sm text-zinc-400">
                            سالن غیرفعال است
                        </span>


                    @else

                        <span
                            class="h-2.5 w-2.5 rounded-full bg-red-500"
                        ></span>

                        <span class="text-sm text-zinc-300">

                            سالن بسته است

                        </span>

                    @endif

                </div>



                {{-- =================================================
                    Today's Bookings
                ================================================== --}}

                <div class="rounded-xl bg-zinc-800 px-4 py-2">

                    <span class="text-sm text-zinc-300">

                        امروز

                        <strong class="text-white">
                            {{ $stats['today_bookings'] ?? 0 }}
                        </strong>

                        رزرو دارید

                    </span>

                </div>



                {{-- =================================================
                    Pending Requests
                ================================================== --}}

                <div class="rounded-xl bg-zinc-800 px-4 py-2">

                    <span class="text-sm text-zinc-300">

                        <strong class="text-white">
                            {{ $stats['pending_bookings'] ?? 0 }}
                        </strong>

                        درخواست جدید

                    </span>

                </div>

            </div>

        </div>



        {{-- =====================================================
            Actions
        ====================================================== --}}

        <div class="flex flex-wrap gap-3">


            {{-- =================================================
                Manual Booking
            ================================================== --}}

            <a
                href="{{ route('bookings.index') }}"
                class="rounded-xl bg-orange-500 px-5 py-3
                text-sm font-bold text-black
                transition hover:bg-orange-400"
            >

                + ثبت رزرو دستی

            </a>



            {{-- =================================================
                Today's Bookings
            ================================================== --}}

            <a
                href="{{ route('bookings.index') }}"
                class="rounded-xl bg-zinc-800 px-5 py-3
                text-sm font-bold text-white
                transition hover:bg-zinc-700"
            >

                📅 رزروهای امروز

            </a>



            {{-- =================================================
                Close / Open Salon
            ================================================== --}}

            @if($salonStatus['status'] === 'open')

                <form
                    action="{{ route('dashboard.salon.close-today') }}"
                    method="POST"
                >

                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="rounded-xl border border-red-500/30
                        px-5 py-3
                        text-sm font-bold text-red-400
                        transition hover:bg-red-500/10"
                    >

                        🔴 بستن سالن

                    </button>

                </form>


            @else

                <form
                    action="{{ route('dashboard.salon.open-today') }}"
                    method="POST"
                >

                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="rounded-xl border border-green-500/30
                        px-5 py-3
                        text-sm font-bold text-green-400
                        transition hover:bg-green-500/10"
                    >

                        🟢 باز کردن سالن

                    </button>

                </form>

            @endif

        </div>

    </div>

</section>

