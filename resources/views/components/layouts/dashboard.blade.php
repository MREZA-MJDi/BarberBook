{{-- resources/views/layouts/dashboard.blade.php --}}

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    @yield('title', 'داشبورد | BarberBook')
</title>

<meta
    name="csrf-token"
    content="{{ csrf_token() }}"
>

@vite([
'resources/css/app.css',
'resources/js/app.js',
])

@stack('styles')


{{-- =========================================================
    Dashboard Shell
========================================================== --}}

{{-- =====================================================
    Sidebar
====================================================== --}}

<x-dashboard.sidebar />



{{-- =====================================================
    Main Content Area
====================================================== --}}

<div class="lg:mr-72">


    {{-- =================================================
        Topbar
    ================================================== --}}

    <x-dashboard.topbar />



    {{-- =================================================
        Global Flash Alerts
    ================================================== --}}

    @if(
        session('success') ||
        session('error') ||
        session('warning') ||
        session('info') ||
        $errors->any()
    )

        <div class="px-5 pt-5 lg:px-8">

            <div class="mx-auto max-w-7xl space-y-3">


                {{-- =====================================
                    Success
                ====================================== --}}

                @if(session('success'))

                    <div
                        class="flex items-center gap-3 rounded-2xl
                        border border-green-500/20
                        bg-green-500/10
                        px-5 py-4
                        text-sm font-bold text-green-400"
                    >

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center
                            rounded-xl bg-green-500/10"
                        >

                            <x-lucide-check-circle
                                class="h-5 w-5"
                            />

                        </div>


                        <p>
                            {{ session('success') }}
                        </p>

                    </div>

                @endif



                {{-- =====================================
                    Error
                ====================================== --}}

                @if(session('error'))

                    <div
                        class="flex items-center gap-3 rounded-2xl
                        border border-red-500/20
                        bg-red-500/10
                        px-5 py-4
                        text-sm font-bold text-red-400"
                    >

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center
                            rounded-xl bg-red-500/10"
                        >

                            <x-lucide-circle-alert
                                class="h-5 w-5"
                            />

                        </div>


                        <p>
                            {{ session('error') }}
                        </p>

                    </div>

                @endif



                {{-- =====================================
                    Warning
                ====================================== --}}

                @if(session('warning'))

                    <div
                        class="flex items-center gap-3 rounded-2xl
                        border border-yellow-500/20
                        bg-yellow-500/10
                        px-5 py-4
                        text-sm font-bold text-yellow-400"
                    >

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center
                            rounded-xl bg-yellow-500/10"
                        >

                            <x-lucide-triangle-alert
                                class="h-5 w-5"
                            />

                        </div>


                        <p>
                            {{ session('warning') }}
                        </p>

                    </div>

                @endif



                {{-- =====================================
                    Info
                ====================================== --}}

                @if(session('info'))

                    <div
                        class="flex items-center gap-3 rounded-2xl
                        border border-blue-500/20
                        bg-blue-500/10
                        px-5 py-4
                        text-sm font-bold text-blue-400"
                    >

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center
                            rounded-xl bg-blue-500/10"
                        >

                            <x-lucide-info
                                class="h-5 w-5"
                            />

                        </div>


                        <p>
                            {{ session('info') }}
                        </p>

                    </div>

                @endif



                {{-- =====================================
                    Validation Errors
                ====================================== --}}

                @if($errors->any())

                    <div
                        class="rounded-2xl
                        border border-red-500/20
                        bg-red-500/10
                        px-5 py-4
                        text-sm text-red-400"
                    >

                        <div class="flex items-center gap-3">


                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center
                                rounded-xl bg-red-500/10"
                            >

                                <x-lucide-circle-alert
                                    class="h-5 w-5"
                                />

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



    {{-- =================================================
        Page
    ================================================== --}}

    <main
        class="px-5 py-6 lg:px-8 lg:py-8"
    >

        <div
            class="mx-auto max-w-7xl"
        >

            {{ $slot }}

        </div>

    </main>


</div>



{{-- =========================================================
    Scripts
========================================================== --}}

@stack('scripts')

