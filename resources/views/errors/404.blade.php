<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>صفحه پیدا نشد | BarberBook</title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    ])

</head>

<body class="min-h-screen bg-zinc-950 text-white">

<main class="flex min-h-screen items-center justify-center px-6 py-12">

    <div class="w-full max-w-lg text-center">

        <div
            class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl
                border border-orange-500/20 bg-orange-500/10"
        >

            <x-lucide-search-x
                class="h-10 w-10 text-orange-400"
            />

        </div>


        <p class="mt-8 text-7xl font-black tracking-tight text-orange-500">
            404
        </p>


        <h1 class="mt-6 text-2xl font-black text-white">
            صفحه پیدا نشد
        </h1>


        <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-zinc-500">
            صفحه‌ای که به دنبال آن هستید وجود ندارد،
            حذف شده یا آدرس آن تغییر کرده است.
        </p>


        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">

            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl
                    bg-orange-500 px-5 py-3 text-sm font-black text-black
                    transition hover:bg-orange-400"
            >

                <x-lucide-layout-dashboard class="h-4 w-4" />

                داشبورد

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

                بازگشت

            </button>

        </div>


        <div class="mt-12 text-xs font-bold text-zinc-700">
            BarberBook
        </div>

    </div>

</main>

</body>

</html>
