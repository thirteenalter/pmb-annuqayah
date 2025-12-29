<div class="bg-white border-b border-slate-200 sticky top-[73px] z-30">
    <div class="max-w-7xl mx-auto lg:px-0 px-4">
        <div class="flex items-center gap-3 py-4 overflow-x-auto no-scrollbar outline-none">

            <a href="{{ route('admin.dashboard.pendaftar') }}"
                class="flex-none flex items-center gap-2 px-5 py-2.5 rounded-xl border transition-all duration-200 
        {{ request()->routeIs('admin.dashboard.pendaftar') ? 'bg-gray-600 border-gray-700e text-white shadow-lg shadow-indigo-100' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-white hover:border-indigo-400 hover:text-indigo-600' }}">
                <span class="material-symbols-outlined" style="font-size: medium;">
                    patient_list
                </span>
                <span class="font-semibold text-sm">List Pendaftar</span>
            </a>

            <a href="#"
                class="flex-none flex items-center gap-2 px-5 py-2.5 rounded-xl border transition-all duration-200 
        {{ request()->routeIs('admin.admisi.*') ? 'bg-gray-600 border-gray-700e text-white shadow-lg shadow-indigo-100' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-white hover:border-indigo-400 hover:text-indigo-600' }}">
                <span class="material-symbols-outlined" style="font-size: medium;">
                    other_admission
                </span>
                <span class="font-semibold text-sm">Admisi</span>
            </a>

            <a href="{{ route('admin.pembayaran') }}"
                class="flex-none flex items-center gap-2 px-5 py-2.5 rounded-xl border transition-all duration-200 
        {{ request()->routeIs('admin.pembayaran') ? 'bg-gray-600 border-gray-700e text-white shadow-lg shadow-indigo-100' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-white hover:border-indigo-400 hover:text-indigo-600' }}">
                <span class="material-symbols-outlined" style="font-size: medium;">
                    payment
                </span>
                <span class="font-semibold text-sm">Pembayaran</span>
            </a>

            <a href="#"
                class="flex-none flex items-center gap-2 px-5 py-2.5 rounded-xl border transition-all duration-200 
        {{ request()->routeIs('admin.gelombang.*') ? 'bg-gray-600 border-gray-700e text-white shadow-lg shadow-indigo-100' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-white hover:border-indigo-400 hover:text-indigo-600' }}">
                <span class="material-symbols-outlined" style="font-size: medium;">
                    waves
                </span>
                <span class="font-semibold text-sm">Gelombang</span>
            </a>

            <a href="{{ route('admin.exams.index') }}"
                class="flex-none flex items-center gap-2 px-5 py-2.5 rounded-xl border transition-all duration-200 
        {{ request()->routeIs('admin.exams.index') ? 'bg-gray-600 border-gray-700e text-white shadow-lg shadow-indigo-100' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-white hover:border-indigo-400 hover:text-indigo-600' }}">
                <span class="material-symbols-outlined" style="font-size: medium;">
                    history_edu
                </span>
                <span class="font-semibold text-sm">Computer Based Test</span>
            </a>

        </div>
    </div>
</div>

<style>
    /* Menghilangkan scrollbar tapi fungsi scroll tetap ada */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }
</style>
