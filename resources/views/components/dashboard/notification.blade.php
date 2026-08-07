<div class="space-y-4">


    @forelse($notifications as $notification)


        <div
            class="flex items-start gap-4 rounded-xl border border-zinc-800 bg-zinc-950 p-4 transition hover:border-orange-500/40">


            {{-- Icon --}}
            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl
                bg-orange-500/10 border border-orange-500/20 text-orange-500">


                @if($notification['type'] === 'bookings')


                    {{-- Calendar --}}
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                    </svg>


                @elseif($notification['type'] === 'success')


                    {{-- Check --}}
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 13l4 4L19 7"/>

                    </svg>


                @else


                    {{-- Bell --}}
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1"/>

                    </svg>


                @endif


            </div>





            {{-- Content --}}
            <div class="flex-1">


                <h4 class="font-bold text-white">

                    {{ $notification['title'] }}

                </h4>



                <p class="mt-1 text-sm text-zinc-400">

                    {{ $notification['message'] }}

                </p>



                <span class="mt-2 block text-xs text-zinc-600">

                    {{ $notification['time'] }}

                </span>


            </div>



        </div>



    @empty


        <div
            class="rounded-xl border border-dashed border-zinc-800 bg-zinc-950 p-6 text-center">


            <p class="text-sm text-zinc-500">

                اعلان جدیدی وجود ندارد.

            </p>


        </div>


    @endforelse



</div>
