<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>درخواست‌های زیاد | BarberBook</title>

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
                border border-yellow-500/20 bg-yellow-500/10"
        >

            <x-lucide-timer
                class="h-10 w-10 text-yellow-400"
            />

        </div>


        <p class="mt-8 text-7xl font-black tracking-tight text-orange-500">
            429
        </p>


        <h1 class="mt-6 text-2xl font-black text-white">
            کمی صبر کنید
        </h1>


        <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-zinc-500">
            درخواست‌های زیادی در مدت کوتاه ارسال شده است.
            چند لحظه صبر کنید و دوباره تلاش کنید.
        </p>


        <div class="mt-8">

            <button
                type="button"
                onclick="location.reload()"
                class="inline-flex items-center justify-center gap-2 rounded-xl
                    bg-orange-500 px-5 py-3 text-sm font-black text-black
                    transition hover:bg-orange-400"
            >

                <x-lucide-refresh-cw class="h-4 w-4" />

                تلاش مجدد

            </button>

        </div>


        <div class="mt-12 text-xs font-bold text-zinc-700">
            BarberBook
        </div>

    </div>

</main>

</body>

</html>
