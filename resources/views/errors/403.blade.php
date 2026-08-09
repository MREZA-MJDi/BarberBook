<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>دسترسی غیرمجاز | BarberBook</title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    ])

</head>

<body class="min-h-screen bg-zinc-950 text-white">

<main class="flex min-h-screen items-center justify-center px-6 py-12">

    <div class="w-full max-w-lg text-center">

        {{-- Icon --}}
        <div
            class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl
                border border-red-500/20 bg-red-500/10"
        >

            <x-lucide-shield-x
                class="h-10 w-10 text-red-400"
            />

        </div>


        {{-- Code --}}
        <p class="mt-8 text-7xl font-black tracking-tight text-orange-500">
            403
        </p>


        {{-- Title --}}
        <h1 class="mt-6 text-2xl font-black text-white">
            دسترسی غیرمجاز
        </h1>


        {{-- Description --}}
        <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-zinc-500">
            شما اجازه دسترسی به این بخش را ندارید.
            اگر فکر می‌کنید این یک اشتباه است، با مدیر سیستم تماس بگیرید.
        </p>


        {{-- Actions --}}
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">

            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl
                    bg-orange-500 px-5 py-3 text-sm font-black text-black
                    transition hover:bg-orange-400"
            >

                <x-lucide-layout-dashboard class="h-4 w-4" />

                بازگشت به داشبورد

            </a>


            <button
                type="button"
                onclick="history.back()"
                class="inline-flex items-center justify-center gap-2 rounded-xl
                    border border-zinc-800 bg-zinc-900 px-5 py-3
                    text-sm font-bold text-zinc-300 transition
                    hover:border-orange-500/40 hover:text-orange-400"
            >

                <x-lucide-arrow-right class="h-4 w-4" />

                صفحه قبل

            </button>

        </div>


        {{-- Brand --}}
        <div class="mt-12 text-xs font-bold text-zinc-700">
            BarberBook
        </div>

    </div>

</main>

</body>

</html>
