<x-layouts.dashboard>

    {{-- =========================================================
        Header
    ========================================================== --}}

    <div class="mb-8">

        <a
            href="{{ route('admin.salons.index') }}"
            class="inline-flex items-center gap-2 text-xs font-bold text-zinc-500 transition hover:text-orange-400"
        >
            <x-lucide-arrow-right class="h-4 w-4" />
            بازگشت به سالن‌ها
        </a>

        <div class="mt-5">

            <div class="flex items-center gap-2">
                <span
                    class="h-2 w-2 rounded-full bg-orange-500 shadow-[0_0_12px_rgba(249,115,22,.7)]"
                ></span>

                <p class="text-sm font-bold text-orange-500">
                    ثبت آرایشگر جدید
                </p>
            </div>

            <h1 class="mt-2 text-3xl font-black tracking-tight text-white sm:text-4xl">
                ایجاد سالن جدید
            </h1>

            <p class="mt-2 max-w-2xl text-sm leading-7 text-zinc-500">
                حساب آرایشگر، اطلاعات سالن، لوگو و تصویر Hero را یکجا ثبت کنید.
            </p>

        </div>

    </div>


    {{-- =========================================================
        Errors
    ========================================================== --}}

    @if($errors->any())

        <div class="mb-6 rounded-2xl border border-red-500/20 bg-red-500/5 p-5">

            <div class="flex items-start gap-3">

                <x-lucide-circle-alert class="mt-0.5 h-5 w-5 shrink-0 text-red-400" />

                <div>

                    <p class="text-sm font-black text-red-400">
                        اطلاعات واردشده را بررسی کنید.
                    </p>

                    <ul class="mt-2 space-y-1">

                        @foreach($errors->all() as $error)

                            <li class="text-xs leading-6 text-red-400/80">
                                • {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- =========================================================
        Form
    ========================================================== --}}

    <form
        method="POST"
        action="{{ route('admin.salons.store') }}"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf


        {{-- =====================================================
            Barber Account
        ====================================================== --}}

        <section class="overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-950">

            <div class="border-b border-zinc-800 bg-zinc-900/40 p-5 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-orange-500/10">
                        <x-lucide-user-round class="h-5 w-5 text-orange-500" />
                    </div>

                    <div>
                        <h2 class="font-black text-white">
                            اطلاعات آرایشگر
                        </h2>

                        <p class="mt-1 text-xs text-zinc-600">
                            اطلاعات ورود به پنل سالن
                        </p>
                    </div>

                </div>

            </div>


            <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">

                {{-- Full Name --}}

                <div>

                    <label for="full_name" class="text-sm font-bold text-zinc-300">
                        نام و نام خانوادگی
                    </label>

                    <input
                        id="full_name"
                        type="text"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        required
                        autocomplete="name"
                        placeholder="مثلاً ناصر احمدی"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('full_name')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- User Phone --}}

                <div>

                    <label for="user_phone" class="text-sm font-bold text-zinc-300">
                        شماره موبایل آرایشگر
                    </label>

                    <input
                        id="user_phone"
                        type="tel"
                        name="user_phone"
                        value="{{ old('user_phone') }}"
                        required
                        maxlength="30"
                        inputmode="tel"
                        autocomplete="tel"
                        dir="ltr"
                        placeholder="0912xxxxxxx"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('user_phone')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Email --}}

                <div>

                    <label for="email" class="text-sm font-bold text-zinc-300">
                        ایمیل ورود
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        dir="ltr"
                        placeholder="naser@example.com"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('email')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Password --}}

                <div>

                    <label for="password" class="text-sm font-bold text-zinc-300">
                        رمز عبور
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="حداقل ۸ کاراکتر"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('password')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Confirmation --}}

                <div class="sm:col-span-2">

                    <label
                        for="password_confirmation"
                        class="text-sm font-bold text-zinc-300"
                    >
                        تکرار رمز عبور
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('password_confirmation')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

            </div>

        </section>


        {{-- =====================================================
            Salon Information
        ====================================================== --}}

        <section class="overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-950">

            <div class="border-b border-zinc-800 bg-zinc-900/40 p-5 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-500/10">
                        <x-lucide-store class="h-5 w-5 text-blue-400" />
                    </div>

                    <div>
                        <h2 class="font-black text-white">
                            اطلاعات سالن
                        </h2>

                        <p class="mt-1 text-xs text-zinc-600">
                            اطلاعات عمومی صفحه مشتری
                        </p>
                    </div>

                </div>

            </div>


            <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">

                {{-- Salon Name --}}

                <div class="sm:col-span-2">

                    <label for="name" class="text-sm font-bold text-zinc-300">
                        نام آرایشگاه / سالن
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="مثلاً آرایشگاه ناصر"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('name')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Salon Phone --}}

                <div>

                    <label for="phone" class="text-sm font-bold text-zinc-300">
                        شماره تماس سالن
                    </label>

                    <input
                        id="phone"
                        type="tel"
                        name="phone"
                        value="{{ old('phone') }}"
                        maxlength="30"
                        inputmode="tel"
                        dir="ltr"
                        placeholder="028xxxxxxx"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('phone')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Instagram --}}

                <div>

                    <label for="instagram" class="text-sm font-bold text-zinc-300">
                        اینستاگرام
                    </label>

                    <input
                        id="instagram"
                        type="text"
                        name="instagram"
                        value="{{ old('instagram') }}"
                        maxlength="255"
                        dir="ltr"
                        placeholder="@yourpage"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('instagram')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Address --}}

                <div class="sm:col-span-2">

                    <label for="address" class="text-sm font-bold text-zinc-300">
                        آدرس
                    </label>

                    <textarea
                        id="address"
                        name="address"
                        rows="3"
                        maxlength="1000"
                        placeholder="آدرس کامل سالن"
                        class="mt-2 w-full resize-none rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm leading-7 text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >{{ old('address') }}</textarea>

                    @error('address')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Description --}}

                <div class="sm:col-span-2">

                    <label for="description" class="text-sm font-bold text-zinc-300">
                        توضیحات سالن
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        maxlength="5000"
                        placeholder="توضیح کوتاهی درباره سالن..."
                        class="mt-2 w-full resize-none rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm leading-7 text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >{{ old('description') }}</textarea>

                    @error('description')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

            </div>

        </section>


        {{-- =====================================================
            Branding
        ====================================================== --}}

        <section class="overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-950">

            <div class="border-b border-zinc-800 bg-zinc-900/40 p-5 sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-purple-500/10">
                        <x-lucide-image class="h-5 w-5 text-purple-400" />
                    </div>

                    <div>

                        <h2 class="font-black text-white">
                            ظاهر سالن
                        </h2>

                        <p class="mt-1 text-xs text-zinc-600">
                            لوگو و تصویر Hero مخصوص همین سالن
                        </p>

                    </div>

                </div>

            </div>


            <div class="grid gap-6 p-5 sm:grid-cols-2 sm:p-6">

                {{-- Logo --}}

                <div>

                    <label
                        for="logo"
                        class="text-sm font-bold text-zinc-300"
                    >
                        لوگوی سالن
                    </label>

                    <div class="mt-3 rounded-2xl border border-dashed border-zinc-700 bg-zinc-900/50 p-4">

                        <input
                            id="logo"
                            type="file"
                            name="logo"
                            accept="image/jpeg,image/png,image/webp"
                            class="block w-full text-sm text-zinc-500 file:mr-4 file:rounded-xl file:border-0 file:bg-orange-500/10 file:px-4 file:py-2.5 file:text-xs file:font-bold file:text-orange-400 hover:file:bg-orange-500/20"
                        >

                        <p class="mt-3 text-[11px] leading-5 text-zinc-600">
                            JPG، PNG یا WEBP — حداکثر ۲MB
                        </p>

                    </div>

                    @error('logo')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Cover --}}

                <div>

                    <label
                        for="cover"
                        class="text-sm font-bold text-zinc-300"
                    >
                        تصویر Hero
                    </label>

                    <div class="mt-3 rounded-2xl border border-dashed border-zinc-700 bg-zinc-900/50 p-4">

                        <input
                            id="cover"
                            type="file"
                            name="cover"
                            accept="image/jpeg,image/png,image/webp"
                            class="block w-full text-sm text-zinc-500 file:mr-4 file:rounded-xl file:border-0 file:bg-orange-500/10 file:px-4 file:py-2.5 file:text-xs file:font-bold file:text-orange-400 hover:file:bg-orange-500/20"
                        >

                        <p class="mt-3 text-[11px] leading-5 text-zinc-600">
                            تصویر اصلی Hero — JPG، PNG یا WEBP — حداکثر ۵MB
                        </p>

                    </div>

                    @error('cover')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

            </div>

        </section>


        {{-- =====================================================
            Information
        ====================================================== --}}

        <div class="rounded-2xl border border-blue-500/10 bg-blue-500/[0.03] p-4">

            <div class="flex items-start gap-3">

                <x-lucide-info class="mt-0.5 h-5 w-5 shrink-0 text-blue-400" />

                <div>

                    <p class="text-sm font-black text-blue-300">
                        بعد از ساخت
                    </p>

                    <p class="mt-1 text-xs leading-6 text-zinc-500">
                        حساب آرایشگر، سالن، QR Code و اطلاعات ظاهری سالن
                        همزمان ساخته می‌شوند. آرایشگر بعد از ورود می‌تواند
                        QR خود را مشاهده، دانلود و چاپ کند.
                    </p>

                </div>

            </div>

        </div>


        {{-- =====================================================
            Actions
        ====================================================== --}}

        <div class="flex flex-col gap-3 rounded-3xl border border-zinc-800 bg-zinc-950 p-5 sm:flex-row sm:justify-end sm:p-6">

            <a
                href="{{ route('admin.salons.index') }}"
                class="inline-flex w-full items-center justify-center rounded-xl border border-zinc-800 px-6 py-3.5 text-sm font-bold text-zinc-400 transition hover:border-zinc-700 hover:text-white sm:w-auto"
            >
                انصراف
            </a>

            <button
                type="submit"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-orange-500 px-7 py-3.5 text-sm font-black text-black shadow-lg shadow-orange-500/10 transition hover:bg-orange-400 active:scale-[.99] sm:w-auto"
            >
                <x-lucide-plus class="h-5 w-5" />
                ساخت سالن و حساب آرایشگر
            </button>

        </div>

    </form>

</x-layouts.dashboard>
