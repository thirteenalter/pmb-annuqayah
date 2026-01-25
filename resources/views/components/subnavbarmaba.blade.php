<div class="bg-white border-b border-slate-200 sticky top-[70px] z-30">
    <div class="max-w-7xl mx-auto lg:px-0 px-4">
        <div class="flex items-center gap-3 py-4 overflow-x-auto no-scrollbar outline-none">

            <a href="{{ route('formulir') }}"
                class="flex-none flex items-center gap-2 px-5 py-2.5 rounded-xl border transition-all duration-200 {{ request()->routeIs('formulir') ? 'bg-slate-500 border-slate-700 text-white shadow-lg shadow-slate-100' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-white hover:border-indigo-400 hover:text-indigo-600' }}">
                <span class="material-symbols-outlined !text-[20px]">home</span>
                <span class="text-sm font-bold whitespace-nowrap">Index</span>
            </a>

            <a href="{{ route('student.index') }}"
                class="flex-none flex items-center gap-2 px-5 py-2.5 rounded-xl border transition-all duration-200 {{ request()->routeIs('isi-form') ? 'bg-slate-500 border-slate-700 text-white shadow-lg shadow-slate-100' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-white hover:border-indigo-400 hover:text-indigo-600' }}">
                <span class="material-symbols-outlined !text-[20px]">assignment_add</span>
                <span class="text-sm font-bold whitespace-nowrap">Data Camaba</span>
            </a>

            <a href="{{ route('isi-dokumen') }}"
                class="flex-none flex items-center gap-2 px-5 py-2.5 rounded-xl border transition-all duration-200 {{ request()->routeIs('isi-dokumen') ? 'bg-slate-500 border-slate-700 text-white shadow-lg shadow-slate-100' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-white hover:border-indigo-400 hover:text-indigo-600' }}">
                <span class="material-symbols-outlined !text-[20px]">description</span>
                <span class="text-sm font-bold whitespace-nowrap">Upload Dokumen</span>
            </a>

            @php
                $user = Auth::user();
            @endphp

            @if ($user->isDataLengkap())
                <a href="{{ route('formulir.pembayaran') }}"
                    class="flex-none flex items-center gap-2 px-5 py-2.5 rounded-xl border transition-all duration-200 {{ request()->routeIs('formulir.pembayaran') ? 'bg-slate-500 border-slate-700 text-white shadow-lg shadow-slate-100' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-white hover:border-indigo-400 hover:text-indigo-600' }}">
                    <span class="material-symbols-outlined !text-[20px]">payments</span>
                    <span class="text-sm font-bold whitespace-nowrap">Pembayaran</span>
                </a>
            @endif

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
