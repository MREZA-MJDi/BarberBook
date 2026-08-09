@props([
'booking'
])


<div class="space-y-3">


    {{-- =========================================================
        Pending
    ========================================================== --}}

    @if($booking->status === 'pending')


        {{-- Approve --}}
        <form
            method="POST"
            action="{{ route('bookings.approve', $booking) }}"
        >

            @csrf
            @method('PATCH')


            <button
                type="submit"
                class="flex w-full items-center justify-center rounded-xl
                bg-green-500 px-4 py-3 text-sm font-black text-black
                transition hover:bg-green-400"
            >

                تایید رزرو

            </button>

        </form>


        {{-- Reject --}}
        <form
            method="POST"
            action="{{ route('bookings.reject', $booking) }}"
        >

            @csrf
            @method('PATCH')


            <button
                type="submit"
                class="flex w-full items-center justify-center rounded-xl
                border border-red-500/30 bg-red-500/10
                px-4 py-3 text-sm font-black text-red-400
                transition hover:bg-red-500 hover:text-white"
            >

                رد رزرو

            </button>

        </form>


    @endif



    {{-- =========================================================
        Approved
    ========================================================== --}}

    @if($booking->status === 'approved')


        {{-- Complete --}}
        <form
            method="POST"
            action="{{ route('bookings.complete', $booking) }}"
        >

            @csrf
            @method('PATCH')


            <button
                type="submit"
                class="flex w-full items-center justify-center rounded-xl
                bg-orange-500 px-4 py-3 text-sm font-black text-black
                transition hover:bg-orange-400"
            >

                تکمیل خدمت

            </button>

        </form>



        {{-- Reschedule --}}
        <form
            method="POST"
            action="{{ route('bookings.reschedule', $booking) }}"
            class="space-y-3 rounded-xl border border-zinc-800 bg-zinc-950 p-4"
        >

            @csrf
            @method('PATCH')


            <div>

                <label
                    for="booking_date_{{ $booking->id }}"
                    class="mb-2 block text-xs font-bold text-zinc-400"
                >
                    تغییر تاریخ
                </label>


                <input
                    id="booking_date_{{ $booking->id }}"
                    type="date"
                    name="booking_date"
                    value="{{ old('booking_date', $booking->booking_date) }}"
                    min="{{ today()->toDateString() }}"
                    required
                    class="w-full rounded-xl border border-zinc-800
                    bg-zinc-900 px-4 py-3 text-sm text-white
                    outline-none transition
                    focus:border-orange-500"
                >

            </div>



            <div>

                <label
                    for="booking_time_{{ $booking->id }}"
                    class="mb-2 block text-xs font-bold text-zinc-400"
                >
                    تغییر ساعت
                </label>


                <input
                    id="booking_time_{{ $booking->id }}"
                    type="time"
                    name="booking_time"
                    value="{{ old(
                        'booking_time',
                        \Carbon\Carbon::parse($booking->booking_time)->format('H:i')
                    ) }}"
                    required
                    class="w-full rounded-xl border border-zinc-800
                    bg-zinc-900 px-4 py-3 text-sm text-white
                    outline-none transition
                    focus:border-orange-500"
                >

            </div>



            <div>

                <label
                    for="barber_note_{{ $booking->id }}"
                    class="mb-2 block text-xs font-bold text-zinc-400"
                >
                    یادداشت آرایشگر
                </label>


                <textarea
                    id="barber_note_{{ $booking->id }}"
                    name="barber_note"
                    rows="3"
                    maxlength="1000"
                    placeholder="در صورت نیاز توضیحی بنویسید..."
                    class="w-full resize-none rounded-xl border border-zinc-800
                    bg-zinc-900 px-4 py-3 text-sm text-white
                    outline-none transition
                    placeholder:text-zinc-600
                    focus:border-orange-500"
                >{{ old('barber_note', $booking->barber_note) }}</textarea>

            </div>



            <button
                type="submit"
                class="flex w-full items-center justify-center rounded-xl
                border border-orange-500/30 bg-orange-500/10
                px-4 py-3 text-sm font-black text-orange-400
                transition hover:bg-orange-500 hover:text-black"
            >

                تغییر زمان رزرو

            </button>

        </form>


    @endif



    {{-- =========================================================
        Completed
    ========================================================== --}}

    @if($booking->status === 'completed')

        <div
            class="rounded-xl border border-blue-500/20
            bg-blue-500/10 px-4 py-3 text-center
            text-sm font-bold text-blue-400"
        >

            این رزرو تکمیل شده است.

        </div>

    @endif



    {{-- =========================================================
        Rejected
    ========================================================== --}}

    @if($booking->status === 'rejected')

        <div
            class="rounded-xl border border-red-500/20
            bg-red-500/10 px-4 py-3 text-center
            text-sm font-bold text-red-400"
        >

            این رزرو رد شده است.

        </div>

    @endif



    {{-- =========================================================
        Cancelled
    ========================================================== --}}

    @if($booking->status === 'cancelled')

        <div
            class="rounded-xl border border-zinc-800
            bg-zinc-950 px-4 py-3 text-center
            text-sm font-bold text-zinc-500"
        >

            این رزرو لغو شده است.

        </div>

    @endif

</div>

