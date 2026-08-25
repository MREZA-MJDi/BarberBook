<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

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

</head>

<body
    class="
        min-h-screen
        overflow-x-hidden
        bg-zinc-950
        text-zinc-100
        antialiased
    "
>

<div
    x-data="{ sidebarOpen: false }"
    @keydown.escape.window="sidebarOpen = false"
    class="min-h-screen"
>

    {{-- Sidebar --}}
    <x-dashboard.sidebar />


    {{-- Main --}}
    <div class="min-h-screen lg:mr-72">

        {{-- Topbar --}}
        <x-dashboard.topbar />


        {{-- Flash Messages --}}

        @if(
            session('success') ||
            session('error') ||
            session('warning') ||
            session('info') ||
            $errors->any()
        )

            <div class="px-4 pt-4 sm:px-6 lg:px-8">

                <div class="mx-auto max-w-7xl space-y-3">

                    @if(session('success'))

                        <div class="rounded-2xl border border-green-500/20 bg-green-500/10 px-4 py-3 text-sm font-bold text-green-400">
                            {{ session('success') }}
                        </div>

                    @endif


                    @if(session('error'))

                        <div class="rounded-2xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm font-bold text-red-400">
                            {{ session('error') }}
                        </div>

                    @endif


                    @if(session('warning'))

                        <div class="rounded-2xl border border-yellow-500/20 bg-yellow-500/10 px-4 py-3 text-sm font-bold text-yellow-400">
                            {{ session('warning') }}
                        </div>

                    @endif


                    @if(session('info'))

                        <div class="rounded-2xl border border-blue-500/20 bg-blue-500/10 px-4 py-3 text-sm font-bold text-blue-400">
                            {{ session('info') }}
                        </div>

                    @endif


                    @if($errors->any())

                        <div class="rounded-2xl border border-red-500/20 bg-red-500/10 px-4 py-4 text-sm text-red-400">

                            <p class="font-black">
                                اطلاعات واردشده صحیح نیست.
                            </p>

                            <ul class="mt-2 space-y-1">

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


        {{-- Page --}}

        <main
            class="
                w-full
                px-4
                py-5
                sm:px-6
                lg:px-8
                lg:py-8
            "
        >

            <div class="mx-auto max-w-7xl">

                {{ $slot }}

            </div>

        </main>

    </div>

</div>


@stack('scripts')

</body>

</html>
