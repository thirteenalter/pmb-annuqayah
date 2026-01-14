<x-app-layout>
    <x-subnavbaradmin />
    <div class="mx-auto max-w-7xl py-10 px-4">
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-800 uppercase tracking-widest">Laporan Statistik Admisi</h1>
                <p class="text-sm text-slate-500">Ringkasan data pendaftar masa nyata.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.admission.programs.index') }}"
                    class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition-all text-xs uppercase tracking-widest shadow-sm">
                    <span class="material-symbols-outlined text-sm">school</span>
                    Atur Prodi
                </a>

                <a href="{{ route('admin.admission.periods.index') }}"
                    class="flex items-center gap-2 px-6 py-3 bg-indigo-50 text-indigo-700 font-bold rounded-2xl hover:bg-indigo-100 transition-all text-xs uppercase tracking-widest border border-indigo-100">
                    <span class="material-symbols-outlined text-sm">calendar_month</span>
                    Atur Gelombang
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-indigo-600 p-8 rounded-3xl shadow-xl shadow-indigo-200">
                <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest">Total Akun Pendaftar</p>
                <h3 class="text-5xl font-black text-slate-50 mt-2">{{ $stats['total_pendaftar'] }}</h3>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-slate-200">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pembayaran Lunas</p>
                <h3 class="text-5xl font-black text-emerald-500 mt-2">{{ $stats['total_lunas'] }}</h3>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-slate-200">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Data Terverifikasi</p>
                <h3 class="text-5xl font-black text-slate-800 mt-2">{{ $stats['total_terverifikasi'] }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden">
                <div class="p-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                    <h4 class="font-bold text-slate-800">Distribusi Per Program Studi</h4>
                    <a href="{{ route('admin.admission.programs.index') }}"
                        class="text-[10px] font-bold text-indigo-600 uppercase hover:underline">Detail</a>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach ($prodiStats as $prodi)
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="font-semibold text-slate-700">{{ $prodi->name }}</span>
                                    <span class="font-black text-indigo-600">{{ $prodi->registrations_count }} <span
                                            class="text-slate-400 font-normal">Siswa</span></span>
                                </div>
                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-indigo-600 h-full transition-all duration-500"
                                        style="width: {{ $stats['total_pendaftar'] > 0 ? ($prodi->registrations_count / $stats['total_pendaftar']) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden">
                <div class="p-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                    <h4 class="font-bold text-slate-800">Distribusi Per Gelombang</h4>
                    <a href="{{ route('admin.admission.periods.index') }}"
                        class="text-[10px] font-bold text-indigo-600 uppercase hover:underline">Detail</a>
                </div>
                <div class="p-6">
                    <table class="w-full">
                        <thead>
                            <tr
                                class="text-left text-[10px] text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                <th class="pb-3 px-2">Nama Gelombang</th>
                                <th class="pb-3 px-2 text-right">Jumlah Pendaftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($periodStats as $period)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="py-4 px-2">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-700 uppercase tracking-tight">
                                                {{ $period->name }}
                                            </span>
                                            @if ($period->is_active)
                                                <span
                                                    class="text-[10px] text-green-500 font-black uppercase italic">Aktif</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-2 text-right">
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1 text-xs font-black text-slate-900 bg-slate-100 rounded-lg group-hover:bg-gray-800 group-hover:text-white transition-all">
                                            {{ number_format($period->registrations_count, 0, ',', '.') }}
                                            <span class="ml-1 text-[10px] font-medium opacity-70">Siswa</span>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-10 text-center text-sm text-slate-400 italic">
                                        Belum ada data gelombang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
