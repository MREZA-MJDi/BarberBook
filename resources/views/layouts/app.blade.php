<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'نوبت | سیستم رزرو آنلاین آرایشگاه')</title>

    <meta name="description"
          content="@yield('description', 'سیستم رزرو آنلاین نوبت آرایشگاه')">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS & JS --}}
    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    ])

    @stack('styles')
</head>

<body class="bg-zinc-950 text-zinc-100 antialiased min-h-screen">

@yield('content')

@stack('scripts')

</body>

</html>
