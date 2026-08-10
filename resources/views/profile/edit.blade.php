@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-background px-4 py-6 sm:px-6 lg:px-8">


        <div class="mx-auto max-w-4xl">

            {{-- =========================================================
                 Page Header
            ========================================================== --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-white">
                    پروفایل من
                </h1>

                <p class="mt-2 text-sm text-zinc-400">
                    اطلاعات حساب کاربری خود را مشاهده و ویرایش کنید.
                </p>
            </div>


            {{-- =========================================================
                 Success Message
            ========================================================== --}}
            @if(session('success'))

                <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-500/20 bg-green-500/10 px-4 py-3 text-sm text-green-400">

                    <svg
                        class="h-5 w-5 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    <span>
                {{ session('success') }}
            </span>

                </div>

            @endif


            {{-- =========================================================
                 Validation Errors
            ========================================================== --}}
            @if($errors->any())

                <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-4 text-sm text-red-400">

                    <div class="mb-2 font-semibold">
                        لطفاً خطاهای زیر را بررسی کنید:
                    </div>

                    <ul class="space-y-1 pr-5 list-disc">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =========================================================
                 Profile Card
            ========================================================== --}}
            <div class="overflow-hidden rounded-2xl border border-white/10 bg-surface">


                {{-- =====================================================
                     Profile Header
                ====================================================== --}}
                <div class="border-b border-white/10 px-6 py-6">

                    <div class="flex items-center gap-4">

                        {{-- Avatar --}}
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-orange-500/10 text-xl font-bold text-orange-400">

                            {{ mb_substr($user->full_name ?? 'U', 0, 1) }}

                        </div>


                        {{-- User Info --}}
                        <div class="min-w-0">

                            <h2 class="truncate text-lg font-semibold text-white">
                                {{ $user->full_name ?? 'کاربر' }}
                            </h2>

                            <p class="mt-1 truncate text-sm text-zinc-400">
                                {{ $user->email }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                     Profile Form
                ====================================================== --}}
                <form
                    action="{{ route('profile.update') }}"
                    method="POST"
                    class="space-y-6 p-6"
                >

                    @csrf
                    @method('PUT')


                    {{-- =================================================
                         Full Name
                    ================================================== --}}
                    <div>

                        <label
                            for="full_name"
                            class="mb-2 block text-sm font-medium text-zinc-200"
                        >
                            نام و نام خانوادگی
                        </label>

                        <input
                            id="full_name"
                            type="text"
                            name="full_name"
                            value="{{ old('full_name', $user->full_name) }}"
                            required
                            autocomplete="name"
                            placeholder="نام و نام خانوادگی"
                            class="w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white outline-none transition placeholder:text-zinc-600 focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                        >

                        @error('full_name')

                        <p class="mt-2 text-xs text-red-400">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- =================================================
                         Phone
                    ================================================== --}}
                    <div>

                        <label
                            for="phone"
                            class="mb-2 block text-sm font-medium text-zinc-200"
                        >
                            شماره موبایل
                        </label>

                        <input
                            id="phone"
                            type="text"
                            name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            autocomplete="tel"
                            placeholder="09xxxxxxxxx"
                            class="w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white outline-none transition placeholder:text-zinc-600 focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                        >

                        @error('phone')

                        <p class="mt-2 text-xs text-red-400">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- =================================================
                         Email
                    ================================================== --}}
                    <div>

                        <label
                            for="email"
                            class="mb-2 block text-sm font-medium text-zinc-200"
                        >
                            ایمیل
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            autocomplete="email"
                            placeholder="example@email.com"
                            class="w-full rounded-xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white outline-none transition placeholder:text-zinc-600 focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                        >

                        @error('email')

                        <p class="mt-2 text-xs text-red-400">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- =================================================
                         Account Information
                    ================================================== --}}
                    <div class="rounded-xl border border-white/5 bg-black/10 p-4">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm font-medium text-zinc-200">
                                    وضعیت حساب
                                </p>

                                <p class="mt-1 text-xs text-zinc-500">
                                    حساب کاربری شما فعال است.
                                </p>
                            </div>


                            <span class="rounded-full bg-green-500/10 px-3 py-1 text-xs font-medium text-green-400">
                        فعال
                    </span>

                        </div>

                    </div>


                    {{-- =================================================
                         Actions
                    ================================================== --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-white/10 pt-6 sm:flex-row sm:items-center sm:justify-end">

                        <a
                            href="{{ route('dashboard') }}"
                            class="rounded-xl border border-white/10 px-5 py-3 text-center text-sm font-medium text-zinc-300 transition hover:bg-white/5 hover:text-white"
                        >
                            انصراف
                        </a>


                        <button
                            type="submit"
                            class="rounded-xl bg-orange-500 px-6 py-3 text-sm font-semibold text-black transition hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-500/50"
                        >
                            ذخیره تغییرات
                        </button>

                    </div>

                </form>

            </div>

        </div>


    </div>

@endsection
