<div
    class="min-h-screen bg-zinc-950 text-zinc-100"
    dir="rtl"
>

    {{-- =========================================================
        Customer Sidebar
    ========================================================== --}}

    <x-customer.sidebar />


    {{-- =========================================================
        Main Application Area
    ========================================================== --}}

    <div class="min-h-screen lg:mr-72">

        {{-- =====================================================
            Topbar
        ====================================================== --}}

        <x-customer.topbar />


        {{-- =====================================================
            Global Flash Messages
        ====================================================== --}}

        @if(
            session('success') ||
            session('error') ||
            session('warning') ||
            session('info') ||
            $errors->any()
        )

            <div class="px-4 pt-4 sm:px-6 lg:px-8">

                <div class="mx-auto max-w-7xl space-y-3">

                    {{-- Success --}}
                    @if(session('success'))

                        <div
                            class="flex items-center gap-3 rounded-2xl
                            border border-green-500/20
                            bg-green-500/10
                            px-4 py-3
                            text-sm font-bold text-green-400"
                        >

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center
                                rounded-xl bg-green-500/10"
                            >
                                <x-lucide-check-circle class="h-5 w-5" />
                            </div>

                            <p>
                                {{ session('success') }}
                            </p>

                        </div>

                    @endif


                    {{-- Error --}}
                    @if(session('error'))

                        <div
                            class="flex items-center gap-3 rounded-2xl
                            border border-red-500/20
                            bg-red-500/10
                            px-4 py-3
                            text-sm font-bold text-red-400"
                        >

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center
                                rounded-xl bg-red-500/10"
                            >
                                <x-lucide-circle-alert class="h-5 w-5" />
                            </div>

                            <p>
                                {{ session('error') }}
                            </p>

                        </div>

                    @endif


                    {{-- Warning --}}
                    @if(session('warning'))

                        <div
                            class="flex items-center gap-3 rounded-2xl
                            border border-yellow-500/20
                            bg-yellow-500/10
                            px-4 py-3
                            text-sm font-bold text-yellow-400"
                        >

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center
                                rounded-xl bg-yellow-500/10"
                            >
                                <x-lucide-triangle-alert class="h-5 w-5" />
                            </div>

                            <p>
                                {{ session('warning') }}
                            </p>

                        </div>

                    @endif


                    {{-- Info --}}
                    @if(session('info'))

                        <div
                            class="flex items-center gap-3 rounded-2xl
                            border border-blue-500/20
                            bg-blue-500/10
                            px-4 py-3
                            text-sm font-bold text-blue-400"
                        >

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center
                                rounded-xl bg-blue-500/10"
                            >
                                <x-lucide-info class="h-5 w-5" />
                            </div>

                            <p>
                                {{ session('info') }}
                            </p>

                        </div>

                    @endif


                    {{-- Validation Errors --}}
                    @if($errors->any())

                        <div
                            class="rounded-2xl
                            border border-red-500/20
                            bg-red-500/10
                            px-4 py-4
                            text-sm text-red-400"
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center
                                    rounded-xl bg-red-500/10"
                                >
                                    <x-lucide-circle-alert class="h-5 w-5" />
                                </div>

                                <p class="font-black">
                                    اطلاعات واردشده صحیح نیست.
                                </p>

                            </div>

                            <ul class="mt-3 space-y-1 pr-12">

                                @foreach($errors->all() as $error)

                                    <li>
                                        • {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                </div>

            </div>

        @endif


        {{-- =====================================================
            Page Content
        ====================================================== --}}

        <main class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8">

            <div class="mx-auto max-w-7xl">

                {{ $slot }}

            </div>

        </main>

    </div>


    {{-- =========================================================
        Mobile Navigation
    ========================================================== --}}

    <x-customer.mobile-nav />

</div>
