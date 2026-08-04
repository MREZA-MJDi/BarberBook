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


<body class="bg-zinc-950 text-zinc-100 antialiased min-h-screen">


<div class="min-h-screen">


    {{-- Sidebar --}}
    <x-dashboard.sidebar />



    {{-- Main Wrapper --}}
    <div class="lg:mr-72 min-h-screen">


        {{-- Topbar --}}
        <x-dashboard.topbar />



        {{-- Content --}}
        <main class="p-5 lg:p-8">


            {{ $slot }}


        </main>


    </div>


</div>



@stack('scripts')


</body>

</html>
