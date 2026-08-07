
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ورود | BarberBook</title>

    @vite(['resources/css/app.css'])
</head>

<body class="bg-zinc-950 text-white">

<div class="flex min-h-screen">

    {{-- Image Side --}}
    <div class="hidden lg:block lg:w-2/3 bg-cover bg-center"
         style="background-image: url('{{ asset('images/auth/hero2.jpg') }}')">

        <div class="flex items-center h-full px-20 bg-zinc-950/70">

            <div class="max-w-xl">

                <h1 class="text-4xl font-black leading-tight">
                    مدیریت هوشمند
                    <span class="text-orange-500">
                        آرایشگاه
                    </span>
                </h1>


                <p class="mt-5 text-zinc-300 leading-8">
                    با BarberBook رزروها، مشتری‌ها و خدمات آرایشگاهت را
                    حرفه‌ای مدیریت کن.
                </p>

            </div>

        </div>

    </div>


    {{-- Login Form --}}
    <div class="flex items-center w-full lg:w-1/3 px-6">

        <div class="w-full max-w-md mx-auto">


            {{-- Logo --}}
            <div class="text-center">

                <div class="flex justify-center">

                    <div class="flex items-center justify-center
                                w-14 h-14 rounded-2xl
                                bg-orange-500/10
                                border border-orange-500/20">

                        <span class="text-2xl font-black text-orange-500">
                            B
                        </span>

                    </div>

                </div>


                <h2 class="mt-6 text-3xl font-black">
                    خوش آمدی
                </h2>


                <p class="mt-3 text-zinc-400">
                    برای ورود به پنل آرایشگاه وارد شو
                </p>

            </div>



            {{-- Errors --}}
            @if ($errors->any())

                <div class="mt-6 rounded-xl
                            border border-red-500/20
                            bg-red-500/10 p-4">

                    @foreach ($errors->all() as $error)

                        <p class="text-sm text-red-400">
                            {{ $error }}
                        </p>

                    @endforeach

                </div>

            @endif



            <form class="mt-8 space-y-6"
                  method="POST"
                  action="{{ route('login.store') }}">

                @csrf



                {{-- Email --}}
                <div>

                    <label class="block mb-2 text-sm text-zinc-300">
                        ایمیل
                    </label>


                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="example@gmail.com"

                        class="w-full px-4 py-3 rounded-xl

                        bg-zinc-900
                        border border-zinc-800

                        text-white
                        placeholder-zinc-600

                        focus:outline-none
                        focus:border-orange-500

                        transition">


                </div>




                {{-- Password --}}
                <div>


                    <div class="flex justify-between mb-2">

                        <label class="text-sm text-zinc-300">
                            رمز عبور
                        </label>


                        <a href="#"
                           class="text-sm text-orange-500 hover:text-orange-400">

                            فراموشی رمز؟

                        </a>


                    </div>



                    <input

                        type="password"

                        name="password"

                        placeholder="********"

                        class="w-full px-4 py-3 rounded-xl

                        bg-zinc-900
                        border border-zinc-800

                        text-white

                        placeholder-zinc-600

                        focus:outline-none
                        focus:border-orange-500

                        transition">

                </div>





                {{-- Remember --}}
                <div class="flex items-center gap-2">


                    <input

                        type="checkbox"

                        name="remember"

                        class="rounded
                        border-zinc-700
                        bg-zinc-900
                        text-orange-500
                        focus:ring-orange-500">


                    <span class="text-sm text-zinc-400">

                        مرا به خاطر بسپار

                    </span>


                </div>





                {{-- Submit --}}
                <button

                    type="submit"

                    class="w-full py-3 rounded-xl

                    bg-orange-500

                    text-black

                    font-bold

                    hover:bg-orange-400

                    transition

                    shadow-lg
                    shadow-orange-500/20">


                    ورود به پنل


                </button>



            </form>



        </div>

    </div>


</div>


</body>

</html>
```
