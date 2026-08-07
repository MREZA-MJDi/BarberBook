<div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-5">


    <form method="GET"
          class="grid grid-cols-1 gap-4 md:grid-cols-4">


        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="جستجوی نام یا شماره مشتری..."
            class="rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3 text-sm text-white placeholder:text-zinc-500 focus:border-orange-500 focus:outline-none">



        <select
            name="status"
            class="rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3 text-sm text-white">


            <option value="">
                همه وضعیت‌ها
            </option>


            <option value="pending"
                    @selected(request('status') === 'pending')>
            در انتظار
            </option>


            <option value="approved"
                    @selected(request('status') === 'approved')>
            تایید شده
            </option>


            <option value="completed"
                    @selected(request('status') === 'completed')>
            تکمیل شده
            </option>


            <option value="rejected"
                    @selected(request('status') === 'rejected')>
            رد شده
            </option>


        </select>




        <input
            type="date"
            name="date"
            value="{{ request('date') }}"
            class="rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3 text-sm text-white">





        <button
            class="rounded-xl bg-orange-500 px-5 py-3 text-sm font-black text-black transition hover:bg-orange-400">

            فیلتر

        </button>



    </form>


</div>
