<x-layouts.dashboard>

    {{-- =========================================================
        Page Header
    ========================================================== --}}

    <div class="mb-8">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <div class="flex items-center gap-2">

                    <span
                        class="h-2 w-2 rounded-full bg-orange-500 shadow-[0_0_12px_rgba(249,115,22,0.8)]"
                    ></span>

                    <p class="text-sm font-bold text-orange-500">
                        کنترل حساب
                    </p>

                </div>

                <h1 class="mt-2 text-3xl font-black tracking-tight text-white sm:text-4xl">
                    تنظیمات
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-zinc-500">
                    حساب کاربری، اطلاعات سالن و دسترسی سریع به QR Code اختصاصی خود را مدیریت کنید.
                </p>

            </div>


            {{-- Salon Status --}}
            <div
                class="inline-flex w-fit items-center gap-2 rounded-full border border-zinc-800 bg-zinc-950 px-4 py-2"
            >

                <span class="relative flex h-2.5 w-2.5">

                    <span
                        class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-40"
                    ></span>

                    <span
                        class="relative inline-flex h-2.5 w-2.5 rounded-full bg-green-500"
                    ></span>

                </span>

                <span class="text-xs font-bold text-zinc-300">
                    سالن فعال است
                </span>

            </div>

        </div>

    </div>


    {{-- =========================================================
        Flash Success
    ========================================================== --}}

    @if(session('success'))

        <div
            class="mb-6 rounded-2xl border border-green-500/20 bg-green-500/5 px-5 py-4"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-green-500/10"
                >

                    <x-lucide-check-circle-2
                        class="h-5 w-5 text-green-500"
                    />

                </div>

                <p class="text-sm font-bold text-green-400">
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif


    {{-- =========================================================
        Validation Errors
    ========================================================== --}}

    @if($errors->any())

        <div
            class="mb-6 rounded-2xl border border-red-500/20 bg-red-500/5 px-5 py-4"
        >

            <div class="flex items-start gap-3">

                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-500/10"
                >

                    <x-lucide-circle-alert
                        class="h-5 w-5 text-red-400"
                    />

                </div>

                <div>

                    <p class="text-sm font-bold text-red-400">
                        لطفاً خطاهای فرم را بررسی کنید.
                    </p>

                    <ul class="mt-2 space-y-1">

                        @foreach($errors->all() as $error)

                            <li class="text-xs leading-6 text-red-300">
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- =========================================================
        Main Grid
    ========================================================== --}}

    <div class="grid gap-6 xl:grid-cols-12">


        {{-- =====================================================
            QR HERO
        ====================================================== --}}

        <div
            class="relative overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-950 xl:col-span-7"
        >

            {{-- Background Glow --}}
            <div
                class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-orange-500/10 blur-3xl"
            ></div>

            <div
                class="pointer-events-none absolute -bottom-32 -left-20 h-64 w-64 rounded-full bg-orange-500/5 blur-3xl"
            ></div>


            <div class="relative p-6 sm:p-8">

                {{-- Header --}}
                <div class="flex items-start justify-between gap-4">

                    <div>

                        <div
                            class="mb-4 flex h-11 w-11 items-center justify-center rounded-2xl border border-orange-500/20 bg-orange-500/10"
                        >

                            <x-lucide-qr-code
                                class="h-5 w-5 text-orange-500"
                            />

                        </div>

                        <p class="text-xs font-bold uppercase tracking-widest text-orange-500">
                            اختصاصی سالن
                        </p>

                        <h2 class="mt-2 text-2xl font-black text-white">
                            QR Code شما
                        </h2>

                        <p class="mt-2 max-w-md text-sm leading-6 text-zinc-500">
                            مشتری فقط با اسکن این کد وارد صفحه سالن شما می‌شود
                            و می‌تواند مستقیماً وقت رزرو کند.
                        </p>

                    </div>

                </div>


                {{-- QR Area --}}
                <div class="mt-8 flex flex-col items-center gap-8 rounded-2xl border border-zinc-800 bg-black/40 p-6 sm:flex-row">

                    {{-- QR Preview --}}
                    <div
                        class="flex h-44 w-44 shrink-0 items-center justify-center rounded-2xl bg-white p-4 shadow-2xl shadow-orange-500/5"
                    >

                        @if($salon)

                            <img
                                src="{{ route('qr.index') }}"
                                alt="QR Code {{ $salon->name }}"
                                class="h-full w-full object-contain"
                            >

                        @else

                            <x-lucide-qr-code
                                class="h-24 w-24 text-zinc-300"
                            />

                        @endif

                    </div>


                    {{-- QR Info --}}
                    <div class="min-w-0 flex-1">

                        <div class="flex items-center gap-2">

                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-xl bg-orange-500/10"
                            >

                                <x-lucide-store
                                    class="h-4 w-4 text-orange-500"
                                />

                            </span>

                            <span class="truncate font-bold text-white">
                                {{ $salon?->name ?? 'سالن شما' }}
                            </span>

                        </div>


                        <div class="mt-4 rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3">

                            <p class="text-xs text-zinc-600">
                                لینک رزرو اختصاصی
                            </p>

                            <p class="mt-1 truncate text-xs font-medium text-zinc-400">
                                {{ $salon?->slug ?? 'booking-link' }}
                            </p>

                        </div>


                        <div class="mt-4 flex flex-wrap gap-3">

                            <a
                                href="{{ route('qr.download') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-4 py-2.5 text-sm font-black text-black transition hover:bg-orange-400"
                            >

                                <x-lucide-download
                                    class="h-4 w-4"
                                />

                                دانلود QR

                            </a>


                            <a
                                href="{{ route('qr.index') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-zinc-700 bg-zinc-900 px-4 py-2.5 text-sm font-bold text-zinc-300 transition hover:border-zinc-600 hover:bg-zinc-800 hover:text-white"
                            >

                                <x-lucide-eye
                                    class="h-4 w-4"
                                />

                                مشاهده

                            </a>

                        </div>

                    </div>

                </div>


                {{-- QR Hint --}}
                <div class="mt-5 flex gap-3 rounded-2xl border border-orange-500/10 bg-orange-500/[0.03] p-4">

                    <x-lucide-lightbulb
                        class="mt-0.5 h-4 w-4 shrink-0 text-orange-500"
                    />

                    <p class="text-xs leading-6 text-zinc-500">
                        این QR Code را می‌توانید روی شیشه سالن، کارت ویزیت،
                        استند یا میز پذیرش قرار دهید تا مشتری بدون تماس تلفنی
                        وارد فرآیند رزرو شود.
                    </p>

                </div>

            </div>

        </div>


        {{-- =====================================================
            ACCOUNT
        ====================================================== --}}

        <div class="space-y-6 xl:col-span-5">


            {{-- Account Card --}}
            <div
                class="rounded-3xl border border-zinc-800 bg-zinc-950 p-6"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-2xl bg-zinc-900"
                        >

                            <x-lucide-user-round
                                class="h-5 w-5 text-zinc-300"
                            />

                        </div>

                        <h2 class="mt-4 text-lg font-black text-white">
                            حساب کاربری
                        </h2>

                        <p class="mt-1 text-sm text-zinc-500">
                            اطلاعات ورود و مشخصات شما
                        </p>

                    </div>

                    <span class="rounded-full bg-green-500/10 px-3 py-1.5 text-[11px] font-bold text-green-400">
                        فعال
                    </span>

                </div>


                <div class="mt-6 divide-y divide-zinc-800">

                    {{-- Name --}}
                    <div class="flex items-center justify-between gap-4 py-4">

                        <div class="flex items-center gap-3">

                            <x-lucide-user
                                class="h-4 w-4 text-zinc-600"
                            />

                            <span class="text-sm text-zinc-500">
                                نام
                            </span>

                        </div>

                        <span class="max-w-[55%] truncate text-sm font-bold text-zinc-200">
                            {{ $user->full_name ?? 'ثبت نشده' }}
                        </span>

                    </div>


                    {{-- Phone --}}
                    <div class="flex items-center justify-between gap-4 py-4">

                        <div class="flex items-center gap-3">

                            <x-lucide-phone
                                class="h-4 w-4 text-zinc-600"
                            />

                            <span class="text-sm text-zinc-500">
                                موبایل
                            </span>

                        </div>

                        <span class="max-w-[55%] truncate text-sm font-bold text-zinc-200">
                            {{ $user->phone ?? 'ثبت نشده' }}
                        </span>

                    </div>


                    {{-- Email --}}
                    <div class="flex items-center justify-between gap-4 py-4">

                        <div class="flex items-center gap-3">

                            <x-lucide-mail
                                class="h-4 w-4 text-zinc-600"
                            />

                            <span class="text-sm text-zinc-500">
                                ایمیل
                            </span>

                        </div>

                        <span class="max-w-[55%] truncate text-sm font-bold text-zinc-200">
                            {{ $user->email ?? 'ثبت نشده' }}
                        </span>

                    </div>

                </div>


                <a
                    href="{{ route('profile.edit') }}"
                    class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl border border-zinc-700 bg-zinc-900 py-3 text-sm font-bold text-zinc-200 transition hover:border-orange-500/30 hover:bg-orange-500/5 hover:text-orange-400"
                >

                    <x-lucide-pencil
                        class="h-4 w-4"
                    />

                    ویرایش پروفایل

                </a>

            </div>


            {{-- Security --}}
            <div
                class="rounded-3xl border border-zinc-800 bg-zinc-950 p-6"
            >

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-2xl bg-zinc-900"
                    >

                        <x-lucide-shield-check
                            class="h-5 w-5 text-zinc-300"
                        />

                    </div>

                    <div>

                        <h2 class="font-black text-white">
                            امنیت حساب
                        </h2>

                        <p class="mt-1 text-xs text-zinc-500">
                            رمز عبور خود را امن نگه دارید.
                        </p>

                    </div>

                </div>


                <div class="mt-5 flex items-center justify-between rounded-2xl border border-zinc-800 bg-black/20 p-4">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-zinc-900"
                        >

                            <x-lucide-lock
                                class="h-4 w-4 text-zinc-500"
                            />

                        </div>

                        <div>

                            <p class="text-sm font-bold text-zinc-300">
                                رمز عبور
                            </p>

                            <p class="mt-1 text-[11px] text-zinc-600">
                                برای امنیت بیشتر تغییر دهید.
                            </p>

                        </div>

                    </div>


                    <a
                        href="{{ route('profile.edit') }}"
                        class="text-xs font-bold text-orange-500 transition hover:text-orange-400"
                    >
                        تغییر
                    </a>

                </div>

            </div>

        </div>


        {{-- =====================================================
            SALON MANAGEMENT
        ====================================================== --}}

        <div
            class="rounded-3xl border border-zinc-800 bg-zinc-950 p-6 xl:col-span-8"
        >

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-500/10"
                    >

                        <x-lucide-store
                            class="h-5 w-5 text-orange-500"
                        />

                    </div>

                    <div>

                        <p class="text-xs font-bold text-orange-500">
                            مدیریت سالن
                        </p>

                        <h2 class="mt-1 text-xl font-black text-white">
                            {{ $salon?->name ?? 'سالن شما' }}
                        </h2>

                    </div>

                </div>

            </div>


            {{-- Salon Form --}}
            @if($salon)

                <form
                    action="{{ route('settings.update') }}"
                    method="POST"
                    class="mt-6"
                >

                    @csrf

                    @method('PUT')


                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                        {{-- Name --}}
                        <div class="sm:col-span-2 lg:col-span-3">

                            <label
                                for="name"
                                class="mb-2 block text-xs font-bold text-zinc-500"
                            >
                                نام سالن
                            </label>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $salon->name) }}"
                                required
                                maxlength="255"
                                class="w-full rounded-2xl border border-zinc-800 bg-black/20 px-4 py-3 text-sm font-bold text-zinc-200 outline-none transition placeholder:text-zinc-700 focus:border-orange-500"
                                placeholder="نام سالن"
                            >

                            @error('name')

                            <p class="mt-2 text-xs text-red-400">
                                {{ $message }}
                            </p>

                            @enderror

                        </div>


                        {{-- Description --}}
                        <div class="sm:col-span-2 lg:col-span-3">

                            <label
                                for="description"
                                class="mb-2 block text-xs font-bold text-zinc-500"
                            >
                                معرفی سالن
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                maxlength="2000"
                                class="w-full resize-none rounded-2xl border border-zinc-800 bg-black/20 px-4 py-3 text-sm leading-7 text-zinc-200 outline-none transition placeholder:text-zinc-700 focus:border-orange-500"
                                placeholder="یک توضیح کوتاه درباره سالن..."
                            >{{ old('description', $salon->description) }}</textarea>

                            @error('description')

                            <p class="mt-2 text-xs text-red-400">
                                {{ $message }}
                            </p>

                            @enderror

                            <p class="mt-2 text-[11px] text-zinc-600">
                                این متن در Hero صفحه عمومی سالن نمایش داده می‌شود.
                            </p>

                        </div>


                        {{-- Phone --}}
                        <div>

                            <label
                                for="phone"
                                class="mb-2 block text-xs font-bold text-zinc-500"
                            >
                                تلفن سالن
                            </label>

                            <input
                                id="phone"
                                name="phone"
                                type="text"
                                value="{{ old('phone', $salon->phone) }}"
                                maxlength="30"
                                class="w-full rounded-2xl border border-zinc-800 bg-black/20 px-4 py-3 text-sm font-bold text-zinc-200 outline-none transition placeholder:text-zinc-700 focus:border-orange-500"
                                placeholder="0912..."
                            >

                            @error('phone')

                            <p class="mt-2 text-xs text-red-400">
                                {{ $message }}
                            </p>

                            @enderror

                        </div>


                        {{-- Address --}}
                        <div>

                            <label
                                for="address"
                                class="mb-2 block text-xs font-bold text-zinc-500"
                            >
                                آدرس
                            </label>

                            <textarea
                                id="address"
                                name="address"
                                rows="1"
                                maxlength="1000"
                                class="w-full resize-none rounded-2xl border border-zinc-800 bg-black/20 px-4 py-3 text-sm leading-7 text-zinc-200 outline-none transition placeholder:text-zinc-700 focus:border-orange-500"
                                placeholder="آدرس سالن"
                            >{{ old('address', $salon->address) }}</textarea>

                            @error('address')

                            <p class="mt-2 text-xs text-red-400">
                                {{ $message }}
                            </p>

                            @enderror

                        </div>


                        {{-- Instagram --}}
                        <div>

                            <label
                                for="instagram"
                                class="mb-2 block text-xs font-bold text-zinc-500"
                            >
                                Instagram
                            </label>

                            <input
                                id="instagram"
                                name="instagram"
                                type="text"
                                value="{{ old('instagram', $salon->instagram) }}"
                                maxlength="255"
                                class="w-full rounded-2xl border border-zinc-800 bg-black/20 px-4 py-3 text-sm font-bold text-zinc-200 outline-none transition placeholder:text-zinc-700 focus:border-orange-500"
                                placeholder="@username"
                            >

                            @error('instagram')

                            <p class="mt-2 text-xs text-red-400">
                                {{ $message }}
                            </p>

                            @enderror

                        </div>

                    </div>


                    {{-- Save Row --}}
                    <div class="mt-6 flex flex-col gap-3 border-t border-zinc-800 pt-5 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-2 text-xs text-zinc-600">

                            <x-lucide-info
                                class="h-4 w-4"
                            />

                            <span>
                                تغییرات در صفحه عمومی سالن نیز نمایش داده می‌شود.
                            </span>

                        </div>


                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-5 py-3 text-sm font-black text-black transition hover:bg-orange-400"
                        >

                            <x-lucide-save
                                class="h-4 w-4"
                            />

                            ذخیره اطلاعات سالن

                        </button>

                    </div>

                </form>

            @else

                <div
                    class="mt-6 rounded-2xl border border-red-500/10 bg-red-500/[0.03] p-5"
                >

                    <p class="text-sm font-bold text-red-400">
                        برای این حساب هنوز سالنی ثبت نشده است.
                    </p>

                </div>

            @endif

        </div>


        {{-- =====================================================
            QUICK STATUS
        ====================================================== --}}

        <div
            class="relative overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-950 p-6 xl:col-span-4"
        >

            <div
                class="pointer-events-none absolute -bottom-16 -right-16 h-40 w-40 rounded-full bg-green-500/5 blur-3xl"
            ></div>


            <div class="relative">

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-2xl bg-green-500/10"
                    >

                        <x-lucide-activity
                            class="h-5 w-5 text-green-500"
                        />

                    </div>

                    <div>

                        <h2 class="font-black text-white">
                            وضعیت سالن
                        </h2>

                        <p class="mt-1 text-xs text-zinc-500">
                            وضعیت فعلی دریافت رزرو
                        </p>

                    </div>

                </div>


                <div class="mt-7">

                    <div class="flex items-center gap-3">

                        <span class="relative flex h-3 w-3">

                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-30"
                            ></span>

                            <span
                                class="relative inline-flex h-3 w-3 rounded-full bg-green-500"
                            ></span>

                        </span>

                        <span class="text-lg font-black text-white">
                            آماده دریافت رزرو
                        </span>

                    </div>


                    <p class="mt-3 text-sm leading-6 text-zinc-500">
                        مشتریان می‌توانند از طریق صفحه عمومی سالن برای شما وقت رزرو کنند.
                    </p>

                </div>


                <div class="mt-6 rounded-2xl border border-green-500/10 bg-green-500/[0.03] p-4">

                    <div class="flex items-start gap-3">

                        <x-lucide-check-circle-2
                            class="mt-0.5 h-4 w-4 shrink-0 text-green-500"
                        />

                        <p class="text-xs leading-6 text-zinc-500">
                            سیستم رزرو آنلاین فعال است و QR Code شما قابل استفاده است.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            DANGER ZONE
        ====================================================== --}}

        <div
            class="rounded-3xl border border-red-500/10 bg-red-500/[0.015] p-6 xl:col-span-12"
        >

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-red-500/10"
                    >

                        <x-lucide-triangle-alert
                            class="h-5 w-5 text-red-400"
                        />

                    </div>

                    <div>

                        <h2 class="font-black text-white">
                            منطقه حساس
                        </h2>

                        <p class="mt-1 max-w-2xl text-sm leading-6 text-zinc-500">
                            در صورت تعطیلی موقت سالن، می‌توانید دریافت رزروهای جدید را متوقف کنید.
                            اطلاعات و رزروهای قبلی حذف نخواهند شد.
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    class="shrink-0 rounded-xl border border-red-500/20 bg-red-500/5 px-4 py-2.5 text-sm font-bold text-red-400 transition hover:bg-red-500/10"
                >
                    غیرفعال کردن سالن
                </button>

            </div>

        </div>

    </div>

</x-layouts.dashboard>
