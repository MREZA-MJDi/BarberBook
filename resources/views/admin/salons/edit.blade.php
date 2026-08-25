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
                    مدیریت سالن
                </p>

            </div>

            <div class="mt-2 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                <div class="min-w-0">

                    <h1 class="truncate text-3xl font-black tracking-tight text-white sm:text-4xl">
                        ویرایش {{ $salon->name }}
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-7 text-zinc-500">
                        اطلاعات آرایشگر، سالن، لوگو و تصویر Hero را مدیریت کنید.
                    </p>

                </div>


                @if($salon->is_active)

                    <span class="inline-flex w-fit shrink-0 items-center gap-2 rounded-full border border-green-500/10 bg-green-500/5 px-4 py-2 text-xs font-bold text-green-400">
                        <span class="h-2 w-2 rounded-full bg-green-400"></span>
                        سالن فعال
                    </span>

                @else

                    <span class="inline-flex w-fit shrink-0 items-center gap-2 rounded-full border border-red-500/10 bg-red-500/5 px-4 py-2 text-xs font-bold text-red-400">
                        <span class="h-2 w-2 rounded-full bg-red-400"></span>
                        سالن غیرفعال
                    </span>

                @endif

            </div>

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
        action="{{ route('admin.salons.update', $salon) }}"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


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
                            حساب آرایشگر
                        </h2>

                        <p class="mt-1 text-xs text-zinc-600">
                            اطلاعات ورود و مالک سالن
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
                        value="{{ old('full_name', $salon->user?->full_name) }}"
                        required
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
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
                        value="{{ old('user_phone', $salon->user?->phone) }}"
                        required
                        maxlength="30"
                        inputmode="tel"
                        autocomplete="tel"
                        dir="ltr"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('user_phone')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Email --}}

                <div class="sm:col-span-2">

                    <label for="email" class="text-sm font-bold text-zinc-300">
                        ایمیل ورود
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $salon->user?->email) }}"
                        required
                        autocomplete="email"
                        dir="ltr"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
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
                        رمز عبور جدید
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        placeholder="برای حفظ رمز فعلی خالی بگذارید"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-zinc-700 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    <p class="mt-2 text-[11px] text-zinc-600">
                        در صورت پر کردن، رمز فعلی جایگزین می‌شود.
                    </p>

                    @error('password')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Password Confirmation --}}

                <div>

                    <label
                        for="password_confirmation"
                        class="text-sm font-bold text-zinc-300"
                    >
                        تکرار رمز جدید
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
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

                {{-- Name --}}

                <div class="sm:col-span-2">

                    <label for="name" class="text-sm font-bold text-zinc-300">
                        نام سالن
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $salon->name) }}"
                        required
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >

                    @error('name')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Phone --}}

                <div>

                    <label for="phone" class="text-sm font-bold text-zinc-300">
                        شماره تماس سالن
                    </label>

                    <input
                        id="phone"
                        type="tel"
                        name="phone"
                        value="{{ old('phone', $salon->phone) }}"
                        maxlength="30"
                        inputmode="tel"
                        dir="ltr"
                        class="mt-2 w-full rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm text-white outline-none transition focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
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
                        value="{{ old('instagram', $salon->instagram) }}"
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


                {{-- Slug --}}

                <div class="sm:col-span-2">

                    <label class="text-sm font-bold text-zinc-300">
                        Slug
                    </label>

                    <input
                        type="text"
                        value="{{ $salon->slug }}"
                        readonly
                        dir="ltr"
                        class="mt-2 w-full cursor-not-allowed rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3.5 text-sm text-zinc-500 outline-none"
                    >

                    <p class="mt-2 text-[11px] text-zinc-600">
                        Slug تغییر نمی‌کند تا لینک‌های موجود خراب نشوند.
                    </p>

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
                        class="mt-2 w-full resize-none rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm leading-7 text-white outline-none transition focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >{{ old('address', $salon->address) }}</textarea>

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
                        class="mt-2 w-full resize-none rounded-xl border border-zinc-800 bg-zinc-900 px-4 py-3.5 text-sm leading-7 text-white outline-none transition focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/10"
                    >{{ old('description', $salon->description) }}</textarea>

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
                            تصاویر سالن
                        </h2>

                        <p class="mt-1 text-xs text-zinc-600">
                            لوگو و تصویر Hero اختصاصی همین سالن
                        </p>

                    </div>

                </div>

            </div>


            <div class="grid gap-6 p-5 sm:grid-cols-2 sm:p-6">

                {{-- Logo --}}

                <div>

                    <label for="logo" class="text-sm font-bold text-zinc-300">
                        لوگو
                    </label>

                    @if($salon->logo)

                        <div class="mt-3 overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900">

                            <img
                                src="{{ Storage::url($salon->logo) }}"
                                alt="{{ $salon->name }}"
                                class="h-40 w-full object-contain p-4"
                            >

                        </div>

                    @else

                        <div class="mt-3 flex h-40 items-center justify-center rounded-2xl border border-dashed border-zinc-700 bg-zinc-900/50">

                            <x-lucide-image-off class="h-8 w-8 text-zinc-700" />

                        </div>

                    @endif


                    <input
                        id="logo"
                        type="file"
                        name="logo"
                        accept="image/jpeg,image/png,image/webp"
                        class="mt-3 block w-full text-sm text-zinc-500 file:mr-4 file:rounded-xl file:border-0 file:bg-orange-500/10 file:px-4 file:py-2.5 file:text-xs file:font-bold file:text-orange-400 hover:file:bg-orange-500/20"
                    >

                    <p class="mt-2 text-[11px] text-zinc-600">
                        با انتخاب تصویر جدید، لوگوی فعلی جایگزین می‌شود.
                    </p>

                    @error('logo')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                {{-- Cover --}}

                <div>

                    <label for="cover" class="text-sm font-bold text-zinc-300">
                        تصویر Hero
                    </label>

                    @if($salon->cover)

                        <div class="mt-3 overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900">

                            <img
                                src="{{ Storage::url($salon->cover) }}"
                                alt="{{ $salon->name }}"
                                class="h-40 w-full object-cover"
                            >

                        </div>

                    @else

                        <div class="mt-3 flex h-40 items-center justify-center rounded-2xl border border-dashed border-zinc-700 bg-zinc-900/50">

                            <x-lucide-image-off class="h-8 w-8 text-zinc-700" />

                        </div>

                    @endif


                    <input
                        id="cover"
                        type="file"
                        name="cover"
                        accept="image/jpeg,image/png,image/webp"
                        class="mt-3 block w-full text-sm text-zinc-500 file:mr-4 file:rounded-xl file:border-0 file:bg-orange-500/10 file:px-4 file:py-2.5 file:text-xs file:font-bold file:text-orange-400 hover:file:bg-orange-500/20"
                    >

                    <p class="mt-2 text-[11px] text-zinc-600">
                        با انتخاب تصویر جدید، Hero فعلی جایگزین می‌شود.
                    </p>

                    @error('cover')
                    <p class="mt-2 text-xs font-bold text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

            </div>

        </section>


        {{-- =====================================================
            Status + QR
        ====================================================== --}}

        <section class="grid gap-6 lg:grid-cols-2">

            {{-- Status --}}

            <div class="rounded-3xl border border-zinc-800 bg-zinc-950 p-5 sm:p-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-500/10">
                        <x-lucide-power class="h-5 w-5 text-green-400" />
                    </div>

                    <div>

                        <h3 class="font-black text-white">
                            وضعیت سالن
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-zinc-600">
                            فعال یا غیرفعال بودن سالن را تعیین کنید.
                        </p>

                    </div>

                </div>


                <label class="mt-5 flex cursor-pointer items-center justify-between gap-4 rounded-2xl border border-zinc-800 bg-zinc-900/50 p-4">

                    <div>

                        <p class="text-sm font-bold text-zinc-300">
                            سالن فعال باشد
                        </p>

                        <p class="mt-1 text-[11px] text-zinc-600">
                            سالن فعال برای مشتری قابل مشاهده و رزرو است.
                        </p>

                    </div>

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="h-5 w-5 rounded border-zinc-700 bg-zinc-900 text-orange-500 focus:ring-orange-500"
                        @checked(old('is_active', $salon->is_active))
                    >

                </label>

            </div>


            {{-- QR --}}

            <div class="rounded-3xl border border-zinc-800 bg-zinc-950 p-5 sm:p-6">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-500/10">
                        <x-lucide-qr-code class="h-5 w-5 text-orange-500" />
                    </div>

                    <div class="min-w-0">

                        <h3 class="font-black text-white">
                            QR Code
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-zinc-600">
                            QR Code با ایجاد سالن ساخته شده و ثابت می‌ماند.
                        </p>

                    </div>

                </div>


                <div class="mt-5 rounded-2xl border border-green-500/10 bg-green-500/[0.03] p-4">

                    <p class="text-[11px] font-bold text-green-400">
                        QR فعال است
                    </p>

                    <p
                        dir="ltr"
                        class="mt-2 break-all text-xs font-black tracking-wider text-zinc-400"
                    >
                        {{ $salon->qr_token }}
                    </p>

                    @if($salon->qr_token)

                        <a
                            href="{{ route('qr.image') }}"
                            target="_blank"
                            rel="noopener"
                            class="mt-4 inline-flex items-center gap-2 rounded-xl bg-orange-500 px-4 py-2.5 text-xs font-black text-black transition hover:bg-orange-400"
                        >
                            <x-lucide-qr-code class="h-4 w-4" />
                            مشاهده QR
                        </a>

                    @endif

                </div>

            </div>

        </section>


        {{-- =====================================================
            Actions
        ====================================================== --}}

        <div class="flex flex-col gap-3 rounded-3xl border border-zinc-800 bg-zinc-950 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">

            <div>

                <p class="text-sm font-black text-white">
                    ذخیره تغییرات
                </p>

                <p class="mt-1 text-xs text-zinc-600">
                    تغییرات حساب و اطلاعات سالن ثبت می‌شود.
                </p>

            </div>


            <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">

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
                    <x-lucide-save class="h-5 w-5" />
                    ذخیره تغییرات
                </button>

            </div>

        </div>

    </form>

</x-layouts.dashboard>
