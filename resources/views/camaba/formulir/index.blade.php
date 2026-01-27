<x-app-layout>
    <x-subnavbarmaba />

    {{-- Inisialisasi selectedPeriod dari variabel $selectedPeriodId yang dikirim controller --}}
    <div x-data="{ selectedPeriod: '{{ $selectedPeriodId ?? '' }}' }" class="min-h-[80vh] bg-slate-50 py-12 px-4 flex items-center justify-center">
        <form class="max-w-7xl w-full" action="{{ route('formulir.pilih-gelombang') }}" method="POST">
            {{-- Narrowed for focus --}}
            @csrf

            <div
                class="bg-white rounded-[2.5rem] border border-slate-200 shadow-2xl shadow-slate-200/60 overflow-hidden">
                <div class="p-8 md:p-14">

                    {{-- Header --}}
                    <div class="flex flex-col items-center text-center mb-12">
                        <div
                            class="w-16 h-16 bg-indigo-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-indigo-200 rotate-3 transition-transform hover:rotate-0">
                            <span class="material-symbols-outlined text-3xl">rocket_launch</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-3 tracking-tight">Mulai Pendaftaran
                        </h1>
                        <p class="text-slate-500 text-lg max-w-md">
                            Pilih gelombang pendaftaran yang tersedia untuk melanjutkan pengisian formulir.
                        </p>
                    </div>

                    {{-- SEKSI PILIH GELOMBANG --}}
                    <div class="mb-12">
                        <label
                            class="block text-xs font-black text-slate-400 mb-6 text-center uppercase tracking-[0.2em]">
                            Gelombang Tersedia
                        </label>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($periods as $period)
                                <div @click="selectedPeriod = '{{ $period->id }}'"
                                    :class="selectedPeriod == '{{ $period->id }}' ?
                                        'border-indigo-600 bg-indigo-50/50 ring-4 ring-indigo-50' :
                                        'border-slate-200 bg-white hover:border-indigo-300 hover:bg-slate-50'"
                                    class="relative p-6 rounded-3xl border-2 cursor-pointer transition-all duration-300 group">

                                    {{-- Status Badge (Jika user sudah memilih ini sebelumnya di DB) --}}
                                    @if (isset($selectedPeriodId) && $selectedPeriodId == $period->id)
                                        <div
                                            class="absolute -top-3 left-6 bg-indigo-600 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-tighter shadow-sm">
                                            Pilihan Anda
                                        </div>
                                    @endif

                                    {{-- Radio Indicator --}}
                                    <div class="absolute top-4 right-4">
                                        <div :class="selectedPeriod == '{{ $period->id }}' ? 'bg-indigo-600 border-indigo-600' :
                                            'border-slate-300'"
                                            class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all">
                                            <div x-show="selectedPeriod == '{{ $period->id }}'"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 scale-50"
                                                class="w-2.5 h-2.5 bg-white rounded-full"></div>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="text-sm font-bold text-slate-400 uppercase tracking-wider">Gelombang</span>
                                        <h3
                                            class="text-xl font-black text-slate-800 group-hover:text-indigo-600 transition-colors">
                                            {{ $period->name }}
                                        </h3>
                                        <input type="hidden" name="registration_period_id" :value="selectedPeriod">
                                        <div class="mt-4 flex items-center gap-2">
                                            <span
                                                :class="selectedPeriod == '{{ $period->id }}' ? 'bg-indigo-600 text-white' :
                                                    'bg-slate-100 text-slate-600'"
                                                class="px-3 py-1 rounded-full text-xs font-bold transition-all">
                                                {{ $period->price == 0 ? 'GRATIS' : 'Rp ' . number_format($period->price, 0, ',', '.') }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase italic">Biaya
                                                Pendaftaran</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- Tambahkan ini di dalam tag <form> --}}

                    {{-- Persiapan Dokumen --}}
                    <div
                        class="bg-slate-50 rounded-[2rem] p-8 mb-10 border border-slate-100 flex flex-col md:flex-row gap-8 items-center">
                        <div
                            class="hidden md:flex w-24 h-24 bg-white rounded-3xl items-center justify-center shadow-sm border border-slate-100 text-slate-300">
                            <span class="material-symbols-outlined text-4xl">inventory_2</span>
                        </div>
                        <div class="flex-1">
                            <h2
                                class="text-sm font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                                Persiapan Dokumen
                            </h2>
                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-3">
                                @foreach (['KTP / Kartu Keluarga', 'Ijazah / SKL', 'Pas Foto Terbaru', 'Data Orang Tua'] as $item)
                                    <li class="flex items-center gap-3 text-slate-600 text-sm font-semibold">
                                        <span
                                            class="material-symbols-outlined text-emerald-500 text-sm font-bold">check_circle</span>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="flex flex-col items-center gap-5">
                        <button type="submit" :disabled="!selectedPeriod"
                            :class="selectedPeriod ? 'bg-indigo-600 translate-y-[-4px] shadow-xl shadow-indigo-200' :
                                'bg-slate-300 cursor-not-allowed'"
                            class="group relative w-full md:w-auto px-16 py-5 text-white font-black text-lg rounded-[2rem] transition-all duration-300 flex items-center justify-center gap-3">
                            <span>Simpan Dan Lanjutkan Pengisian</span>
                            <span
                                class="material-symbols-outlined group-hover:translate-x-2 transition-transform">arrow_forward</span>
                        </button>

                        <div class="flex items-center gap-2">
                            <div x-show="!selectedPeriod" x-transition
                                class="flex items-center gap-2 text-rose-500 font-bold text-xs uppercase tracking-tighter italic">
                                <span class="material-symbols-outlined text-sm">info</span>
                                Pilih satu gelombang untuk mengaktifkan tombol
                            </div>
                            <p x-show="selectedPeriod" x-transition class="text-xs text-slate-400 font-medium italic">
                                <span class="font-bold text-indigo-600">Terpilih:</span> Estimasi waktu pengisian 5-10
                                menit
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-slate-50/80 border-t border-slate-100 p-6 text-center text-slate-500 text-xs font-semibold">
                    Butuh bantuan teknis? <a href="#"
                        class="text-indigo-600 hover:text-indigo-800 underline decoration-2 underline-offset-4">Hubungi
                        Tim Admisi</a>
                </div>
            </div>

            {{-- Info Cards --}}
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ([['icon' => 'verified_user', 'title' => 'Data Aman', 'desc' => 'Enkripsi data standar bank.'], ['icon' => 'history_edu', 'title' => 'Auto Save', 'desc' => 'Data tersimpan otomatis.'], ['icon' => 'speed', 'title' => 'Cepat', 'desc' => 'Proses verifikasi < 24 jam.']] as $info)
                    <div class="flex flex-col items-center text-center px-4 group">
                        <span
                            class="material-symbols-outlined text-slate-300 group-hover:text-indigo-400 transition-colors mb-3 text-3xl">{{ $info['icon'] }}</span>
                        <h4 class="text-sm font-bold text-slate-800">{{ $info['title'] }}</h4>
                        <p class="text-xs text-slate-400 mt-1 leading-relaxed">{{ $info['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </form>
    </div>
</x-app-layout>
