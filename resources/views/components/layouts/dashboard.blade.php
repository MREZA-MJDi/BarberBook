<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'داشبورد | BarberBook')
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    ])

    @stack('styles')

</head>

<body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">

{{-- Sidebar --}}
<x-dashboard.sidebar />

{{-- Main --}}
<div class="min-h-screen lg:mr-72">

    {{-- Topbar --}}
    <x-dashboard.topbar />

    {{-- Page --}}
    <main class="px-5 py-6 lg:px-8 lg:py-8">

        <div class="mx-auto max-w-7xl">

            {{ $slot }}

        </div>

    </main>

</div>

@stack('scripts')

</body>

</html>
