<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        ورود | BarberBook
    </title>

    @vite([
    'resources/css/app.css',
    ])

</head>


<body class="min-h-screen bg-zinc-950 text-white">

<div
    class="
        min-h-screen
        lg:flex
    "
>


    {{-- =========================================================
        HERO
        Desktop: Left / Mobile: Top
    ========================================================== --}}

    <section
        class="
            relative
            h-[340px]
            w-full
            overflow-hidden
            sm:h-[390px]
            lg:h-screen
            lg:w-2/3
        "
    >

        {{-- Hero Image --}}

        <img
            src="{{ asset('images/auth/hero2.jpg') }}"
            alt="BarberBook"
            class="
                absolute
                inset-0
                h-full
                w-full
                object-cover
                object-center
            "
        >


        {{-- Overlay --}}

        <div
            class="
                absolute
                inset-0
                bg-gradient-to-b
                from-black/10
                via-black/35
                to-zinc-950/80
                lg:bg-zinc-950/65
            "
        ></div>


        {{-- Hero Content --}}

        <div
            class="
                absolute
                inset-x-0
                bottom-0
                p-6
                sm:p-8
                lg:inset-0
                lg:flex
                lg:items-center
                lg:p-20
            "
        >

            <div class="max-w-xl">

                <div
                    class="
                        mb-3
                        inline-flex
                        items-center
                        rounded-full
                        border
                        border-white/10
                        bg-black/20
                        px-3
                        py-1.5
                        text-[10px]
                        font-bold
                        text-white/80
                        backdrop-blur-md
                        sm:text-xs
                    "
                >
                    BarberBook
                </div>


                <h1
                    class="
                        text-2xl
                        font-black
                        leading-tight
                        sm:text-3xl
                        lg:text-5xl
                    "
                >

                    مدیریت هوشمند

                    <span class="text-orange-500">
                        آرایشگاه
                    </span>

                </h1>


                <p
                    class="
                        mt-3
                        max-w-lg
                        text-xs
                        leading-6
                        text-zinc-300
                        sm:text-sm
                        sm:leading-7
                        lg:mt-5
                        lg:text-base
                        lg:leading-8
                    "
                >

                    رزروها، مشتری‌ها و خدمات آرایشگاهت را
                    حرفه‌ای و ساده مدیریت کن.

                </p>

            </div>

        </div>

    </section>


    {{-- =========================================================
        LOGIN
    ========================================================== --}}

    <section
        class="
            relative
            z-10
            -mt-6
            w-full
            px-4
            pb-8
            sm:-mt-8
            sm:px-6
            sm:pb-10
            lg:mt-0
            lg:flex
            lg:h-screen
            lg:w-1/3
            lg:items-center
            lg:px-10
            lg:py-12
        "
    >

        <div
            class="
                mx-auto
                w-full
                max-w-md
            "
        >

            {{-- Login Card --}}

            <div
                class="
                    rounded-[28px]
                    border
                    border-zinc-800
                    bg-zinc-950
                    p-5
                    shadow-2xl
                    shadow-black/40
                    sm:p-7
                    lg:rounded-none
                    lg:border-0
                    lg:bg-transparent
                    lg:p-0
                    lg:shadow-none
                "
            >


                {{-- =================================================
                    Welcome
                    Only belongs to Login area
                ================================================== --}}

                <div class="text-center">

                    <div class="flex justify-center">

                        <div
                            class="
                                flex
                                h-14
                                w-14
                                items-center
                                justify-center
                                rounded-2xl
                                border
                                border-orange-500/20
                                bg-orange-500/10
                            "
                        >

                            <span
                                class="
                                    text-2xl
                                    font-black
                                    text-orange-500
                                "
                            >
                                B
                            </span>

                        </div>

                    </div>


                    <h2
                        class="
                            mt-5
                            text-2xl
                            font-black
                            text-white
                            sm:text-3xl
                        "
                    >
                        خوش آمدی 👋
                    </h2>


                    <p
                        class="
                            mt-2
                            text-sm
                            leading-6
                            text-zinc-400
                        "
                    >
                        برای ورود به پنل آرایشگاه وارد شو
                    </p>

                </div>


                {{-- =================================================
                    Errors
                ================================================== --}}

                @if ($errors->any())

                    <div
                        class="
                            mt-6
                            rounded-2xl
                            border
                            border-red-500/20
                            bg-red-500/10
                            p-4
                        "
                    >

                        <div class="space-y-1.5">

                            @foreach ($errors->all() as $error)

                                <p class="text-sm leading-6 text-red-400">
                                    {{ $error }}
                                </p>

                            @endforeach

                        </div>

                    </div>

                @endif


                {{-- =================================================
                    Login Form
                ================================================== --}}

                <form
                    class="
                        mt-7
                        space-y-5
                        sm:mt-8
                        sm:space-y-6
                    "
                    method="POST"
                    action="{{ route('login.store') }}"
                >

                    @csrf


                    {{-- Email --}}

                    <div>

                        <label
                            for="email"
                            class="
                                mb-2
                                block
                                text-sm
                                font-medium
                                text-zinc-300
                            "
                        >
                            ایمیل
                        </label>


                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="example@gmail.com"
                            autocomplete="email"
                            required
                            class="
                                w-full
                                rounded-xl
                                border
                                border-zinc-800
                                bg-zinc-900
                                px-4
                                py-3.5
                                text-sm
                                text-white
                                outline-none
                                transition
                                placeholder:text-zinc-600
                                focus:border-orange-500
                                focus:ring-2
                                focus:ring-orange-500/10
                            "
                        >

                    </div>


                    {{-- Password --}}

                    <div>

                        <div
                            class="
                                mb-2
                                flex
                                items-center
                                justify-between
                                gap-3
                            "
                        >

                            <label
                                for="password"
                                class="
                                    text-sm
                                    font-medium
                                    text-zinc-300
                                "
                            >
                                رمز عبور
                            </label>


                            <a
                                href="#"
                                class="
                                    text-xs
                                    font-medium
                                    text-orange-500
                                    transition
                                    hover:text-orange-400
                                "
                            >
                                فراموشی رمز؟
                            </a>

                        </div>


                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="********"
                            autocomplete="current-password"
                            required
                            class="
                                w-full
                                rounded-xl
                                border
                                border-zinc-800
                                bg-zinc-900
                                px-4
                                py-3.5
                                text-sm
                                text-white
                                outline-none
                                transition
                                placeholder:text-zinc-600
                                focus:border-orange-500
                                focus:ring-2
                                focus:ring-orange-500/10
                            "
                        >

                    </div>


                    {{-- Remember --}}

                    <label
                        class="
                            flex
                            cursor-pointer
                            items-center
                            gap-2.5
                        "
                    >

                        <input
                            type="checkbox"
                            name="remember"
                            class="
                                h-4
                                w-4
                                rounded
                                border-zinc-700
                                bg-zinc-900
                                text-orange-500
                                focus:ring-orange-500
                            "
                        >

                        <span class="text-sm text-zinc-400">
                            مرا به خاطر بسپار
                        </span>

                    </label>


                    {{-- Submit --}}

                    <button
                        type="submit"
                        class="
                            w-full
                            rounded-xl
                            bg-orange-500
                            py-3.5
                            text-sm
                            font-bold
                            text-black
                            shadow-lg
                            shadow-orange-500/20
                            transition
                            hover:bg-orange-400
                            active:scale-[0.99]
                        "
                    >
                        ورود به پنل
                    </button>

                </form>

            </div>

        </div>

    </section>

</div>

</body>

</html>
